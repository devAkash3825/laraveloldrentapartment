<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoteDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyInfo;
use App\Models\GalleryType;
use App\Models\GalleryDetails;
use App\Services\SearchService;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\ListingCollection;
use App\Repositories\PropertyDetailsRepository;
use App\Repositories\RenterInfoRepository;
use App\Models\UserProperty;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Login;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\AdminDetail;
use App\Models\Source;
use App\Models\RenterInfo;
use App\Models\Notification;
use App\Events\RenterMessageSent;
use App\Events\ManagerMessageSent;
use App\Models\NotifyDetail;

class UserNotesController extends Controller
{
    public function addNotes(Request $request)
    {
        try {
            $sender = Auth::guard('renter')->user();
            if (!$sender) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }

            $propertyId = $request->propertyId;
            $message = $request->message;
            
            // Context: which renter is this note for?
            $renterId = ($sender->user_type == 'M' && $request->has('renter_id')) ? $request->input('renter_id') : $sender->Id;

            if (!$renterId) {
                return response()->json(['success' => false, 'message' => 'Renter context missing']);
            }

            // Find existing referral record to link
            $referral = NotifyDetail::where('renter_id', $renterId)->where('property_id', $propertyId)->first();

            NoteDetail::create([
                'user_id' => $sender->Id,
                'sender_id' => $sender->Id,
                'property_id' => $propertyId,
                'message' => $message,
                'send_time' => now(),
                'renter_id' => $renterId,
                'referral_id' => $referral ? $referral->notification_id : null,
            ]);

            // Create notification for Admin/Manager
            $property = PropertyInfo::where('Id', $propertyId)->first();
            if ($property) {
                $propertyName = $property->PropertyName ?? 'Property';
                $notifMessage = "<strong>{$sender->UserName}</strong> added a note to <strong>{$propertyName}</strong>.";
            
            if ($sender->user_type != 'M') {
                // Renter added note: Notify Manager & Admin
                if ($property->UserId) {
                    Notification::create(['from_id' => $sender->Id, 'form_user_type' => 'R', 'to_id' => $property->UserId, 'to_user_type' => 'M', 'property_id' => $propertyId, 'message' => $notifMessage, 'seen' => 0, 'CreatedOn' => now()]);
                }

                $renterInfo = RenterInfo::where('Login_ID', $sender->Id)->first();
                $adminId = $renterInfo->added_by ?? null;
                if ($adminId) {
                    Notification::create(['from_id' => $sender->Id, 'form_user_type' => 'R', 'to_id' => $adminId, 'to_user_type' => 'A', 'property_id' => $propertyId, 'message' => $notifMessage, 'seen' => 0, 'CreatedOn' => now()]);
                }
            } else {
                // Manager added note: Notify Admin (and optionally Renter)
                $renterInfo = RenterInfo::where('Login_ID', $renterId)->first();
                $adminId = $renterInfo->added_by ?? null;
                
                if ($adminId) {
                    // Notify Admin via persistent notification
                    Notification::create(['from_id' => $sender->Id, 'form_user_type' => 'M', 'to_id' => $adminId, 'to_user_type' => 'A', 'property_id' => $propertyId, 'message' => $notifMessage, 'seen' => 0, 'CreatedOn' => now()]);
                    
                    // Email Agent so they can track lead progress (as requested)
                    $admin = AdminDetail::find($adminId);
                    if ($admin && $admin->email) {
                        try {
                            $rName = ($renterInfo->Firstname ?? '') . ' ' . ($renterInfo->Lastname ?? '');
                            \Illuminate\Support\Facades\Mail::raw("Manager {$sender->UserName} added a note for referred lead {$rName} on property {$property->PropertyName}:\n\n{$message}", function($m) use ($admin) {
                                $m->to($admin->email)->subject('Referral Update: Lead Activity Note');
                            });
                        } catch (\Exception $e) {
                            \Log::error('Failed to send lead update email to admin: ' . $e->getMessage());
                        }
                    }
                }
                
                // Also notify Renter via formal notification
                $renterLogin = Login::find($renterId);
                if ($renterLogin) {
                    $renterLogin->notify(new \App\Notifications\ManagerNoteNotification($sender, $property, $message));
                }

                // Internal persistent notification for UI
                Notification::create(['from_id' => $sender->Id, 'form_user_type' => 'M', 'to_id' => $renterId, 'to_user_type' => 'R', 'property_id' => $propertyId, 'message' => $notifMessage, 'seen' => 0, 'CreatedOn' => now()]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Note added successfully!']);
        } catch (\Exception $e) {
            \Log::error('Add Note Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while adding the note.']);
        }
    }

    public function getNoteDetail(Request $request)
    {
        try {
            $user = Auth::guard('renter')->user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
            
            $userid = $user->Id;
            $propertyId = $request->propertyId;
            
            $getdetails = NoteDetail::where('property_id', $propertyId)
                ->where(function($query) use ($userid) {
                    // Fetch notes where the user is either the sender OR the renter associated with the note context
                    $query->where('user_id', $userid)
                          ->orWhere('renter_id', $userid);
                })
                ->with('user') // Eager load the user who created the note
                ->orderBy('send_time', 'asc')
                ->get();
                
            // Transform the data to ensure it is correctly serialized for JSON
            $formattedDetails = $getdetails->map(function ($note) {
                $userType = $note->user->user_type ?? '';
                $colorClass = 'text-danger'; // Default to Red (Renter)
                $senderName = $note->user->UserName ?? 'Unknown';

                // Check if it was an admin note (usually admin notes don't have a linked 'Login' user or have admin_id set)
                if (!$note->user && $note->admin_id) {
                    $colorClass = 'text-primary';
                    $senderName = 'Admin';
                } else if ($userType === 'A') {
                    $colorClass = 'text-primary'; // Blue for Admin
                } else if ($userType === 'M') {
                    $colorClass = 'text-dark'; // Black for Manager
                }

                return [
                    'note_id' => $note->note_id,
                    'message' => $note->message,
                    'send_time' => $note->send_time ? $note->send_time->toDateTimeString() : null,
                    'color_class' => $colorClass,
                    'sender_name' => $senderName,
                    'user_type' => $userType
                ];
            });

            return response()->json([
                'success' => true,
                'notedetails' => $formattedDetails
            ]);
        } catch (\Exception $e) {
            \Log::error('Get Note Detail Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error loading notes.']);
        }
    }

    public function messagePage()
    {
        $user = Auth::guard('renter')->user();
        
        if ($user->user_type == 'M') {
            // Manager View: show all threads where they are manager or property owner
            $ownedPropertyIds = PropertyInfo::where('UserId', $user->Id)->pluck('Id')->toArray();
            $messages = Message::where(function($query) use ($user, $ownedPropertyIds) {
                    $query->where('managerId', $user->Id)
                          ->orWhereIn('propertyId', $ownedPropertyIds);
                })
                ->with(['loginrenter.renterinfo', 'propertyinfo'])
                ->orderBy('updated_at', 'desc')
                ->get();
            return view('user.referredRenter', ['rec' => $messages]);
        } else {
            // Renter View: show all their property inquiries
            $messages = Message::where('renterId', $user->Id)
                ->with(['propertyinfo', 'conversation'])
                ->orderBy('updated_at', 'desc')
                ->get();
            return view('user.referredRenter', ['rec' => $messages]); // Reusing the list view for now
        }
    }
    public function sendMessagePage($id)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $user_type = Auth::guard('renter')->user()->user_type;

        $messageNotes = Message::where('propertyId', $id)->where('renterId', $userid)
            ->with(['conversation', 'propertyinfo'])
            ->get();
        
        // Mark as read for Renter
        foreach ($messageNotes as $thread) {
            $thread->conversation()->whereNull('renterId')->update(['is_read' => true]);
        }
        

        $getPropertyInfo = PropertyInfo::where('Id', $id)->with('gallerytype.gallerydetail')->first();
        return view(
            'user.messages',
            [
                'messages' => $messageNotes,
                'getPropertyInfo' => $getPropertyInfo
            ]
        );
    }

    public function managerMessagePage($p_id, $r_id)
    {
        try {
            $user = Auth::guard('renter')->user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login as a manager.');
            }

            Log::info("Manager ID: {$user->Id} attempting to access thread for Property: {$p_id}, Renter: {$r_id}");
            
            $messageNotes = Message::where('propertyId', $p_id)->where('renterId', $r_id)
                ->with(['conversation', 'propertyinfo'])
                ->first();

            // If thread doesn't exist, check if an inquiry or referral exists to justify creating one
            if (!$messageNotes) {
                $inquiry = \App\Models\PropertyInquiry::where('PropertyId', $p_id)->where('UserId', $r_id)->first();
                $referral = \App\Models\NotifyDetail::where('property_id', $p_id)->where('renter_id', $r_id)->first();

                if ($inquiry || $referral) {
                    $property = PropertyInfo::find($p_id);
                    if ($property && $property->UserId == $user->Id) {
                        Log::info("Auto-creating message thread for Manager ID: {$user->Id} on Property: {$p_id}");
                        $messageNotes = Message::create([
                            'propertyId' => $p_id,
                            'renterId' => $r_id,
                            'managerId' => $property->UserId,
                            'notify_manager' => 1
                        ]);
                        $messageNotes->load(['conversation', 'propertyinfo']);
                    }
                }
            }

            if (!$messageNotes) {
                Log::warning("Access Denied or Conversation Not Found: Manager ID: {$user->Id}, Property: {$p_id}, Renter: {$r_id}");
                return redirect()->back()->with('error', 'Conversation not found or you do not have permission to view it.');
            }

            // Check permission: Manager assigned, or Property owner
            $isOwner = optional($messageNotes->propertyinfo)->UserId == $user->Id;
            $isAssigned = $messageNotes->managerId == $user->Id;

            if ($isOwner || $isAssigned || $messageNotes->notify_manager == 1) {
                // Mark as read for Manager
                $messageNotes->conversation()->whereNull('managerId')->update(['is_read' => true]);

                $getPropertyInfo = PropertyInfo::where('Id', $p_id)->with('gallerytype.gallerydetail')->first();
                if (!$getPropertyInfo) {
                    return redirect()->back()->with('error', 'Property information not found.');
                }

                return view(
                    'user.managerMessages',
                    [
                        'messages' => [$messageNotes],
                        'getPropertyInfo' => $getPropertyInfo
                    ]
                );
            }

            Log::warning("Unauthorized Access Attempt: Manager ID: {$user->Id} for Thread ID: {$messageNotes->id}");
            return redirect()->back()->with('error', 'Unauthorized access.');

        } catch (\Exception $e) {
            Log::error("Manager Message Page Error: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while loading the conversation.');
        }
    }


    public function markedAllAsReadForFrontEnd(Request $request)
    {
        $userId = Auth::guard('renter')->user()->Id;
        $done = Notification::where('to_id', $userId)->update([
            'seen' => 1,
        ]);

        if ($done) {
            return response()->json(['message' => 'Marked As Read']);
        } else {
            return response()->json(['error' => 'There is an error']);
        }
    }
    public function markedAsSeen(Request $request)
    {
        $notificationId = $request->notificationId;
        $userId = Auth::guard('renter')->user()->Id;
        $done = Notification::where('to_id', $userId)->where('Id', $notificationId)->update([
            'seen' => 1,
        ]);
        if ($done) {
            return response()->json(['message' => 'Marked As Read']);
        } else {
            return response()->json(['error' => 'There is an error']);
        }
    }



    public function storeMessage(Request $request)
    {
        $message = $request->messageInput;
        $propertyId = $request->sendpropertyid;
        $authuser = Auth::guard('renter')->user();
        
        if ($authuser->user_type === 'M') {
            // Manager/Owner sending a message
            $msgThread = Message::where('id', $request->messageId) // Prefer ID if provided
                ->orWhere(function($q) use ($propertyId, $authuser) {
                    $q->where('propertyId', $propertyId)
                      ->where(function($qq) use ($authuser) {
                          $qq->where('managerId', $authuser->Id)
                             ->orWhereHas('propertyinfo', function($pq) use ($authuser) {
                                 $pq->where('UserId', $authuser->Id);
                             });
                      });
                })->first();

            if ($msgThread) {
                // If it was a property owner but managerId wasn't set, set it now
                if (!$msgThread->managerId && $msgThread->propertyinfo->UserId == $authuser->Id) {
                    $msgThread->update(['managerId' => $authuser->Id]);
                }

                Conversation::create([
                    'messagesId' => $msgThread->id,
                    'managerId' => $authuser->Id,
                    'message' => $message,
                ]);
                
                // Notify Renter and Admin
                $notifMsg = "Manager sent a message for <strong>{$msgThread->propertyinfo->PropertyName}</strong>";
                Notification::create(['from_id' => $authuser->Id, 'form_user_type' => 'M', 'to_id' => $msgThread->renterId, 'to_user_type' => 'R', 'property_id' => $propertyId, 'message' => $notifMsg, 'seen' => 0, 'CreatedOn' => now()]);
                if ($msgThread->adminId) {
                    Notification::create(['from_id' => $authuser->Id, 'form_user_type' => 'M', 'to_id' => $msgThread->adminId, 'to_user_type' => 'A', 'property_id' => $propertyId, 'message' => $notifMsg, 'seen' => 0, 'CreatedOn' => now()]);
                }

                $eventData = [
                    'message' => $message,
                    'sender_type' => 'M',
                    'sender_name' => 'Manager',
                    'property_id' => $propertyId
                ];
                event(new ManagerMessageSent($eventData, $propertyId, $msgThread->renterId, $msgThread->adminId));

                return response()->json(['status' => 'success', 'message' => 'Message Sent']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'You are not authorized to send messages for this thread.'], 403);
            }
        } else {
            // Renter sending a message
            $existingMessage = Message::where('propertyId', $propertyId)->where('renterId', $authuser->Id)->first();
            $properties = PropertyInfo::find($propertyId);
            $renterInfo = Login::where('Id', $authuser->Id)->with('renterinfo')->first();
            $adminId = $renterInfo->renterinfo->added_by ?? null;

            if ($existingMessage) {
                $messageId = $existingMessage->id;
            } else {
                $newMessage = Message::create([
                    'propertyId' => $propertyId,
                    'renterId' => $authuser->Id,
                    'adminId' => $adminId,
                    'managerId' => $properties->UserId ?? null, // Link property owner
                ]);
                $messageId = $newMessage->id;
            }

            Conversation::create([
                'messagesId' => $messageId,
                'renterId' => $authuser->Id,
                'message' => $message,
            ]);

            // Notify Admin and Manager
            $property = PropertyInfo::where('Id', $propertyId)->first();
            $notifMsg = "<strong>{$authuser->UserName}</strong> sent a message for <strong>" . ($property->PropertyName ?? 'Property') . "</strong>";

            if ($adminId) {
                Notification::create(['from_id' => $authuser->Id, 'form_user_type' => 'R', 'to_id' => $adminId, 'to_user_type' => 'A', 'property_id' => $propertyId, 'message' => $notifMsg, 'seen' => 0, 'CreatedOn' => now()]);
            }
            if ($property && $property->UserId) {
                Notification::create(['from_id' => $authuser->Id, 'form_user_type' => 'R', 'to_id' => $property->UserId, 'to_user_type' => 'M', 'property_id' => $propertyId, 'message' => $notifMsg, 'seen' => 0, 'CreatedOn' => now()]);
            }

            // Still fire event for those who HAVE websockets
            $notificationData = [
                'message' => $message,
                'sender_type' => 'R',
                'sender_name' => $authuser->UserName,
                'property_id' => $propertyId
            ];
            event(new RenterMessageSent($notificationData, $propertyId, $adminId));

            return response()->json(['status' => 'success', 'message' => 'Message Sent']);
        }
    }

    public function trackInquiry($id)
    {
        $inquiry = \App\Models\PropertyInquiry::findOrFail($id);
        
        // Audit: Track response time if not already tracked
        if (!$inquiry->respond_time) {
            $inquiry->update(['respond_time' => now()]);
            Log::info("Lead tracking: Inquiry #{$id} was responded to by " . (Auth::guard('renter')->user()->UserName ?? 'User'));
        }

        return redirect()->route('manager-message', [
            'p_id' => $inquiry->PropertyId, 
            'r_id' => $inquiry->UserId ?: 0 // Handle G (Guest) later if needed
        ]);
    }

    public function trackReferral($id)
    {
        $referral = NotifyDetail::where('notification_id', $id)->firstOrFail();
        
        // Audit: Track response time if not already tracked
        if (!$referral->respond_time) {
            $referral->update(['respond_time' => now()]);
            Log::info("Lead tracking: Referral #{$id} was responded to by " . (Auth::guard('renter')->user()->UserName ?? 'User'));
        }

        return redirect()->route('manager-message', [
            'p_id' => $referral->property_id, 
            'r_id' => $referral->renter_id
        ]);
    }

}

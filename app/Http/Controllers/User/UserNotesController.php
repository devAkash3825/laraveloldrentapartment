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


class UserNotesController extends Controller
{
    public function addNotes(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $propertyId = $request->propertyId;
        $message = $request->message;
        $respondId = $request->input('respond_id', 0);

        NoteDetail::create([
            'user_id' => $userid,
            'property_id' => $propertyId,
            'message' => $message,
            'send_time' => now(),
            'responde_id' => $respondId,
            'renter_id' => $userid,
        ]);

        // Create notification for Admin/Manager
        $property = PropertyInfo::where('Id', $propertyId)->first();
        if ($property) {
            $renter = Auth::guard('renter')->user();
            $notifMessage = "<strong>{$renter->UserName}</strong> added a note to <strong>{$property->PropertyName}</strong>.";
            
            if ($property->UserId) {
                Notification::create([
                    'from_id' => $userid,
                    'form_user_type' => 'R',
                    'to_id' => $property->UserId,
                    'to_user_type' => 'M',
                    'property_id' => $propertyId,
                    'message' => $notifMessage,
                    'seen' => 0,
                    'CreatedOn' => now(),
                ]);
            }

            $renterInfo = Login::where('Id', $userid)->with('renterinfo')->first();
            $adminId = $renterInfo->renterinfo->added_by ?? null;
            if ($adminId) {
                Notification::create([
                    'from_id' => $userid,
                    'form_user_type' => 'R',
                    'to_id' => $adminId,
                    'to_user_type' => 'A',
                    'property_id' => $propertyId,
                    'message' => $notifMessage,
                    'seen' => 0,
                    'CreatedOn' => now(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Note added'
        ]);
    }

    public function getNoteDetail(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $propertyId = $request->propertyId;
        $getdetails = NoteDetail::where('property_id', $propertyId)
            ->where(function($query) use ($userid) {
                $query->where('user_id', $userid)
                      ->orWhere('renter_id', $userid);
            })
            ->orderBy('send_time', 'asc')
            ->get();
            
        return response()->json([
            'notedetails' => $getdetails
        ]);
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
        $user = Auth::guard('renter')->user();
        
        $messageNotes = Message::where('propertyId', $p_id)->where('renterId', $r_id)
            ->with(['conversation', 'propertyinfo'])
            ->first();

        if (!$messageNotes) {
            return redirect()->back()->with('error', 'Conversation not found');
        }

        // Check permission: Manager assigned, or Property owner
        $isOwner = $messageNotes->propertyinfo->UserId == $user->Id;
        $isAssigned = $messageNotes->managerId == $user->Id;

        if ($isOwner || $isAssigned || $messageNotes->notify_manager == 1) {
            // Mark as read for Manager
            $messageNotes->conversation()->whereNull('managerId')->update(['is_read' => true]);

            $getPropertyInfo = PropertyInfo::where('Id', $p_id)->with('gallerytype.gallerydetail')->first();
            return view(
                'user.managerMessages',
                [
                    'messages' => [$messageNotes],
                    'getPropertyInfo' => $getPropertyInfo
                ]
            );
        }

        return redirect()->back()->with('error', 'Unauthorized');
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

}

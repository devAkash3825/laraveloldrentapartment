<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoteDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyInfo;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Notification;
use App\Events\AdminMessageSent;
use Illuminate\Support\Facades\Log;


class MessageController extends Controller
{
    public function getMessages($renterId, $propertyId)
    {
        $userid = Auth::guard('admin')->user()->id;
        $messageNotes = Message::where('propertyId', $propertyId)->where('renterId', $renterId)
            ->with(['conversation', 'propertyinfo'])
            ->get();
        
        // Mark as read for Admin
        foreach ($messageNotes as $thread) {
            $thread->conversation()->whereNull('adminId')->update(['is_read' => true]);
        }

        $getPropertyInfo = PropertyInfo::where('Id', $propertyId)->with('gallerytype.gallerydetail')->first();


        return view(
            'admin.messages',
            [
                'messages' => $messageNotes,
                'getPropertyInfo' => $getPropertyInfo,
                'renterId' => $renterId
            ]
        );
    }



    public function sendMessage(Request $request)
    {
        $authAdmin = Auth::guard('admin')->user();
        $message = $request->adminmessage;
        $propertyId = $request->sendpropertyID;
        $renterId = $request->renterId;

        try {
            $existingMessage = Message::where('propertyId', $propertyId)->where('renterId', $renterId)->first();
            
            if ($existingMessage) {
                $messageId = $existingMessage->id;
                Conversation::create([
                    'messagesId' => $messageId,
                    'adminId' => $authAdmin->id,
                    'message' => $message,
                ]);
            } else {
                $newchat = Message::create([
                    'propertyId' => $propertyId,
                    'adminId' => $authAdmin->id,
                    'renterId' => $renterId,
                ]);
                $messageId = $newchat->id;
                Conversation::create([
                    'messagesId' => $messageId,
                    'adminId' => $authAdmin->id,
                    'message' => $message,
                ]);
            }

            // Create notification for Renter
            Notification::create([
                'from_id' => $authAdmin->id,
                'form_user_type' => 'A',
                'to_id' => $renterId,
                'to_user_type' => 'R',
                'property_id' => $propertyId,
                'message' => "Admin sent a message for <strong>" . ($existingMessage?->propertyinfo?->PropertyName ?? 'Property') . "</strong>",
                'seen' => 0,
                'CreatedOn' => now(),
            ]);

            // Notify Manager if attached
            if ($existingMessage && $existingMessage->managerId) {
                Notification::create([
                    'from_id' => $authAdmin->id,
                    'form_user_type' => 'A',
                    'to_id' => $existingMessage->managerId,
                    'to_user_type' => 'M',
                    'property_id' => $propertyId,
                    'message' => "Admin sent a message for <strong>{$existingMessage->propertyinfo->PropertyName}</strong>",
                    'seen' => 0,
                    'CreatedOn' => now(),
                ]);
            }

            // Trigger broadcast for those who use it
            $notification = [
                'message' => $message,
                'renterimageURL' => 'https://cdn-icons-png.flaticon.com/512/2233/2233922.png',
            ];
            event(new AdminMessageSent($notification, $renterId, $propertyId));

            return response()->json([
                'status' => 'success',
                'message' => 'Message Sent Successfully',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error in sendMessage:', [
                'error_message' => $e->getMessage(),
                'property_id' => $propertyId,
                'renter_id' => $renterId,
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Message Not Sent. ' . $e->getMessage(),
            ], 500);
        }
    }


}

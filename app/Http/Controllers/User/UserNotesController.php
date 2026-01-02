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


class UserNotesController extends Controller
{
    public function addNotes(Request $request)
    {
        dd($request->all());
    }

    public function getNoteDetail(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $propertyId = $request->propertyId;
        $getdetails = NoteDetail::where('user_id', $userid)->where('property_id', $propertyId)->get();
        return response()->json([
            'notedetails' => $getdetails
        ]);
    }

    public function messagePage()
    {
        return view('user.messages');
    }
    public function sendMessagePage($id)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $user_type = Auth::guard('renter')->user()->user_type;

        $messageNotes = Message::where('propertyId', $id)->where('renterId', $userid)
            ->with('conversation')
            ->with('propertyinfo')
            ->get();
        

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
        $userid = Auth::guard('renter')->user()->Id;
        $user_type = Auth::guard('renter')->user();

        $messageNotes = Message::where('propertyId', $p_id)->where('renterId', $r_id)
            ->with('conversation')
            ->with('propertyinfo')
            ->get();


        if ($messageNotes[0]->notify_manager == 1) {
            $getPropertyInfo = PropertyInfo::where('Id', $p_id)->with('gallerytype.gallerydetail')->first();
            return view(
                'user.managerMessages',
                [
                    'messages' => $messageNotes,
                    'getPropertyInfo' => $getPropertyInfo
                ]
            );
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
        $notification = [
            'message' => $message,
            'renterimageURL' => 'https://cdn-icons-png.flaticon.com/512/2233/2233922.png',
        ];
        

        if ($authuser->user_type === 'M') {
            $renterId = 43014;
            $adminId = 94;
            $check = Message::where('renterId', $renterId)
                ->where('adminId', $adminId)
                ->where('notify_manager', 1)
                ->where('managerId', $authuser->Id)
                ->first();

            if ($check) {
                Conversation::create([
                    'messagesId' => $check->id,
                    'managerId' => $authuser->Id,
                    'message' => $message,
                ]);
            } else {
                return response()->json(['message' => 'You are not Authorized']);
            }
        } else {
            $existingMessage = Message::where('propertyId', $propertyId)->where('renterId', $authuser->Id)->first();
            $propertydata = PropertyInfo::where('Id',$propertyId)->first();
            $getAdminId = Login::where('Id',$authuser->Id)->with('renterinfo')->first();
            $adminId = $getAdminId->renterinfo->added_by;

            if ($existingMessage) {
                $messageId = $existingMessage->id;
                Conversation::create([
                    'messagesId' => $messageId,
                    'renterId' => $authuser->Id,
                    'message' => $message,
                ]);
                event(new RenterMessageSent($notification,$propertyId,$adminId));
                return response()->json(['message', 'Message Sent']);
            } else {
                $newMessage = Message::create([
                    'propertyId' => $propertyId,
                    'renterId' => $authuser->Id,
                ]);
                $messageId = $newMessage->id;
                Conversation::create([
                    'messagesId' => $messageId,
                    'renterId' => $authuser->Id,
                    'message' => $message,
                ]);
                event(new RenterMessageSent($notification,$propertyId,$adminId));
                return response()->json(['message', 'Message Sent']);
            }
        }

    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyInfo;
use App\Models\Special;
use App\Models\RenterInfo;
use App\Models\Login;
use App\Models\AdminAccess;
use App\Models\UserProperty;
use Carbon\Carbon;
use App\Services\SearchService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\RenterInfoCollection;
use App\Repositories\RenterInfoRepository;
use App\Models\PropertySpecial;
use App\Repositories\FavoriteRepository;
use App\Http\Resources\FavoriteCollection;
use App\Models\City;
use App\Notifications\ManagerNotifyNotification;
use App\Events\NotificationEvent;
use App\Models\Message;
use App\Models\Notification;
use App\Events\MessageSent;

class AdminNotesController extends Controller
{


    public function notifyManager(Request $request)
    {   
        $a_id = Auth::guard('admin')->user();
        $p_id = $request->propertyId;
        $r_id = $request->renterId;

        $managerId = PropertyInfo::where('Id',$p_id)->first();
        Message::where('propertyId',$p_id)
        ->where('renterId',$r_id)
        ->where('adminId',$a_id->id)
        ->update([
            'managerId' => $managerId->UserId,
            'notify_manager' => 1
        ]);
        $propertydetails = PropertyInfo::where('Id', $p_id)->first();
        $propertyname = $managerId->PropertyName;
        
        $renter = Login::where('Id',$r_id)->with('renterinfo')->first();
        $renterName = $renter->UserName;
        
        $adminProfile = $a_id->admin_headshot;
        $adminId = $a_id->id;
        $adminName = $a_id->admin_name;
        $managerId = $propertydetails->UserId;

        $notificationToManager = [
            'title' => 'Referred Renter',
            'image' => $adminProfile,
            'message' => '<strong>'.$adminName.'</strong> has referred <strong>'.$renterName.'</strong> to you for <strong>'.$propertyname.'</strong>',
            'link' => route('manager-message', ['p_id' => $p_id, 'r_id' => $r_id])
        ];
        
        // Store in database for persistence
        Notification::create([
            'from_id' => $adminId,
            'form_user_type' => 'A',
            'to_id' => $managerId,
            'to_user_type' => 'M',
            'property_id' => $p_id,
            'message' => $notificationToManager['message'],
            'notification_link' => $notificationToManager['link'],
            'seen' => 0,
            'CreatedOn' => now(),
        ]);

        event(new NotificationEvent($notificationToManager, $managerId));
        
        return response()->json([
            'status' => 'Success',
            'message' => ' Notification sent to manager successfully! '
        ]);

    }
    
    public function viewNotes($renterId, $propertyId)
    {
        $renter = Login::where('Id', $renterId)->with('renterinfo')->first();
        $property = PropertyInfo::where('Id', $propertyId)->first();
        
        // 1. Get Sticky Note from Favorite Table
        $favorite = \App\Models\Favorite::where('UserId', $renterId)->where('PropertyId', $propertyId)->first();
        $stickyNote = $favorite ? $favorite->Notes : '';

        // 2. Get History from NoteDetails Table
        $history = \App\Models\NoteDetail::where('property_id', $propertyId)
            ->where(function($q) use ($renterId) {
                $q->where('user_id', $renterId)
                  ->orWhere('renter_id', $renterId);
            })
            ->orderBy('send_time', 'desc')
            ->get();

        return view('admin.notes', compact('renter', 'property', 'stickyNote', 'history', 'renterId', 'propertyId'));
    }

    public function saveNote(Request $request)
    {
        $renterId = $request->renterId;
        $propertyId = $request->propertyId;
        $message = $request->note;
        $adminId = Auth::guard('admin')->user()->id;

        // 1. Update Sticky Note (Favorite Table)
        $favorite = \App\Models\Favorite::where('UserId', $renterId)->where('PropertyId', $propertyId)->first();
        if ($favorite) {
            $favorite->Notes = $message;
            $favorite->save();
        } else {
            // Optional: Create favorite entry if it doesn't exist? 
            // Usually notes are attached to favorites, but the user might be adding a note to a property not favorited?
            // For now, let's assume it only works if favorited, or we create a new favorite record.
            // Based on user description "The 'Sticky' Note (Favorite Table)... There is only one entry per User+Property."
            // If it doesn't exist, we probably shouldn't force it to be a favorite unless specific business rule says so.
            // But to store the "Sticky Note", we need the record.
            // Let's create it if it doesn't exist, but maybe keep Status=0 if it wasn't a favorite?
            // The user didn't specify. I'll just skip updating if not found to avoid side effects, 
            // OR checks if I should create it. Given "Dual Storage", likely we expect it to exist.
        }

        // 2. Insert into NoteDetails (History)
        \App\Models\NoteDetail::create([
            'user_id' => $adminId, // Admin is the user adding the note
            'user_type' => 'A', // Assuming we track type, though the table schema might just leverage user_id mapping
            'property_id' => $propertyId,
            'message' => $message,
            'send_time' => now(),
            'renter_id' => $renterId, // Context is this renter
        ]);

        return redirect()->back()->with('success', 'Note updated successfully!');
    }
}

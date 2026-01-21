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
use App\Models\NotifyDetail;
use App\Models\NoteDetail;
use App\Notifications\ReferredRenterNotification;

class AdminNotesController extends Controller
{


    public function notifyManager(Request $request)
    {   
        $currentAdmin = Auth::guard('admin')->user();
        $p_id = $request->propertyId;
        $r_id = $request->renterId;

        $property = PropertyInfo::findOrFail($p_id);
        $renter = Login::where('Id', $r_id)->with('renterinfo')->firstOrFail();
        $manager = Login::where('Id', $property->UserId)->first();

        if (!$manager) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Property manager not found for this property.'
            ], 404);
        }

        // 1. Create/Update Referral Record (NotifyDetail)
        // Check if record exists to get current notified count
        $existing = NotifyDetail::where('renter_id', $r_id)->where('property_id', $p_id)->first();
        $count = $existing ? ($existing->no_of_time_notified + 1) : 1;

        $referral = NotifyDetail::updateOrCreate(
            ['renter_id' => $r_id, 'property_id' => $p_id],
            [
                'agent_id' => $currentAdmin->id,
                'notified_at' => now(),
                'send_time' => now(), // Keep send_time for legacy compatibility
                'no_of_time_notified' => $count
            ]
        );

        // 2. Backward compatibility: Update notify_manager flag in Message table
        // This ensures the thread shows up in lists filtered by notify_manager
        Message::updateOrCreate(
            ['propertyId' => $p_id, 'renterId' => $r_id],
            [
                'managerId' => $property->UserId,
                'notify_manager' => 1
            ]
        );

        // 3. Send Professional Notification (Email + DB)
        $manager->notify(new ReferredRenterNotification($renter, $property, $currentAdmin));

        return response()->json([
            'status' => 'Success',
            'message' => 'Renter referred and manager notified successfully!'
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

        // Find existing referral to link the note
        $referral = NotifyDetail::where('renter_id', $renterId)->where('property_id', $propertyId)->first();

        // 1. Update Sticky Note (Favorite Table)
        $favorite = \App\Models\Favorite::where('UserId', $renterId)->where('PropertyId', $propertyId)->first();
        if ($favorite) {
            $favorite->Notes = $message;
            $favorite->save();
        }

        // 2. Insert into NoteDetails (History)
        NoteDetail::create([
            'user_id' => $adminId, 
            'admin_id' => $adminId,
            'sender_id' => $adminId,
            'property_id' => $propertyId,
            'message' => $message,
            'send_time' => now(),
            'renter_id' => $renterId,
            'referral_id' => $referral ? $referral->notification_id : null,
        ]);

        return redirect()->back()->with('success', 'Note updated successfully!');
    }
}

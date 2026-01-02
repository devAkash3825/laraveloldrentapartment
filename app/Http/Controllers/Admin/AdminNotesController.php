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
            'message' => '<strong>'.$adminName.'</strong> has Referred <strong>'.$renterName.'</strong> to You ',
        ];
        event(new NotificationEvent($notificationToManager, $managerId));
        
        return response()->json([
            'status' => 'Success',
            'message' => ' Notification sent to manager successfully! '
        ]);

    }
    
}

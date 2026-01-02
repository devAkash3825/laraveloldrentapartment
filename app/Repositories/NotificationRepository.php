<?php
namespace App\Repositories;

use App\Models\Notification;
use App\Models\Login;
use App\Models\AdminDetail;
use App\Models\RenterInfo;
class NotificationRepository 
{
    // this notification is for bell icon
    public function createNotification($message, $status, $typeId, $sender, $receiver)
    {
        $assetNotification= new Notification;
        $assetNotification->notification= $message;
        $assetNotification->type= $status;
        $assetNotification->type_id= $typeId;
        $assetNotification->sender= $sender;
        $assetNotification->receiver= $receiver;

        return $assetNotification->save();
    }
}
<?php

use App\Models\PropertyInfo;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Login;
use App\Models\AdminDetail;
use App\Http\Controllers\RealTimeController;
// use App\Models\PropertyInfo;


Broadcast::channel('adminNotification.{receiverid}', function (Login $user, $receiverid) {
    return (int) $user->Id === (int) $receiverid;
},['guards' => ['renter']]);

// Broadcast::channel('send-to-renter.{receiverid}.{propertyid}', function (Login $user, PropertyInfo $propertyInfo,$receiverid,$propertyid) {
//     if($user->Id === (int) $receiverid && $propertyInfo->Id === (int) $propertyid){
//         return;
//     }
// },['guards' => ['renter']]);

Broadcast::channel('message-from-admin.{receiverid}', function (Login $user, $receiverid) {
    return (int) $user->Id === (int) $receiverid;
}, ['guards' => ['renter']]);

Broadcast::channel('message-from-renter.{adminId}', function (AdminDetail $user, $adminId) {
    return (int) $user->id === (int) $adminId;
},['guards' => ['admin']]);


// Broadcast::channel('property.{propertyId}.admin.{adminId}', function (AdminDetail $user,PropertyInfo $propertyinfo, $adminId,$propertyId ) {
//     if(($user->Id == $adminId) && ($propertyinfo == $propertyId)){
//         return true;
//     }else{
//         return false;
//     }
// });







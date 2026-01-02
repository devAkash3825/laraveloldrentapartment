<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\RenterInfo;
use App\Models\AdminDetail;
use App\Models\PropertyFloorPlanDetail;

class RenterInfoRepository
{

    public function getRenterInfo()
    {
        $userid = Auth::guard('renter')->user()->Id;
        $allRenters = Login::where('Id',$userid)->with('renterinfo.admindetails')->first();
        return $allRenters;
    }


    public function getManagerInfo(){
        $userid = Auth::guard('renter')->user()->Id;
        $allRenters = Login::where('Id',$userid)->with('renterinfo.admindetails')->first();
        return $allRenters;
    }
}
?>
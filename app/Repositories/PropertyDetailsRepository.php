<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\PropertyInfo;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\GalleryType;
use App\Models\GalleryDetails;
use App\Models\PropertyFloorPlanDetail;

class PropertyDetailsRepository
{

    public function getAllPropertiesDetail($propertyid)
    {
        $getAllDetails = PropertyInfo::where('Id', $propertyid)
            ->with('propertyfloorplandetails.gallerydetail')
            ->with('propertyAdditionalInfo')
            ->with('gallerytype.gallerydetail')
            ->with('communitydescription')
            ->with('login')
            ->with('propertyfloorplandetails')
            ->get();
            

        return $getAllDetails;

    }


    public function getEditPropertyDetails($propertyid)
    {
        $getAllDetails = PropertyInfo::where('Id', $propertyid)
            ->with('propertyfloorplandetails.gallerydetail')
            ->with('propertyAdditionalInfo')
            ->with('gallerytype.gallerydetail')
            ->with('login')
            ->with('propertyfloorplandetails')
            ->with('city.state')
            ->with('apartmentfeatures')
            ->with('communitydescription')
            ->get();

        return $getAllDetails;
        
    }

    public function getListProperties()
    {
        $propertyinfo = PropertyInfo::with('login:id,userName')
            ->with('special')
            ->with('city:id,cityName')
            ->with('propertyfloorplandetails')
            ->with('city.adminaccess.detail')
            ->distinct();
        $userId = Auth::guard('admin')->user()->id;

        
        if ($userId) {
            $propertyinfo->whereHas('city.adminaccess.detail', function ($query) use ($userId) {
                $query->where('admin_detail_id', $userId);
            });
        }

        $propertyinfo = $propertyinfo->get();
        return $propertyinfo;
    }

    public function getLatestPropertiesforHome()
    {
        $latestProperty = PropertyInfo::with('gallerytype.gallerydetail')
            ->with('city.state')
            ->whereHas('gallerytype')
            ->take(8)
            ->orderBy('Id', 'desc')
            ->distinct()
            ->get();

        return $latestProperty;
    }
    
}

?>
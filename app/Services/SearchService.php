<?php
namespace App\Services;
use App\Models\AdminAccess;
use App\Models\Login;
use App\Models\RenterInfo;
use App\Models\AdminDetail;
use App\Models\PropertyInfo;
use App\Models\GalleryType;
use App\Models\GalleryDetails;
class SearchService {
    
    public function searchRenters($adminLoginID, $searchTerm) {
        $allrecords = AdminDetail::all();
        $loginIds = Login::where('username', 'LIKE', "%{$searchTerm}%")->orWhere('email', 'LIKE', "%{$searchTerm}%")->pluck('id');
        $cityIds = AdminAccess::where('admin_detail_id', $adminLoginID)->pluck('admin_city_id');
        $rentersWithLogin = RenterInfo::whereIn('Cityid', $cityIds)->whereIn('Login_ID', $loginIds)->with('login')->get();
        return $rentersWithLogin;
    }

    public function searchProperty($searchTerm)
    {
        // $properties = PropertyInfo::whereHas('city', function($query) use ($searchTerm) {
        //     $query->where('CityName', 'like', "%{$searchTerm}%")
        //         ->orWhereHas('state', function($query) use ($searchTerm) {
        //         $query->where('StateName', 'like', "%{$searchTerm}%");
        //     });
        //     })->orWhere('PropertyName', 'like', "%{$searchTerm}%")
        //     ->with(['gallerytype.gallerydetail'])
        //     ->get();

        //     foreach($properties as $row){
        //         $getimageId = GalleryType::whereIn('PropertyId',[$row->Id])->pluck('Id');
        //         $getImageDetails = GalleryDetails::whereIn('GalleryId',$getimageId)->where('DefaultImage',1)->where('Status',1)->get(['Id','ImageName']);
        //         $row->imageDetails = $getImageDetails;
        //     }

        $query = PropertyInfo::with('gallerytype.gallerydetail')->with(['city', 'city.state']); // Eager load city and state relations
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('PropertyName', 'like', "%{$searchTerm}%")
                    ->orWhere('Address', 'like', "%{$searchTerm}%")
                    ->orWhere('Area', 'like', "%{$searchTerm}%")
                    ->orWhere('Zone', 'like', "%{$searchTerm}%")
                    ->orWhere('Zip', 'like', "%{$searchTerm}%")
                    ->orWhere('Year', 'like', "%{$searchTerm}%")
                    ->orWhereHas('city', function ($q) use ($searchTerm) {
                        $q->where('CityName', 'like', "%{$searchTerm}%")
                          ->orWhereHas('state', function ($q) use ($searchTerm) {
                              $q->where('StateName', 'like', "%{$searchTerm}%");
                          });
                    });
            });
        }
        $properties = $query->paginate(10);
        return $properties;
    }

}
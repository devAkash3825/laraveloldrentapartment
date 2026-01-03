<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\RenterInfo;
use App\Models\AdminDetail;
use App\Models\PropertyFloorPlanDetail;
use App\Models\PropertyInfo;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\PropertyAdditionalInfo;


class SearchRepository
{

    // public function getAdvanceSearchRecords(array $criteria)
    // {    
    //     try {
    //         $query = PropertyInfo::with([
    //             'city', 
    //             'communitydescription', 
    //             'propertyfloorplandetails', 
    //             'newAdditionalInfo', 
    //             'gallerytype.gallerydetail'
    //         ])
    //         ->select(
    //             'propertyinfo.Id',
    //             'propertyinfo.PropertyName',
    //             'propertyinfo.UserId',
    //             'propertyinfo.Email',
    //             'propertyinfo.Keyword',
    //             'propertyinfo.Address',
    //             'propertyinfo.Zip',
    //             'propertyinfo.CityId',
    //             'propertyinfo.Area',
    //             'propertyinfo.Company',
    //             'propertyinfo.Year',
    //             'propertyinfo.YearRemodel',
    //             'propertyinfo.PropertyFeatures',
    //             'propertyinfo.CommunityFeatures',
    //             'propertyinfo.Featured',
    //             'propertyinfo.lastviewed',
    //             DB::raw('MIN(propertyfloorplandetails.Price) AS MINPRICE')
    //         )
    //         ->leftJoin('city', 'city.Id', '=', 'propertyinfo.CityId')
    //         ->leftJoin('communitydescription', 'communitydescription.PropertyId', '=', 'propertyinfo.Id')
    //         ->leftJoin('propertyfloorplandetails', 'propertyfloorplandetails.PropertyId', '=', 'propertyinfo.Id')
    //         ->leftJoin('propertyadditionalinfo', 'propertyadditionalinfo.PropertyId', '=', 'propertyinfo.Id');

    //         Log::info('Starting advanced search query execution', ['criteria' => $criteria]);

    //         $searchString = request('searchString', '');

    //         $query->where(function ($subQuery) use ($searchString) {
    //             $subQuery->where('propertyinfo.PropertyName', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyinfo.Email', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyinfo.Keyword', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyinfo.Address', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('communitydescription.Description', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyadditionalinfo.LeasingTerms', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyadditionalinfo.QualifiyingCriteria', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyadditionalinfo.Parking', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyadditionalinfo.PetPolicy', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyadditionalinfo.Neighborhood', 'LIKE', "%{$searchString}%")
    //                 ->orWhere('propertyadditionalinfo.Schools', 'LIKE', "%{$searchString}%");

    //         });

    //         if (request()->has('zip_code') && request('zip_code') != '') {
    //             $zip = trim(request('zip_code'));
    //             $query->where('propertyinfo.Zip', 'LIKE', "%{$zip}%");
    //         }

    //         if(request()->has('keywords') && request() != ''){
    //             $keywords = trim(request('keywords'));
    //             $query->where('propertyinfo.Keyword','LIKE',"%{$keywords}%");
    //         }

    //         if (request()->has('advsearchcity') && is_array(request('advsearchcity'))) {
    //             $cityid = trim(request('advsearchcity'));
    //             $query->whereIn('propertyinfo.CityId', 'LIKE',"%{$cityid}");
    //         }

    //         if (request()->has('area') && trim(request('area')) != '') {
    //             $area = trim(request('area'));
    //             $query->where('propertyinfo.Area', 'LIKE', "%{$area}%");
    //         }

    //         if (request()->has('managed_by') && trim(request('managed_by')) != '') {
    //             $managedBy = trim(request('managed_by'));
    //             $query->where('propertyinfo.Company', 'LIKE', "%{$managedBy}%");
    //         }

    //         if (request()->has('Price1') || request()->has('Price2')) {
    //             $price1 = trim(request('Price1', 0));
    //             $price2 = trim(request('Price2', PHP_INT_MAX));
    //             $query->whereBetween('propertyfloorplandetails.Price', [$price1, $price2]);
    //         }

    //         if (request()->has('bedrooms') && is_array(request('bedrooms'))) {
    //             $query->whereIn('propertyfloorplandetails.CategoryId', request('bedrooms'));
    //         }

    //         if (request()->has('price_rangefrom') || request()->has('price_rangeto')) {
    //             $year1 = trim(request('price_rangefrom', 0));
    //             $year2 = trim(request('price_rangeto', PHP_INT_MAX));
    //             $query->whereBetween('propertyinfo.Year', [$year1, $year2]);
    //         }

    //         if (request()->has('YearRe')) {
    //             $yearRe = trim(request('YearRe', ''));
    //             $yearRe1 = trim(request('YearRe1', ''));
    //             $query->whereBetween('propertyinfo.YearRemodel', [$yearRe, $yearRe1]);
    //         }

    //         if (request()->has('showphoto') || request()->has('showimage')) {
    //             $query->leftJoin('gallerytype', 'propertyinfo.Id', '=', 'gallerytype.PropertyId')
    //                 ->leftJoin('gallerydetail', 'gallerydetail.GalleryId', '=', 'gallerytype.Id')
    //                 ->where('gallerydetail.ImageName', '!=', '')
    //                 ->where('gallerydetail.DefaultImage', '=', 1)
    //                 ->where('gallerydetail.Status', '=', 1);
    //         }

    //         if (request()->has('propertyfeatures') && is_array(request('propertyfeatures'))) {
    //             $propertyFeatures = request('propertyfeatures');
    //             foreach ($propertyFeatures as $feature) {
    //                 $query->where(function ($subQuery) use ($feature) {
    //                     $subQuery->where('propertyinfo.PropertyFeatures', 'REGEXP', "^{$feature},")
    //                         ->orWhere('propertyinfo.PropertyFeatures', 'REGEXP', ",{$feature}$")
    //                         ->orWhere('propertyinfo.PropertyFeatures', 'REGEXP', ",{$feature},")
    //                         ->orWhere('propertyinfo.PropertyFeatures', '=', $feature);
    //                 });
    //             }
    //         }

    //         if (request()->has('communityfeatures') && is_array(request('communityfeatures'))) {
    //             $communityFeatures = request('communityfeatures');
    //             foreach ($communityFeatures as $feature) {
    //                 $query->where(function ($subQuery) use ($feature) {
    //                     $subQuery->where('propertyinfo.CommunityFeatures', 'LIKE', "%,{$feature},%")
    //                         ->orWhere('propertyinfo.CommunityFeatures', 'LIKE', "{$feature},%")
    //                         ->orWhere('propertyinfo.CommunityFeatures', 'LIKE', "%,{$feature}")
    //                         ->orWhere('propertyinfo.CommunityFeatures', '=', $feature);
    //                 });
    //             }
    //         }

    //         if (request()->has('Pets') && is_array(request('Pets'))) {
    //             $pets = request('Pets');
    //             foreach ($pets as $pet) {
    //                 $query->where(function ($subQuery) use ($pet) {
    //                     $subQuery->where('newAdditionalInfo.Pets', 'LIKE', "%,{$pet},%")
    //                         ->orWhere('newAdditionalInfo.Pets', 'LIKE', "{$pet},%")
    //                         ->orWhere('newAdditionalInfo.Pets', 'LIKE', "%,{$pet}")
    //                         ->orWhere('newAdditionalInfo.Pets', '=', $pet);
    //                 });
    //             }
    //         }

    //         if (!empty($criteria['amenties'])) {
    //             foreach ($criteria['amenties'] as $feature) {
    //                 $query->whereRaw("FIND_IN_SET(?, propertyinfo.PropertyFeatures)", [$feature]);
    //             }
    //         }

    //         if (!empty($criteria['apartmentfeatures'])) {
    //             foreach ($criteria['apartmentfeatures'] as $feature) {
    //                 $query->whereRaw("FIND_IN_SET(?, propertyinfo.CommunityFeatures)", [$feature]);
    //             }
    //         }

    //         $query->groupBy(
    //             'propertyinfo.Id',
    //             'propertyinfo.PropertyName',
    //             'propertyinfo.UserId',
    //             'propertyinfo.Email',
    //             'propertyinfo.Keyword',
    //             'propertyinfo.Address',
    //             'propertyinfo.Zip',
    //             'propertyinfo.CityId',
    //             'propertyinfo.Area',
    //             'propertyinfo.Company',
    //             'propertyinfo.Year',
    //             'propertyinfo.YearRemodel',
    //             'propertyinfo.PropertyFeatures',
    //             'propertyinfo.CommunityFeatures',
    //             'propertyinfo.Featured',
    //             'propertyinfo.lastviewed'
    //         );

    //         if (request()->has('order') && request('order') != '') {
    //             $query->orderBy('propertyinfo.lastviewed', 'desc');
    //         } else {
    //             $query->orderBy('propertyinfo.Featured', 'asc')->orderBy('MINPRICE', 'asc');
    //         }

    //         $perPage = request('recordPerPage', 9);
    //         $properties = $query->paginate($perPage);

    //         Log::info('Advanced search query executed successfully', ['result_count' => $properties->total()]);

    //         return $properties;

    //     } catch (Exception $e) {
    //         Log::error('Error executing advanced search query', [
    //             'message' => $e->getMessage(),
    //             'stack_trace' => $e->getTraceAsString()
    //         ]);

    //         throw $e;
    //     }
    // }

    public function getAdvanceSearchRecords(array $criteria)
    {
        try {
            $query = PropertyInfo::with([
                'city',
                'communitydescription',
                'propertyfloorplandetails',
                'propertyAdditionalInfo',
                'gallerytype.gallerydetail'
            ])
                ->select(
                    'propertyinfo.Id',
                    'propertyinfo.PropertyName',
                    'propertyinfo.UserId',
                    'propertyinfo.Email',
                    'propertyinfo.Keyword',
                    'propertyinfo.Address',
                    'propertyinfo.Zip',
                    'propertyinfo.CityId',
                    'propertyinfo.Area',
                    'propertyinfo.Company',
                    'propertyinfo.Year',
                    'propertyinfo.YearRemodel',
                    'propertyinfo.PropertyFeatures',
                    'propertyinfo.CommunityFeatures',
                    'propertyinfo.Featured',
                    'propertyinfo.lastviewed',
                    DB::raw('MIN(propertyfloorplandetails.Price) AS MINPRICE')
                )
                ->leftJoin('city', 'city.Id', '=', 'propertyinfo.CityId')
                ->leftJoin('communitydescription', 'communitydescription.PropertyId', '=', 'propertyinfo.Id')
                ->leftJoin('propertyfloorplandetails', 'propertyfloorplandetails.PropertyId', '=', 'propertyinfo.Id')
                ->leftJoin('propertyadditionalinfo', 'propertyadditionalinfo.PropertyId', '=', 'propertyinfo.Id');

            Log::info('Starting advanced search query execution', ['criteria' => $criteria]);

            $searchString = request('searchString', '');
            
            $query->where(function ($subQuery) use ($searchString) {
                $subQuery->where('propertyinfo.PropertyName', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyinfo.Email', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyinfo.Keyword', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyinfo.Address', 'LIKE', "%{$searchString}%")
                    ->orWhere('communitydescription.Description', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyadditionalinfo.LeasingTerms', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyadditionalinfo.QualifiyingCriteria', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyadditionalinfo.Parking', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyadditionalinfo.PetPolicy', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyadditionalinfo.Neighborhood', 'LIKE', "%{$searchString}%")
                    ->orWhere('propertyadditionalinfo.Schools', 'LIKE', "%{$searchString}%");
            });

            if ($zip = trim(request('zip_code', ''))) {
                $query->where('propertyinfo.Zip', 'LIKE', "%{$zip}%");
            }
            
            if ($keywords = trim(request('keywords', ''))) {
                $query->where('propertyinfo.Keyword', 'LIKE', "%{$keywords}%");
            }
            
            if ($cityIds = request('advsearchcity')) {
                $query->whereIn('propertyinfo.CityId', $cityIds);
            }
            
            if ($area = trim(request('area', ''))) {
                $query->where('propertyinfo.Area', 'LIKE', "%{$area}%");
            }
            
            if ($managedBy = trim(request('managed_by', ''))) {
                $query->where('propertyinfo.Company', 'LIKE', "%{$managedBy}%");
            }
            
            $price1 = trim(request('Price1', 0));
            $price2 = trim(request('Price2', PHP_INT_MAX));
            $query->whereBetween('propertyfloorplandetails.Price', [$price1, $price2]);
            
            if ($bedrooms = request('bedrooms')) {
                $query->whereIn('propertyfloorplandetails.CategoryId', $bedrooms);
            }
            
            $yearFrom = trim(request('price_rangefrom', 0));
            $yearTo = trim(request('price_rangeto', PHP_INT_MAX));
            $query->whereBetween('propertyinfo.Year', [$yearFrom, $yearTo]);
            
            $yearReFrom = trim(request('YearRe', ''));
            $yearReTo = trim(request('YearRe1', ''));
            
            if ($yearReFrom && $yearReTo) {
                $query->whereBetween('propertyinfo.YearRemodel', [$yearReFrom, $yearReTo]);
            }
            
            if (request()->has('showphoto') || request()->has('showimage')) {
                $query->leftJoin('gallerytype', 'propertyinfo.Id', '=', 'gallerytype.PropertyId')
                    ->leftJoin('gallerydetail', 'gallerydetail.GalleryId', '=', 'gallerytype.Id')
                    ->where('gallerydetail.ImageName', '!=', '')
                    ->where('gallerydetail.DefaultImage', '=', 1)
                    ->where('gallerydetail.Status', '=', 1);
            }
            
            if ($propertyFeatures = request('propertyfeatures')) {
                foreach ($propertyFeatures as $feature) {
                    $query->whereRaw("FIND_IN_SET(?, propertyinfo.PropertyFeatures)", [$feature]);
                }
            }
            
            if ($communityFeatures = request('communityfeatures')) {
                foreach ($communityFeatures as $feature) {
                    $query->whereRaw("FIND_IN_SET(?, propertyinfo.CommunityFeatures)", [$feature]);
                }
            }
            
            if ($pets = request('Pets')) {
                foreach ($pets as $pet) {
                    $query->whereRaw("FIND_IN_SET(?, propertyadditionalinfo.Pets)", [$pet]);
                }
            }

            $query->groupBy('propertyinfo.Id');
            
            if ($order = request('order')) {
                $query->orderBy('propertyinfo.lastviewed', 'desc');
            } else {
                $query->orderBy('propertyinfo.Featured', 'asc')
                    ->orderBy('MINPRICE', 'asc');
            }
            
            $perPage = request('recordPerPage', 12);
            $properties = $query->paginate($perPage);

            Log::info('Advanced search query executed successfully', ['result_count' => $properties->total()]);

            return $properties;

        } catch (\Exception $e) {
            Log::error('Error executing advanced search query', [
                'message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }


}
?>
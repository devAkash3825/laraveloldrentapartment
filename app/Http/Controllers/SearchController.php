<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SearchRepository;
use App\Services\SearchService;
use App\Http\Resources\PropertyCollection;
use App\Models\PropertyInfo;

class SearchController extends Controller
{
    protected $searchRepository;
    protected $searchService;

    public function __construct(SearchService $searchService, searchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }
    

    public function searchPropertyAll(Request $request)
    {
        $query = PropertyInfo::where('ActiveOnSearch', 1)->with([
            'login',
            'city',
            'communitydescription',
            'propertyfloorplandetails',
            'propertyAdditionalInfo',
            'gallerytype.gallerydetail'
        ]);

        if ($request->filled('keywords')) {
            $query->where('Keyword', 'like', '%' . $request->input('keywords') . '%');
        }

        if ($request->filled('area')) {
            $query->where('Area', $request->input('area'));
        }

        if ($request->filled('zip_code')) {
            $query->where('Zip', $request->input('zip_code'));
        }

        if ($request->filled('advsearchstate')) {
            $query->whereHas('city.state', function ($q) use ($request) {
                $q->where('Id', $request->input('advsearchstate'));
            });
        }

        if ($request->filled('advsearchcity')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('Id', $request->input('advsearchcity'));
            });
        }

        if ($request->filled('managed_by')) {
            $query->where('Company', $request->input('managed_by'));
        }

        if ($request->filled('price_rangefrom') || $request->filled('price_rangeto')) {
            $priceFrom = $request->input('price_rangefrom', 0);
            $priceTo = $request->input('price_rangeto', PHP_INT_MAX);

            $query->whereHas('propertyfloorplandetails', function ($q) use ($priceFrom, $priceTo) {
                $q->whereBetween('Price', [$priceFrom, $priceTo]);
            });
        }

        $properties = $query->paginate(100);

        return view('user.property.searchProperty', [
            'advancesearch' => $properties,
        ]);

    }


}

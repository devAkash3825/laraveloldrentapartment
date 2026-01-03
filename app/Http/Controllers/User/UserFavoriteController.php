<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyInfo;
use App\Models\Favorite;
use App\Models\GalleryType;
use App\Models\GalleryDetails;
use App\Models\NoteDetail;
use App\Services\FavoriteService;
use App\Http\Resources\FavoriteCollection;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\PropertyDetailsRepository;
use App\Http\Resources\PropertyCollection;
use App\Models\Login;
use App\Models\ApartmentFeature;


class UserFavoriteController extends Controller
{
    protected $favoriteService;
    protected $propertyDetailsRepository;

    public function __construct(FavoriteService $favoriteService, PropertyDetailsRepository $propertyDetailsRepository)
    {
        $this->favoriteService = $favoriteService;
        $this->propertyDetailsRepository = $propertyDetailsRepository;
    }


    public function listview(Request $request)
    {
        $favpropertyInfos = $this->favoriteService->getFavoriteProperties();
        $collectedData = new FavoriteCollection($favpropertyInfos);
        $transformeddata = $collectedData->toArray(request());

        if ($request->ajax()) {
            return DataTables::of($transformeddata)->addIndexColumn()
                ->addColumn('propertyname', function ($row) {
                    $propertybtn = "<a href='' class='p-2 fav-link-name'>{$row['propertyname']}</a>";
                    return $propertybtn;
                })
                ->addColumn('quote', function ($row) {
                    $quotebtn = "<a class='fav-request-quote-btn' href='#'>Request Quote</a>";
                    return $quotebtn;
                })
                ->addColumn('action', function ($row) {
                    $propertydisplay = route('property-display', ['id' => $row['id']]);
                    $streetview = route('street-view',['id' => $row['id']]);
                    $messagePage = route('send-messages',['id' => $row['id']]);
                    $action = '<div class="demo-btn-list d-flex" style="gap: 5px;">
                               <a href="'.$propertydisplay. '" class="btn-primary-icon px-2 py-1 border rounded m-1" data-bs-toggle="tooltip" title="View"><i class="bi bi-eye"></i></a>
                               <a href="'.$streetview.'" class="btn-secondary-icon px-2 py-1 border rounded m-1" data-bs-toggle="tooltip" title="Map"><i class="bi bi-map"></i></a>
                               <a href="'.$messagePage.'" class="btn-tertiary-icon px-2 py-1 border rounded m-1" data-bs-toggle="tooltip" title="Chat"><i class="bi bi-chat-left"></i></a>
                           </div>';
                    return $action;
                })
                ->rawColumns(['propertyname', 'quote', 'action'])
                ->make(true);
        } else {
            return view('user.favorites.listView');
        }
    }


    public function thumbnailView()
    {
        $favpropertyInfos = $this->favoriteService->getFavoriteProperties();
        $searchedresponse = new FavoriteCollection($favpropertyInfos);
        $transformeddata = $searchedresponse->toArray(request());
        
        return view('user.favorites.thumbnailView', [
            'data' => $transformeddata,
        ]);
    }

    public function mapView()
    {
        $authuser = Auth::guard('renter')->user()->Id;
        $properties = PropertyInfo::where('ActiveOnSearch', 1)->where('Status', 1)
            ->whereHas('favorites', function ($query) use ($authuser) {
                $query->where('UserId', $authuser)->where('Status', 1);
            })
            ->with(['favorites' => function ($query) use ($authuser) {
                $query->where('UserId', $authuser)->where('Status', 1);
            }])
            ->with(['gallerytype.gallerydetail', 'city.state']) 
            ->get();
        
        return view('user.favorites.mapView', ['mapdata' => $properties]);
    }

    public function manageFavorites(){

    }

    public function streetView($id){
        $propertyinfo = $this->propertyDetailsRepository->getAllPropertiesDetail($id);
        $data = new PropertyCollection($propertyinfo);
        $propertyDetails = $data->toArray(request());
        $userid = Auth::guard('renter')->user()->Id;
        $renterinfo = Login::where('Id',$userid)->with('renterinfo')->first();
        
        return view('user.property.streetView', [
            'propertyDetails' => $propertyDetails,
            'renterinfo' => $renterinfo
        ]);
    }

    public function addNotes(Request $request)
    {
        dd($request->all());
    }

    public function getNoteDetail(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $propertyId = $request->propertyId;
        $getdetails = NoteDetail::where('user_id', $userid)->where('property_id', $propertyId)->get();
        return response()->json([
            'notedetails' => $getdetails
        ]);
    }


    public function addToFavoriteByUser(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $propertyId = $request->propertyId;

        // Check if the favorite already exists
        $favorite = Favorite::where('PropertyId', $propertyId)->where('UserId', $userid)->first();
        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Property removed from your favorites.'
            ]);
        } else {
            $favorite = new Favorite();
            $favorite->PropertyId = $propertyId;
            $favorite->UserId = $userid;
            $favorite->AddedOn = now();
            $favorite->Status = true;
            $favorite->Notes = $request->input('notes', null);
            $favorite->save();
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Property added to your favorites!'
            ]);
        }
    }


    public function checkIsFavorite(Request $request)
    {

        $userid = Auth::guard('renter')->user()->Id;
        $propertyId = $request->propertyId;
        $isFavorite = Favorite::where('PropertyId', $propertyId)->where('UserId', $userid)->exists();
        return response()->json(['isFavorite' => $isFavorite]);

    }


}
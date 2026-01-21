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
                $url = route('property-display', ['id' => $row['id']]);
            return '<a href="'.$url.'" class="prop-link">
                        <div class="icon-box">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div>
                            <div class="prop-name">'.$row['propertyname'].'</div>
                            <div class="text-muted smaller" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-location-dot me-1"></i>'.$row['address'].', '.$row['area'].'
                            </div>
                        </div>
                    </a>';
            })
            ->addColumn('quote', function ($row) {
                return '<a class="fav-request-quote-btn" href="javascript:void(0)" onclick="requestQuote('.$row['id'].')">
                            <i class="fa-solid fa-comment-dollar me-1"></i> Request Quote
                        </a>';
            })
            ->addColumn('action', function ($row) {
                $viewUrl = route('property-display', ['id' => $row['id']]);
                $mapUrl = route('street-view', ['id' => $row['id']]);
                
                return '<div class="action-btns" style="white-space: nowrap;">
                           <a href="'.$mapUrl.'" class="btn-icon btn-map" data-bs-toggle="tooltip" title="Interactive Map">
                               <i class="fa-solid fa-map-location-dot"></i>
                           </a>
                           <a href="javascript:void(0)" class="btn-icon btn-notes" data-id="'.$row['id'].'" data-bs-toggle="tooltip" title="View/Add Notes">
                               <i class="fa-solid fa-clipboard-list"></i>
                           </a>
                           <a href="javascript:void(0)" class="btn-icon btn-delete remove-single-fav" data-id="'.$row['id'].'" data-bs-toggle="tooltip" title="Remove from Favorites">
                               <i class="fa-solid fa-trash-can"></i>
                           </a>
                       </div>';
            })
                ->rawColumns(['propertyname', 'quote', 'action'])
                ->make(true);
        } else {
            return view('user.favorites.listView');
        }
    }

    public function bulkRemoveFavorites(Request $request)
    {
        $ids = $request->ids;
        $userid = Auth::guard('renter')->user()->Id;

        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'No properties selected.']);
        }

        Favorite::whereIn('PropertyId', $ids)->where('UserId', $userid)->delete();

        return response()->json([
            'success' => true, 
            'message' => count($ids) . ' properties removed from your favorites.'
        ]);
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
        $noteMessage = $request->input('notes');

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
            $favorite->Notes = $noteMessage; // Keep this for now as it's in the table
            $favorite->save();

            // If there's a note, save it to notedetails
            if ($noteMessage) {
                NoteDetail::create([
                    'user_id' => $userid,
                    'property_id' => $propertyId,
                    'message' => $noteMessage,
                    'send_time' => now(),
                    'renter_id' => $userid,
                ]);
            }

            // Create notification for Admin & Property Manager
            $property = PropertyInfo::where('Id', $propertyId)->first();
            if ($property) {
                $renter = Auth::guard('renter')->user();
                $message = "<strong>{$renter->UserName}</strong> added <strong>{$property->PropertyName}</strong> to their favorites.";
                
                // Notify Manager
                if ($property->UserId) {
                    Notification::create([
                        'from_id' => $userid,
                        'form_user_type' => 'R',
                        'to_id' => $property->UserId,
                        'to_user_type' => 'M',
                        'property_id' => $propertyId,
                        'message' => $message,
                        'seen' => 0,
                        'CreatedOn' => now(),
                    ]);
                }

                // Notify Admin (Assuming there's an admin who added this renter, or just notify superadmin)
                // In your existing code, you seem to use added_by for adminId
                $renterInfo = Login::where('Id', $userid)->with('renterinfo')->first();
                $adminId = $renterInfo->renterinfo->added_by ?? null;
                if ($adminId) {
                    Notification::create([
                        'from_id' => $userid,
                        'form_user_type' => 'R',
                        'to_id' => $adminId,
                        'to_user_type' => 'A',
                        'property_id' => $propertyId,
                        'message' => $message,
                        'seen' => 0,
                        'CreatedOn' => now(),
                    ]);
                }
            }

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
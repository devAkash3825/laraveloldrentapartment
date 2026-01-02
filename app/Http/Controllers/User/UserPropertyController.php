<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyInfo;
use Illuminate\Support\Facades\Log;
use App\Models\GalleryDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\Login;
use App\Models\City;
use App\Models\State;
use App\Http\Resources\ListingCollection;
use App\Services\SearchService;
use App\Repositories\PropertyDetailsRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PropertyInquiry;
use App\Http\Resources\PropertyCollection;
use App\Models\UserProperty;
use App\Models\ApartmentFeature;
use App\Models\CommunityAmenities;
use App\Models\FloorPlanCategory;
use App\Models\PropertyFloorPlanDetail;
use App\Models\GalleryType;
use App\Models\propertyAdditionalInfo;
use Illuminate\Support\Facades\Storage;
use App\Models\CommunityDescription;
use Illuminate\Pagination\LengthAwarePaginator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\propertyNewAdditionalInfo;




class UserPropertyController extends Controller
{

    protected $propertyDetailsRepository;
    protected $searchService;

    public function __construct(SearchService $searchService, PropertyDetailsRepository $propertyDetailsRepository)
    {
        $this->propertyDetailsRepository = $propertyDetailsRepository;
        $this->searchService = $searchService;
    }

    public function propertyDisplay($id)
    {
        $propertyinfo = $this->propertyDetailsRepository->getEditPropertyDetails($id);
        $data = new PropertyCollection($propertyinfo);
        $propertyDetails = $data->toArray(request());

        $communityFeatures = $propertyDetails[0]['apartmentinfo'];
        $featureIds = explode(',', $communityFeatures);
        $features = ApartmentFeature::whereIn('id', $featureIds)->get();

        $amenities = $propertyDetails[0]['amenities'];
        $amenitiesIds = explode(',', $amenities);
        $amenitiesDetails = CommunityAmenities::whereIn('Id', $amenitiesIds)->get();


        $userid = Auth::guard('renter')->user()->Id;
        $renterinfo = Login::where('Id', $userid)->with('renterinfo')->first();
        $userid = Auth::guard('renter')->user()->Id;
        $pid = $id;


        $existingRecord = UserProperty::where('userId', $userid)->where('propertyId', $pid)->first();
        if ($existingRecord) {
            $existingRecord->lastviewed = now();
            $existingRecord->save();
        } else {
            UserProperty::create([
                'userId' => $userid,
                'propertyId' => $pid,
                'lastviewed' => now(),
            ]);
        }
        $categories = FloorPlanCategory::all();
        $propertyDetails = $propertyDetails[0];



        return view('user.property.propertyDisplay', [
            'propertyDetails' => $propertyDetails,
            'renterinfo' => $renterinfo,
            'featureNames' => $features,
            'amenitiesDetails' => $amenitiesDetails,
            'categories' => $categories,
            'propertyinfo'  => $propertyinfo,
        ]);
    }

    public function editProperty($id)
    {
        $propertyinfo = $this->propertyDetailsRepository->getEditPropertyDetails($id);
        $categories = FloorPlanCategory::all();
        $selectFloorPlan = PropertyFloorPlanDetail::where('PropertyId', $id)->get();
        $gallerytype = GalleryType::where('PropertyId', $id)->with('gallerydetail')->get();
        $galleryDetailsImages = @$gallerytype[0];
        $apartmentFeature = ApartmentFeature::all();
        $amenities = CommunityAmenities::all();

        return view('user.property.editProperty', [
            'propertyinfo' => $propertyinfo,
            'categories' => $categories,
            'selectFloorPlan' => $selectFloorPlan,
            'galleryDetails' => $galleryDetailsImages,
            'propertyId' => $id,
            'apartmentFeature' => $apartmentFeature,
            'amenities' => $amenities,
        ]);
    }

    public function listProperty(Request $request)
    {
        $query = PropertyInfo::where('Status', 1)
            ->where('ActiveOnSearch', 1)
            ->orderBy('Id', 'desc')
            ->with(['gallerytype.gallerydetail', 'city.state'])
            ->whereHas('gallerytype', function ($query) {
                $query->whereNotNull('Id');
            });

        if ($request->last_month == 'last_month') {
            $query->where('CreatedOn', '>=', now()->subMonth());
        } elseif ($request->last_month == 'last_week') {
            $query->where('CreatedOn', '>=', now()->subWeek());
        }

        if ($request->filled('quicksearch')) {
            $searchText = $request->input('quicksearch');

            $query->where(function ($q) use ($searchText) {
                $q->where('PropertyName', 'like', '%' . $searchText . '%')
                    ->orWhereHas('city', function ($q) use ($searchText) {
                        $q->where('CityName', 'like', '%' . $searchText . '%');
                    })
                    ->orWhereHas('city.state', function ($q) use ($searchText) {
                        $q->where('StateName', 'like', '%' . $searchText . '%');
                    });
            });
        }



        $perPage = 16;
        $currentPage = $request->input('page', 1);

        $totalRecords = $query->count();

        // $paginatedRecords = $totalRecords > 16 ? $query->paginate($perPage, ['*'], 'page', $currentPage) : $query->get();
        $paginatedRecords = $query->paginate($perPage, ['*'], 'page', $currentPage);

        if ($request->ajax()) {
            $html = view('partials.property_list', ['propertyDetails' => $paginatedRecords])->render();
            $paginationHtml = $totalRecords > 16 ? view('partials.search_pagination', ['paginator' => $paginatedRecords])->render() : '';

            return response()->json([
                'html' => $html,
                'pagination' => $paginationHtml,
                'showPagination' => $totalRecords > 16,
            ]);
        }

        return view('user.property.listProperty', [
            'propertyDetails' => $paginatedRecords,
            'showPagination' => $totalRecords > 16,
        ]);
    }


    public function getLastMonthProperties(Request $request)
    {
        return 'no records found111';
    }

    public function managerRegister(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:login',
            'password' => 'required|confirmed',
        ]);
        $email = $request->email;
        $password = $request->password;
        $username = $request->username;
        $ip_address = $request->ip();
        $createdOn = Carbon::now();
        $modifiedOn = Carbon::now();
        $usertype = "M";
        try {
            $user = Login::create([
                'UserName' => $username,
                'Password' => $password,
                'Email' => $email,
                'user_type' => $usertype,
                'UserIp' => $ip_address,
                'CreatedOn' => $createdOn,
                'ModifiedOn' => $modifiedOn,
            ]);
            $credentials = $request->only('username', 'password');
            $manager = Login::where('UserName', $request->username)->first();
            if (Hash::check($request->password, $manager->Password) || $manager->Password === $request->password) {
                Auth::guard('renter')->login($manager);
                return view->json(['success' => 'Registration successful, you are now logged in.', 'redirect' => '/']);
            } else {
                return response()->json(['error' => 'Invalid credentials.'], 401);
            }
        } catch (Exception $e) {
            Log::error('Admin login error: ' . $e->getMessage());
            return redirect()->route('admin-login')->with('error', 'An error occurred while trying to log in. Please try again later.');
        }
    }

    public function getStates()
    {
        $states = State::all();

        $stateIds = $states->pluck('Id')->toArray();

        $cities = City::whereIn('StateId', $stateIds)->get();
        return response()->json([
            'states' => $states,
            'cities' => $cities
        ]);
    }

    public function getCities($state_id)
    {
        $cities = City::where('StateId', $state_id)->get();
        return response()->json($cities);
    }

    public function getStateAndCityName($cityid)
    {
        $city = City::with('state')->find($cityid);
        if ($city) {
            return [
                'city_name' => $city->CityName,
                'state_name' => $city->state->StateName,
                'state_id' => $city->state->Id,
            ];
        } else {
            return null;
        }
    }
    public function addProperty()
    {
        return view('user.property.addProperty');
    }

    public function addNewProperty(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $validated = $request->validate([
            'add_property_state'   => 'required',
            'add_property_city'    => 'required',
            'termsandcondition'    => 'required',
            'propertyname'         => 'required|string|max:255',
            'managementcompany'    => 'required|string|max:255',
            'addpropertyemail'     => 'required|email',
            'pcontact'             => 'required|string|max:100',
            'units'                => 'required|integer|min:1',
            'yearbuilt'            => 'required|date',
            'area'                 => 'required|string|max:255',
            'address'              => 'required|string|max:255',
            'zipcode'              => 'required|string|max:20',
            'contactno'            => 'required|string|max:20',
            'billto'               => 'required|string|max:255',
            'copyzipcode'          => 'required|string|max:20',
            'bill_address_state'   => 'required',
            'bill_address_city'    => 'required',
            'billaddress'          => 'required|string|max:255',
            'billphone'            => 'required|string|max:20',
            'billcontact'          => 'required|string|max:100',
            'billemail'            => 'required|email',
            'billfax'              => 'required|string|max:50',
            'embddedmap'           => 'required',
        ]);

        try {
            $year = date('Y', strtotime($request->yearbuilt));
            $yearRemodeled = $request->year_remodeled ? date('Y', strtotime($request->year_remodeled)) : null;

            $coordinates = $this->getLatLonFromIframe($request->embddedmap);

            $propertyData = [
                'CityId'         => $request->add_property_city,
                'UserId'         => $userid,
                'PropertyName'   => $request->propertyname,
                'Company'        => $request->managementcompany,
                'PropertyContact' => $request->pcontact,
                'Units'          => $request->units,
                'Year'           => $year,
                'YearRemodel'    => $yearRemodeled,
                'Email'          => $request->addpropertyemail,
                'Area'           => $request->area,
                'Address'        => $request->address,
                'BillZip'        => $request->copyzipcode,
                'ContactNo'      => $request->contactno,
                'WebSite'        => $request->website,
                'officehour'     => $request->officehours,
                'BillTo'         => $request->billto,
                'Zip'            => $request->zipcode,
                'BillCity'       => $request->bill_address_city,
                'BillAddress'    => $request->billaddress,
                'BillPhone'      => $request->billphone,
                'BillContact'    => $request->billcontact,
                'BillFax'        => $request->billfax,
                'BillEmail'      => $request->billemail,
                'CreatedOn'      => now(),
                'ModifiedOn'     => now(),
                'latitude'       => $coordinates['latitude'],
                'longitude'      => $coordinates['longitude'],
                'Status'         => $request->status ?? '1',
                'Featured'       => $request->featured ?? '1',
                'ActiveOnSearch' => $request->activeonsearch ?? '1',
            ];

            PropertyInfo::create($propertyData);

            Alert::success('Success', 'Property added successfully. You can now add floor plans and images.');
            return back();
        } catch (\Exception $e) {
            Log::error('Error adding property', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => $userid,
                'input'   => $request->all()
            ]);

            Alert::error('Error', 'An error occurred while adding the property. Please try again later.');
            return back();
        }
    }


    public function myProperties(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $myproperty = PropertyInfo::where('UserId', $userid)->with('gallerytype.gallerydetail')->get();
        $perPage = 5;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $currentPageItems = $myproperty->slice($offset, $perPage);

        $paginatedRecords = new LengthAwarePaginator(
            $currentPageItems,
            $myproperty->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        return view('user.property.myProperties', compact('paginatedRecords'));
    }

    public function requestQuote(Request $request)
    {
        $validation = $request->validate([
            'comments' => 'required',
            'propertyId' => 'required',
        ]);
        try {
            $userid = Auth::guard('renter')->user()->Id;
            $data = PropertyInquiry::create([
                'PropertyId' => $request->propertyId,
                'UserId' => $userid,
                'UserName' => $request->firstname,
                'LastName' => $request->lastname,
                'Email' => $request->email,
                'Phone' => $request->phone,
                'MoveDate' => $request->movedate,
                'Message' => $request->comments,
                'CreatedOn' => Carbon::now(),
            ]);
            return response()->json(
                ['success' => true]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['error' => false]
            );
        }
    }

    public function compareApartments(Request $request)
    {
        return view('user.property.compare');
    }

    public function managerProfile($id)
    {
        $managerProfile = Login::where('Id', $id)->where('user_type', 'M')->first();

        $userProperties = PropertyInfo::where('UserId', $managerProfile->Id)
            ->with(['gallerytype.gallerydetail' => function ($query) {
                $query->where('DefaultImage', 1);
            }])
            ->with('city.state')
            ->get();


        return view('user.managerProfile', [
            'userProperties' => $userProperties,
            'managerProfile' => $managerProfile
        ]);
    }

    public function floorPlanDetail($id)
    {
        $categories = FloorPlanCategory::all();
        return view('user.property.createFloorPlan', [
            'categories' => $categories,
            'propertyId' => $id
        ]);
    }

    public function storeFloorPlan(Request $request)
    {
        try {
            PropertyFloorPlanDetail::create([
                'PropertyId' => $request->propertyId,
                'CategoryId' => $request->category,
                'PlanType' => $request->plan_type,
                'FloorPlan' => $request->floor_plan,
                'PlanName' => $request->plan_name,
                'Footage' => $request->square_footage,
                'Available_Url' => $request->available_url,
                'special' => $request->special,
                'expiry_date' => $request->expiry_date,
                'avail_date' => implode(',', $request->dates),
                'isavailable' => '1',
                'deposit' => $request->deposit,
                'floorplan_link' => $request->link,
                'Price' => $request->starting_at,
                'CreatedOn' => Carbon::now(),
                'ModifiedOn' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Floor plan created successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'The specified property or category was not found');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'imagetitle' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'propertyimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $propertyId = $request->property_id;
            $propertyExist = GalleryType::where('PropertyId', $propertyId)->pluck('Id')->first();

            $file = $request->file('propertyimage');
            $fileExtension = $file->getClientOriginalExtension();

            if ($propertyExist) {
                $galleryDetail = GalleryDetails::create([
                    'GalleryId' => $propertyExist,
                    'ImageTitle' => $request->imagetitle,
                    'Description' => $request->description,
                    'DefaultImage' => 1,
                    'display_in_gallery' => 1,
                    'CreatedOn' => Carbon::now(),
                    'ModifiedOn' => Carbon::now(),
                    'Status' => 1,
                ]);

                $updateImageNameId = $galleryDetail->id;
                $savedImageName = 'Gallery_propertyimage_' . $updateImageNameId . '_' . $propertyId . '.' . $fileExtension;

                $uploadedImageUrl = $this->uploadToS3($propertyId, $savedImageName, $file);
                if (!$uploadedImageUrl) {
                    throw new \Exception('Failed to upload image to S3');
                }

                GalleryDetails::where('Id', $updateImageNameId)->update([
                    'ImageName' => $savedImageName,
                ]);
            } else {
                $galleryType = GalleryType::create([
                    'PropertyId' => $propertyId,
                    'Title' => 'General',
                    'Description' => 'GalleryDescription',
                    'CreatedOn' => Carbon::now(),
                    'ModifiedOn' => Carbon::now(),
                    'Status' => 1,
                ]);

                $galleryTypeId = $galleryType->PropertyId;

                $galleryDetail = GalleryDetails::create([
                    'GalleryId' => $galleryTypeId,
                    'ImageTitle' => $request->imagetitle,
                    'Description' => $request->description,
                    'DefaultImage' => 1,
                    'display_in_gallery' => 1,
                    'CreatedOn' => Carbon::now(),
                    'ModifiedOn' => Carbon::now(),
                    'Status' => 1,
                ]);

                $updateImageNameId = $galleryDetail->id;
                $savedImageName = 'Gallery_propertyimage_' . $updateImageNameId . '_' . $propertyId . '.' . $fileExtension;

                $uploadedImageUrl = $this->uploadToS3($propertyId, $savedImageName, $file);

                if (!$uploadedImageUrl) {
                    throw new \Exception('Failed to upload image to S3');
                }
                GalleryDetails::where('Id', $updateImageNameId)->update([
                    'ImageName' => $savedImageName,
                ]);
            }
            return redirect()->back()->with('success', 'Image uploaded successfully');
        } catch (\Exception $e) {
            log::error('Error uploading image', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'input'   => $request->all()
            ]);
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }

    public function uploadToS3($propertyID, $savedImageName, $file)
    {
        try {
            $filePath = 'Gallery/Property_' . $propertyID . '/Original/' . $savedImageName;
            $result = Storage::disk('s3')->put($filePath, fopen($file->getRealPath(), 'rb'));

            if ($result) {
                return Storage::disk('s3')->url($filePath);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteGalleryImage(Request $request, $id)
    {
        try {

            $galleryDetail = GalleryDetails::where('Id', $id)->first();
            $imageName = $galleryDetail->ImageName;
            $propertyId = $request->propertyId;

            $filePath = 'Gallery/Property_' . $propertyId . '/Original/' . $imageName;

            if (Storage::disk('s3')->exists($filePath)) {
                Storage::disk('s3')->delete($filePath);
            }
            GalleryDetails::where('Id', $id)->delete();
            return response()->json(['success' => true, 'message' => 'Image and record deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['danger' => false, 'message' => 'Error deleting image: ' . $e->getMessage()]);
        }
    }

    public function editAdditionalDetail(Request $request, $id)
    {
        $propertyId = $id;
        $validated = $request->validate([
            'leasing_terms'       => 'nullable|string|max:1000',
            'qualifying_criteria' => 'nullable|string|max:1000',
            'parking'             => 'nullable|string|max:255',
            'pet_policy'          => 'nullable|string|max:255',
            'neighborhood'        => 'nullable|string|max:1000',
            'schools'             => 'nullable|string|max:1000',
            'driving_directions'  => 'nullable|string|max:1000',
        ]);
        try {
            $existingInfo = propertyNewAdditionalInfo::where('PropertyId', $propertyId)->update([
                'LeasingTerms'       => $request->input('leasing_terms'),
                'QualifiyingCriteria' => $request->input('qualifying_criteria'),
                'Parking'            => $request->input('parking'),
                'PetPolicy'          => $request->input('pet_policy'),
                'Neighborhood'       => $request->input('neighborhood'),
                'Schools'            => $request->input('schools'),
                'drivedirection'     => $request->input('driving_directions'),
                'ModifiedOn'         => Carbon::now(),
                'PropertyId'         => $propertyId,
            ]);

           

            if ($existingInfo) {
                    Log::info("✅ Property Additional Info updated", ['PropertyId' => $propertyId]);
                return redirect()->back()->with('success', 'Property additional details updated successfully!');
            } else {
                propertyNewAdditionalInfo::create([
                'LeasingTerms'       => $request->input('leasing_terms'),
                'QualifiyingCriteria' => $request->input('qualifying_criteria'),
                'Parking'            => $request->input('parking'),
                'PetPolicy'          => $request->input('pet_policy'),
                'Neighborhood'       => $request->input('neighborhood'),
                'Schools'            => $request->input('schools'),
                'drivedirection'     => $request->input('driving_directions'),
                'ModifiedOn'         => Carbon::now(),
                'PropertyId'         => $propertyId,
                ]);
                Log::info("🆕 Property Additional Info created", ['PropertyId' => $propertyId]);
                return redirect()->back()->with('success', 'Property additional details updated successfully!');
            }


        } catch (\Exception $e) {
            Log::error("❌ Error updating property additional details", [
                'PropertyId' => $propertyId,
                'message'    => $e->getMessage(),
                'input'      => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Failed to update property additional details. Please try again later.');
        }
    }


    public function editGeneralDetail(Request $request)
    {
        $propertyId = $request->id;
        $apartmentfeatures = $request->apartmentfeatures ?? [];
        $amenities = $request->amenities ?? [];
        $amenitieslist = implode(",", $amenities);
        $apartmentfeatureslist = implode(",", $apartmentfeatures);

        try {
            PropertyInfo::where('Id', $propertyId)->update([
                'PropertyFeatures' => $apartmentfeatureslist,
                'CommunityFeatures' => $amenitieslist,
            ]);
            $existingInfo = CommunityDescription::where('PropertyId', $propertyId)->first();
            if ($existingInfo) {
                $existingInfo->update([
                    'Description' => $request->communitydescription,
                    'ModifiedOn' => Carbon::now(),
                    'Status' => 1,
                    'Agent_comments' => '',
                ]);
            } else {
                CommunityDescription::create([
                    'PropertyId' => $propertyId,
                    'Description' => $request->communitydescription,
                    'ModifiedOn' => Carbon::now(),
                    'Status' => 1,
                    'CreatedOn' => Carbon::now(),
                    'Agent_comments' => '',
                ]);
            }
            return redirect()->back()->with('success', 'Property additional details updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating property additional details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update property additional details.');
        }
    }

    public function editPropertyDetail(Request $request)
    {
        try {
            $propertyId = $request->id;
            PropertyInfo::where('Id', $propertyId)->update([
                'PropertyName' => $request->propertyname,
                'Company' => $request->company,
                'PropertyContact' => $request->propertycontact,
                'Units' => $request->units,
                'Year' => $request->yearbuilt,
                'YearRemodel' => $request->yearremodeled,
                'Email' => $request->email,
                'Address' => $request->address,
                'CityId' => $request->editpropertycity,
                'ContactNo' => $request->contactno,
                'Area' => $request->area,
                'Zone' => $request->zone,
                'Zip' => $request->zipcode,
                'WebSite' => $request->website,
                'CreatedOn' => Carbon::now(),
                'latitude' => $request->lat,
                'longitude' => $request->lon,
                'officehour' => $request->officehours,
                'fax' => $request->faxno,
            ]);
            return response()->json(['message' => 'Property additional details updated successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating property additional details: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update property additional details.'], 500);
        }
    }


    private function getLatLonFromIframe($iframeUrl)
    {
        $query = parse_url($iframeUrl, PHP_URL_QUERY);
        parse_str($query, $params);

        if (isset($params['pb'])) {
            $pbParts = explode('!', $params['pb']);

            $latitude = null;
            $longitude = null;

            foreach ($pbParts as $part) {
                if (strpos($part, '3d') === 0) {
                    $latitude = substr($part, 2);
                }
                if (strpos($part, '2d') === 0) {
                    $longitude = substr($part, 2);
                }
            }

            if ($latitude && $longitude) {
                return ['latitude' => $latitude, 'longitude' => $longitude];
            }
        }
        return ['latitude' => null, 'longitude' => null];
    }
}

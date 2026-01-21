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
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Resources\PropertyCollection;
use App\Models\UserProperty;
use App\Models\ApartmentFeature;
use App\Models\CommunityAmenities;
use App\Models\FloorPlanCategory;
use App\Models\PropertyFloorPlanDetail;
use App\Models\GalleryType;
use App\Models\PropertyAdditionalInfo;
use Illuminate\Support\Facades\Storage;
use App\Models\CommunityDescription;
use Illuminate\Pagination\LengthAwarePaginator;




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
        try {
            $propertyinfo = $this->propertyDetailsRepository->getEditPropertyDetails($id);
            $data = new PropertyCollection($propertyinfo);
            $propertyDetails = $data->toArray(request());

            // Handle invalid ID or truncated table
            if (empty($propertyDetails)) {
                return redirect()->route('home')->with('error', 'Property not found or is no longer available.');
            }

            $propertyDetails = $propertyDetails[0];

            $communityFeatures = $propertyDetails['apartmentinfo'] ?? '';
            $featureIds = !empty($communityFeatures) ? explode(',', $communityFeatures) : [];
            $features = ApartmentFeature::whereIn('id', $featureIds)->get();

            $amenities = $propertyDetails['amenities'] ?? '';
            $amenitiesIds = !empty($amenities) ? explode(',', $amenities) : [];
            $amenitiesDetails = CommunityAmenities::whereIn('Id', $amenitiesIds)->get();

            $auth_user = Auth::guard('renter')->user();
            $userid = $auth_user->Id ?? null;
            
            $renterinfo = null;
            if ($userid) {
                $renterinfo = Login::where('Id', $userid)->with('renterinfo')->first();
                
                // Add to recent view history
                $existingRecord = UserProperty::where('userId', $userid)->where('propertyId', $id)->first();
                if ($existingRecord) {
                    $existingRecord->lastviewed = now();
                    $existingRecord->save();
                } else {
                    UserProperty::create([
                        'userId' => $userid,
                        'propertyId' => $id,
                        'lastviewed' => now(),
                    ]);
                }
            }

            $categories = FloorPlanCategory::all();

            return view('user.property.propertyDisplay', [
                'propertyDetails' => $propertyDetails,
                'renterinfo' => $renterinfo,
                'featureNames' => $features,
                'amenitiesDetails' => $amenitiesDetails,
                'categories' => $categories,
                'propertyinfo'  => $propertyinfo,
            ]);

        } catch (\Exception $e) {
            Log::error('Property Display Error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while loading the property details.');
        }
    }

    public function editProperty($id)
    {
        $propertyinfo = $this->propertyDetailsRepository->getEditPropertyDetails($id)->first();
        
        if (!$propertyinfo) {
            return redirect()->route('my-properties')->with('error', 'Property not found.');
        }

        $state = State::all();
        $categories = FloorPlanCategory::all();
        $selectFloorPlan = PropertyFloorPlanDetail::where('PropertyId', $id)->get();
        $gallerytype = GalleryType::where('PropertyId', $id)->with('gallerydetail')->get();
        $galleryDetailsImages = @$gallerytype[0];
        $apartmentFeature = ApartmentFeature::all();
        $amenities = CommunityAmenities::all();

        return view('user.property.editProperty', [
            'propertyinfo' => $propertyinfo,
            'state' => $state,
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

        if ($request->has('date_filter')) {
            if ($request->date_filter == 'last_month') {
                $query->where('CreatedOn', '>=', now()->subMonth());
            } elseif ($request->date_filter == 'custom_range' && $request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('CreatedOn', [$request->start_date, $request->end_date]);
            }
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
        $state = State::all();
        return view('user.property.addProperty', compact('state'));
    }

    public function addNewProperty(Request $request)
    {
        Log::info('Add property attempt started', [
            'input' => $request->except(['_token'])
        ]);

        try {
            if (!Auth::guard('renter')->check()) {
                throw new \Exception('User not authenticated. Please log in again.');
            }
            $userid = Auth::guard('renter')->user()->Id;

            $validator = \Validator::make($request->all(), [
                'add_property_state'   => 'required',
                'add_property_city'    => 'required',
                'termsandcondition'    => 'required',
                'propertyname'         => 'required|string|max:255',
                'managementcompany'    => 'required|string|max:255',
                'addpropertyemail'     => 'required|email',
                'pcontact'             => 'required|string|max:100',
                'units'                => 'required|integer|min:1',
                'yearbuilt'            => 'required|date',
                'year_remodeled'       => 'nullable|date',
                'area'                 => 'required|string|max:255',
                'address'              => 'required|string|max:255',
                'zipcode'              => 'required|string|max:20',
                'contactno'            => 'required|string|max:20',
                'website'              => 'nullable|url|max:255',
                'officehours'          => 'nullable|string|max:1000',
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

            if ($validator->fails()) {
                Log::warning('Add property validation failed', [
                    'user_id' => $userid,
                    'errors' => $validator->errors()->all()
                ]);
                return back()->withErrors($validator)->withInput()->with('error', 'Validation failed. Please check the form.');
            }

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
                'Fax'            => '', // Default to empty
                'Zone'           => '', // Default to empty
                'Status'         => $request->status ?? '1',
                'Featured'       => $request->featured ?? '1',
                'ActiveOnSearch' => $request->activeonsearch ?? '1',
            ];

            Log::debug('Data to be inserted into PropertyInfo', $propertyData);

            $property = PropertyInfo::create($propertyData);

            Log::info('Property created successfully', ['property_id' => $property->Id]);

            return redirect()->route('edit-properties', $property->Id)->with('success', 'Property added successfully. You can now add floor plans and images.');

        } catch (\Exception $e) {
            Log::error('Error adding property', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'user_id' => isset($userid) ? $userid : null,
                'input'   => $request->except(['_token'])
            ]);

            return back()->withInput()->with('error', 'An error occurred while adding the property: ' . $e->getMessage());
        }
    }


    public function myProperties(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $myproperty = PropertyInfo::where('UserId', $userid)
            ->with(['gallerytype.gallerydetail', 'city.state'])
            ->get();
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
        $request->validate([
            'comments' => 'required',
            'propertyId' => 'required',
        ]);

        try {
            $userid = Auth::guard('renter')->user()->Id;
            PropertyInquiry::create([
                'PropertyId' => $request->propertyId,
                'UserId'     => $userid,
                'UserName'   => $request->firstname,
                'LastName'   => $request->lastname,
                'Email'      => $request->email,
                'Phone'      => $request->phone,
                'MoveDate'   => $request->movedate,
                'Message'    => $request->comments,
                'CreatedOn'  => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your request has been sent successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Request Quote Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending your request.'
            ], 500);
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
        $request->validate([
            'propertyId' => 'required',
            'category' => 'required',
            'plan_name' => 'required|string|max:255',
            'starting_at' => 'nullable|numeric',
            'square_footage' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
        ]);

        try {
            $dates = $request->dates;
            $avail_date = is_array($dates) ? implode(',', array_filter($dates)) : '';

            $data = [
                'PropertyId' => $request->propertyId,
                'CategoryId' => $request->category,
                'PlanType' => $request->plan_type,
                'FloorPlan' => $request->floor_plan,
                'PlanName' => $request->plan_name,
                'Footage' => $request->square_footage,
                'Available_Url' => $request->available_url,
                'special' => $request->special,
                'expiry_date' => $request->expiry_date,
                'avail_date' => $avail_date,
                'isavailable' => '1',
                'Status' => '1',
                'deposit' => $request->deposit,
                'floorplan_link' => $request->link,
                'Price' => $request->starting_at,
                'Comments' => $request->unit_description,
                'CreatedOn' => Carbon::now(),
                'ModifiedOn' => Carbon::now(),
            ];

            PropertyFloorPlanDetail::create($data);

            Log::info('Floor plan created', ['property_id' => $request->propertyId, 'plan_name' => $request->plan_name]);

            return redirect()->route('edit-properties', $request->propertyId)->with('success', 'Floor plan created successfully.');
        } catch (\Exception $e) {
            Log::error('Error storing floor plan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateFloorPlan(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'plan_name' => 'required|string|max:255',
            'starting_at' => 'nullable|numeric',
            'square_footage' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
        ]);

        try {
            $dates = $request->dates;
            $avail_date = is_array($dates) ? implode(',', array_filter($dates)) : $request->avail_date;

            PropertyFloorPlanDetail::where('Id', $id)->update([
                'CategoryId' => $request->category,
                'PlanType' => $request->plan_type,
                'FloorPlan' => $request->floor_plan,
                'PlanName' => $request->plan_name,
                'Footage' => $request->square_footage,
                'Available_Url' => $request->available_url,
                'special' => $request->special,
                'expiry_date' => $request->expiry_date,
                'avail_date' => $avail_date,
                'deposit' => $request->deposit,
                'floorplan_link' => $request->link,
                'Price' => $request->starting_at,
                'Comments' => $request->unit_description,
                'ModifiedOn' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Floor plan updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating floor plan', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update floor plan.');
        }
    }

    public function deleteFloorPlan($id)
    {
        try {
            PropertyFloorPlanDetail::where('Id', $id)->delete();
            return redirect()->back()->with('success', 'Floor plan deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting floor plan', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete floor plan.');
        }
    }

    public function uploadImage(Request $request)
    {
        Log::info('Image upload attempt', ['property_id' => $request->property_id]);

        try {
            $request->validate([
                'property_id' => 'required',
                'imagetitle' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'propertyimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            $propertyId = $request->property_id;
            
            // Get or create GalleryType for this property
            $galleryType = GalleryType::getOrCreateForProperty($propertyId);
            $galleryTypeId = $galleryType->Id;

            if (!$request->hasFile('propertyimage')) {
                throw new \Exception('No image file provided.');
            }

            $file = $request->file('propertyimage');
            $fileExtension = $file->getClientOriginalExtension();

            // Create initial detail record to get ID for filename
            $galleryDetail = GalleryDetails::create([
                'GalleryId' => $galleryTypeId,
                'ImageTitle' => $request->imagetitle,
                'Description' => $request->description,
                'DefaultImage' => 0, // Don't default to 1 for every upload
                'display_in_gallery' => 1,
                'CreatedOn' => Carbon::now(),
                'ModifiedOn' => Carbon::now(),
                'Status' => 1,
            ]);

            // Note: If primary key is 'Id', Eloquent might return it via ->getAttribute('Id') or just ->Id
            // If primaryKey is not set in model, it defaults to 'id'
            $newId = $galleryDetail->Id ?? $galleryDetail->id;
            
            if (!$newId) {
                throw new \Exception('Failed to generate image ID in database.');
            }

            $savedImageName = 'Gallery_propertyimage_' . $newId . '_' . $propertyId . '.' . $fileExtension;

            Log::debug('Uploading to S3', ['name' => $savedImageName]);
            $uploadedImageUrl = $this->uploadToS3($propertyId, $savedImageName, $file);
            
            if (!$uploadedImageUrl) {
                // Cleanup database record if upload fails
                $galleryDetail->delete();
                throw new \Exception('Failed to upload image to storage.');
            }

            // Update with final filename
            $galleryDetail->update([
                'ImageName' => $savedImageName,
            ]);

            Log::info('Image upload successful', ['id' => $newId, 'url' => $uploadedImageUrl]);

            return redirect()->back()->with('success', 'Image uploaded successfully');
        } catch (\Exception $e) {
            Log::error('Error uploading image', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'input'   => $request->except(['propertyimage'])
            ]);
            return redirect()->back()->withInput()->with('error', 'Upload failed: ' . $e->getMessage());
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
            $existingInfo = PropertyAdditionalInfo::where('PropertyId', $propertyId)->update([
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
                PropertyAdditionalInfo::create([
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


    public function editGeneralDetail(Request $request, $id)
    {
        $propertyId = $id;
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
            return redirect()->back()->with('success', 'General details updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating general details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update general details.');
        }
    }

    public function editPropertyDetail(Request $request, $id)
    {
        try {
            $propertyId = $id;
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
                'latitude' => $request->lat,
                'longitude' => $request->lon,
                'officehour' => $request->officehours,
                'fax' => $request->faxno,
            ]);
            return redirect()->back()->with('success', 'Main property details updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating property details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update property details.');
        }
    }


    private function getLatLonFromIframe($iframeHtml)
    {
        // Extract src from iframe tag if pasted as whole tag
        $url = $iframeHtml;
        if (preg_match('/src="([^"]+)"/', $iframeHtml, $match)) {
            $url = $match[1];
        }

        $query = parse_url($url, PHP_URL_QUERY);
        if (!$query) return ['latitude' => null, 'longitude' => null];
        
        parse_str($query, $params);

        if (isset($params['pb'])) {
            $pbParts = explode('!', $params['pb']);

            $latitude = null;
            $longitude = null;

            foreach ($pbParts as $part) {
                // Google Maps pb format: !3dLAT!2dLON
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

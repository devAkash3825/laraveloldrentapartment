<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyCollection;
use App\Models\ApartmentFeature;
use App\Models\City;
use App\Models\CommunityAmenities;
use App\Models\CommunityDescription;
use App\Models\Favorite;
use App\Models\FloorPlanCategory;

// Controller
use App\Models\GalleryDetails;

// Repositories
use App\Models\GalleryType;

// Collection
use App\Models\Login;

// Models
use App\Models\NoteDetail;
use App\Models\PetsManagement;
use App\Models\PropertyFloorPlanDetail;
use App\Models\PropertyInfo;
use App\Models\School;
use App\Models\State;
use App\Models\Zone;
use App\Repositories\PropertyDetailsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PropertyController extends Controller
{
    protected $propertyDetailsRepository;

    public function __construct(PropertyDetailsRepository $propertyDetailsRepository)
    {
        $this->propertyDetailsRepository = $propertyDetailsRepository;
    }

    public function listProperty(Request $request)
    {
        try {
            $listProperties = $this->propertyDetailsRepository->getListProperties();

            if ($request->ajax()) {
                return DataTables::of($listProperties)
                    ->addIndexColumn()
                    ->addColumn('propertyname', function ($row) {
                        $url = route('admin-property-display', [$row->Id]);
                        return $row->PropertyName
                        ? "<a href='{$url}' class='btn delete-btn font-weight-bold bg-link' data-id='{$row->Id}'>{$row->PropertyName}</a>"
                        : 'N/A';
                    })
                    ->addColumn('city', function ($row) {
                        return $row->city->CityName ?? 'N/A';
                    })
                    ->addColumn('features', function ($row) {
                        return $row->Featured == 1
                        ? '<p class="text-success mb-0">Featured</p>'
                        : '<p class="text-muted mb-0">General</p>';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->Status == 1) {
                            return "<a href='javascript:void(0)' id='changetopropertystatus' class='changetopropertystatus c-pill c-pill--success' data-status='" . $row->Status . "' onclick='changeStatus(" . $row->Id . ")'> Active </a>";
                        } elseif ($row->Status == 2) {
                            return "<a href='javascript:void(0)' id='changetopropertystatus' class='changetopropertystatus c-pill c-pill--danger' data-status='" . $row->Status . "' onclick='changeStatus(" . $row->Id . ")'> Leased </a>";
                        } else {
                            return "<a href='javascript:void(0)' id='changetopropertystatus' class='changetopropertystatus c-pill c-pill--warning' data-status='" . $row->Status . "' onclick='changeStatus(" . $row->Id . ")'> InActive </a>";
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $editUrl       = route('admin-edit-property', [$row->Id]);
                        $deleteurl     = route('admin-delete-property', [$row->Id]);
                        $user          = Auth::guard('admin')->user();
                        $actionButtons = '<div class="table-actionss-icon table-actions-icons float-none">';

                        if ($user && $user->hasPermission('property_addedit')) {
                            $actionButtons .= '<a href="' . $editUrl . '" class="edit-btn">
                                                    <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i>
                                                </a>';
                        }
                        if ($user && $user->hasPermission('property_delete')) {
                            $actionButtons .= '<a href="javascript:void(0)" id="delete-property" class="propertyDlt" data-id="' . $row->Id . '" data-url="' . $deleteurl . '">
                                                    <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                                </a>';
                        }
                        $actionButtons .= '</div>';
                        return $actionButtons;
                    })

                    ->rawColumns(['propertyname', 'city', 'features', 'status', 'action'])
                    ->make(true);
            }

            return view('admin.property.listProperties');
        } catch (\Exception $e) {

            \Log::error('Error fetching property list: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['error' => 'Unable to fetch property list. Please try again later.'], 500);
            }

            return redirect()->route('admin-dashboard')->with('error', 'Something went wrong while fetching the property list.');
        }
    }

    public function addProperty()
    {
        $listofManagers = Login::where('Status', 1)->where('user_type', 'M')->get();
        $zones          = Zone::all();
        return view(
            'admin.property.addProperty',
            [
                'listofManagers' => $listofManagers,
                'zones'          => $zones,
            ]
        );
    }

    public function deleteProperty($id)
    {
        $property = PropertyInfo::where('Id', $id)->first();
        if ($property) {
            $property->communitydescription()->delete();
            $property->propertyfloorplandetails()->delete();
            PropertyInfo::where('Id', $id)->delete();
            return response()->json(['message' => 'Property and related data deleted successfully']);
        } else {
            return response()->json(['error' => 'Failed To Delete the Property Please Try Again !']);
        }

    }

    public function editProperty($id)
    {
        
        $propertyinfo = PropertyInfo::where('Id', $id)
            ->with('propertyfloorplandetails.gallerydetail')
            ->with('newAdditionalInfo')
            ->with('gallerytype.gallerydetail')
            ->with('login')
            ->with('propertyfloorplandetails')
            ->with('city.state')
            ->with('apartmentfeatures')
            ->with('communitydescription')
            ->first();

        
        $categories           = FloorPlanCategory::all();
        $selectFloorPlan      = PropertyFloorPlanDetail::where('PropertyId', $id)->get();
        $gallerytype          = GalleryType::where('PropertyId', $id)->with('gallerydetail')->get();
        $galleryDetailsImages = @$gallerytype[0];
        $apartmentFeature     = ApartmentFeature::all();
        $amenities            = CommunityAmenities::all();
        $managerIds           = Login::where('user_type', 'M')->get();
        $zones                = Zone::all();

        return view('admin.property.editProperty', [
            'managerIds'       => $managerIds,
            'propertyinfo'     => $propertyinfo,
            'categories'       => $categories,
            'selectFloorPlan'  => $selectFloorPlan,
            'galleryDetails'   => $galleryDetailsImages,
            'propertyId'       => $id,
            'apartmentFeature' => $apartmentFeature,
            'amenities'        => $amenities,
            'zones'            => $zones,
        ]);
    }

    public function editGeneralDetails(Request $request)
    {
        try {
            $apartmentfeatures     = $request->apartmentfeatures;
            $amenities             = $request->amenities;
            $amenitieslist         = implode(",", $amenities);
            $apartmentfeatureslist = implode(",", $apartmentfeatures);
            $propertyId            = $request->property_id;
            PropertyInfo::where('Id', $propertyId)->update([
                'PropertyFeatures'  => $apartmentfeatureslist,
                'CommunityFeatures' => $amenitieslist,
                'Keyword'           => $request->keywords,
            ]);
            $existingInfo = CommunityDescription::where('PropertyId', $propertyId)->first();
            if ($existingInfo) {
                CommunityDescription::where('PropertyId', $propertyId)->update([
                    'Description'    => $request->community_description,
                    'ModifiedOn'     => Carbon::now(),
                    'Status'         => 1,
                    'Agent_comments' => $request->agent_comments,
                ]);
            } else {
                CommunityDescription::create([
                    'PropertyId'     => $propertyId,
                    'Description'    => $request->community_description,
                    'ModifiedOn'     => Carbon::now(),
                    'Status'         => 1,
                    'CreatedOn'      => Carbon::now(),
                    'Agent_comments' => '',
                ]);
            }
            return response()->json(['message' => 'Property General details updated successfully.'], 200);

        } catch (\Exception $e) {
            \Log::error('Error updating property additional details: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update property General details.'], 500);
        }
    }

    public function getProperty(Request $request)
    {
        $properytInfo = PropertyInfo::where('Status', 1)->get();
        dd($properytInfo);
    }

    public function propertyDisplay($id)
    {
        $propertyinfo    = $this->propertyDetailsRepository->getAllPropertiesDetail($id);
        $data            = new PropertyCollection($propertyinfo);
        $propertyDetails = $data->toArray(request());
        $propertyDetails = $propertyDetails[0];

        $categories       = FloorPlanCategory::all();
        $floorplandetails = PropertyFloorPlanDetail::where('PropertyId', $id)->get();

        $amenityfn         = $propertyDetails['amenities'];
        $selectedamenities = explode(',', $amenityfn);
        $amenities         = CommunityAmenities::whereIn('Id', $selectedamenities)->get();

        $featuresfn       = $propertyDetails['apartmentinfo'];
        $selectedfeatures = explode(',', $featuresfn);
        $features         = ApartmentFeature::whereIn('Id', $selectedfeatures)->get();

        return view('admin.property.propertyDisplay', [
            'propertyDetails'  => $propertyDetails,
            'categories'       => $categories,
            'floorplandetails' => $floorplandetails,
            'amenities'        => $amenities,
            'features'         => $features,
        ]);
    }

    public function renterPropertyDisplay($propertyId, $renterId)
    {
        $propertyinfo    = $this->propertyDetailsRepository->getAllPropertiesDetail($propertyId);
        $data            = new PropertyCollection($propertyinfo);
        $propertyDetails = $data->toArray(request());
        $propertyDetails = $propertyDetails[0];

        $floorPlanCatg    = FloorPlanCategory::all();
        $floorplandetails = PropertyFloorPlanDetail::where('PropertyId', $propertyId)->get();
        $renterinfo       = Login::where('Id', $renterId)->with('renterinfo')->first();
        $adminID          = Auth::guard('admin')->user()->id;
        $notes            = NoteDetail::where('property_id', $propertyId)->where('user_id', $renterId)->get();

        return view(
            'admin.property.propertyDisplay',
            [
                'propertyDetails'  => $propertyDetails,
                'renterid'         => $renterinfo,
                'userid'           => $renterId,
                'floorPlanCatg'    => $floorPlanCatg,
                'floorplandetails' => $floorplandetails,

            ]
        );
    }

    public function addFavorite(Request $request)
    {
        $renterId   = $request->renterId;
        $propertyId = $request->propertyId;

        $favorite = Favorite::where('PropertyId', $propertyId)->where('UserId', $renterId)->first();
        if ($favorite) {
            $favId  = $favorite->Id;
            $delete = Favorite::where('Id', $favId)->delete();
            return response()->json(['failed' => 'Favorite removed successfully'], 200);
        } else {
            $favorite             = new Favorite();
            $favorite->PropertyId = $propertyId;
            $favorite->UserId     = $renterId;
            $favorite->AddedOn    = now();
            $favorite->Status     = true;
            $favorite->Notes      = $request->input('notes', null);
            $favorite->save();
            return response()->json(['status' => true], 201);
        }
    }

    public function isFavorite(Request $request)
    {
        $renterId   = $request->renterId;
        $propertyId = $request->propertyId;
        $isFavorite = Favorite::where('PropertyId', $propertyId)
            ->where('UserId', $renterId)
            ->exists();

        return response()->json(['isFavorite' => $isFavorite]);
    }

    public function schoolManagement(Request $request)
    {
        $SchoolManagement = School::all();

        if ($request->ajax()) {
            $schools = $SchoolManagement = School::all();
            return DataTables::of($schools)
                ->addIndexColumn()
                ->addColumn('schoolname', function ($row) {
                    return $row->school_name;
                })
                ->addColumn('type', function ($row) {
                    return $row->school_type ?? 'N/A';
                })
                ->addColumn('status', function ($row) {
                    $status = '';
                    switch ($row->status) {
                        case "1":
                            $status = '<a href="javascript:void(0)" class="c-pill c-pill--success">Active</a>';
                            break;
                        case "0":
                            $status = '<a href="javascript:void(0)" class="c-pill c-pill--warning">Inactive</a>';
                            break;
                        default:
                            $status = 'Unknown';
                    }
                    $statusText = $row->Status == 2 ? "Leased" : "Unknown";
                    return $status;
                })
                ->addColumn('actions', function ($row) {
                    $user          = Auth::guard('admin')->user();
                    $editUrl       = route('admin-edit-city', ['id' => $row->school_id]);
                    $deleteUrl     = route('admin-delete-school', ['id' => $row->school_id]);
                    $actionButtons = '<div class="table-actionss-icon table-actions-icons float-none">';
                    $actionButtons .= '<a href="' . $editUrl . '" class="edit-btn"> <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i> </a>';
                    $actionButtons .= '<a href="javascript:void(0)" class="deleterecords" data-id="' . $row->school_id . '" data-url="' . $deleteUrl . '">
                                        <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                        </a>';
                    $actionButtons .= '</div>';

                    return $actionButtons;
                })
                ->rawColumns(['cityname', 'statename', 'status', 'actions'])
                ->make(true);
        }
        return view('admin.property.schoolManagement', ['data' => $SchoolManagement]);
    }

    public function addSchool()
    {
        return view('admin.property.addSchool');
    }

    public function schoolStore(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_type' => 'required|in:Elementary,Middle,High,District',
        ]);
        try {
            $createschool = School::create([
                'school_name' => $request->school_name,
                'school_type' => $request->school_type,
                'added'       => Carbon::now(),
                'modified'    => Carbon::now(),

            ]);
            return response()->json([
                'success' => 'School Created Successfully',
                'message' => 'School Created Successfully'
            ], 200);
        } catch (\Exception $err) {
            Log::error('State Not Created: ', [
                'error_message' => $err->getMessage(),
            ]);
            return response()->json(
                [
                    'error' => 'School Not Created. Please Try Again.',
                    'message' => 'School Not Created. Please Try Again.',
                ],
                500
            );
        }
    }

    public function deleteSchool($id)
    {
        School::where('school_id', $id)->delete();

        return response()->json(
            [
                'success' => 'School has been deleted successfully.',
                'message' => 'School has been deleted successfully.',
            ]
        );
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        School::whereIn('school_id', $ids)->delete();

        return response()->json(['message' => 'Selected records have been deleted successfully.']);
    }

    public function feesManagement()
    {
        return view('admin.property.feesManagement');
    }

    public function feeManagement()
    {

        return view('admin.property.feesManagement');
    }

    public function getCitybyStateId($StateId)
    {
        $stateId = $StateId;
        $loginId = Auth::guard('admin')->user()->id;

        $cities = City::where('status', '1')
            ->where('StateId', $stateId)
            ->whereHas('adminAccesses', function ($query) use ($loginId) {
                $query->whereHas('adminDetail', function ($q) use ($loginId) {
                    $q->where('admin_detail_id', $loginId);
                });
            })
            ->orderBy('CityName', 'ASC')
            ->get();
        dd($cities);
    }

    public function addStates()
    {
        return view('admin.property.addStates');
    }

    public function createState(Request $request)
    {
        $request->validate([
            'statename' => 'required',
            'statecode' => 'required',
        ]);
        try {
            $createState = State::create([
                'StateName' => $request->statename,
                'StateCode' => $request->statecode,
                'TimeZone'  => $request->zonetime,
            ]);
            return response()->json(['message' => 'State Created Successfully'], 200);
        } catch (\Exception $err) {
            Log::error('State Not Created: ', [
                'error_message' => $err->getMessage(),
            ]);
            return response()->json(['error' => 'State Not Created. Please Try Again.'], 500);
        }
    }

    public function manageStates(Request $request)
    {
        $states = State::all();
        if ($request->ajax()) {
            return DataTables::of($states)->addIndexColumn()
                ->addColumn('statename', function ($row) {
                    return $row->StateName;
                })
                ->addColumn('actions', function ($row) {
                    $editUrl     = route('admin-edit-states', ['id' => $row->Id]);
                    $deleteState = route('admin-delete-states', ['id' => $row->Id]);

                    $actionbtn = '<div class="table-actionss-icon table-actions-icons float-none">
                                    <a href="' . $editUrl . '" class="edit-btn"><i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i></a>
                                    <a href="javascript:void(0)" id="delete-property" class="propertyDlt" data-id="' . $row->Id . '" data-url="' . $deleteState . '">
                                            <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                    </a>
                            </div>';

                    return $actionbtn;
                })
                ->rawColumns(['managername', 'actions'])
                ->make(true);
        }
        return view('admin.property.manageStates');
    }

    public function editStates($id)
    {
        $state = State::where('Id', $id)->first();
        return view('admin.property.editStates', ['states' => $state]);
    }

    public function updateStates(Request $request)
    {
        try {
            $id           = $request->stateid;
            $updatestates = State::where('Id', $id)->update([
                'StateName' => $request->statename,
                'StateCode' => $request->statecode,
                'status'    => $request->status,
            ]);
            if ($updatestates) {
                return response()->json(['message' => 'State has been updated successfully.'], 200);
            } else {
                return response()->json(['error' => 'Failed to update state. Please try again.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error updating state: ' . $e->getMessage(), [
                'stateid' => $request->stateid,
                'data'    => $request->all(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    public function deleteStates($id)
    {
        $deletestate = State::where('Id', $id)->delete();
        if ($deletestate) {
            return response()->json(['message' => 'State have been deleted successfully.']);
        } else {
            return response()->json(['error' => 'There might be some Error ! Please Try Again']);
        }
    }

    public function manageCity(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::with('state')->get();
            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('cityname', function ($row) {
                    return $row->CityName;
                })
                ->addColumn('statename', function ($row) {
                    return optional($row->state)->StateName ?? 'N/A';
                })
                ->addColumn('status', function ($row) {
                    $status = '';
                    switch ($row->status) {
                        case "1":
                            $status = '<a href="javascript:void(0)" class="c-pill c-pill--success">Active</a>';
                            break;
                        case "0":
                            $status = '<a href="javascript:void(0)" class="c-pill c-pill--warning">Inactive</a>';
                            break;
                        default:
                            $status = 'Unknown';
                    }
                    $statusText = $row->Status == 2 ? "Leased" : "Unknown";
                    return $status;
                })
                ->addColumn('actions', function ($row) {
                    $user          = Auth::guard('admin')->user();
                    $editUrl       = route('admin-edit-city', ['id' => $row->Id]);
                    $deleteUrl     = route('admin-delete-city', ['id' => $row->Id]);
                    $actionButtons = '<div class="table-actionss-icon table-actions-icons float-none">';
                    $actionButtons .= '<a href="' . $editUrl . '" class="edit-btn"> <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i> </a>';
                    $actionButtons .= '<a href="javascript:void(0)" class="deleterecords" data-id="' . $row->Id . '" data-url="' . $deleteUrl . '">
                                        <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                        </a>';
                    $actionButtons .= '</div>';

                    return $actionButtons;
                })
                ->rawColumns(['cityname', 'statename', 'status', 'actions'])
                ->make(true);
        }

        return view('admin.property.manageCities');
    }

    public function editcity($id)
    {
        $citydetail = City::where('Id', $id)->first();
        $staterecords = State::all();
        return view('admin.property.editcity', ['city' => $citydetail, 'state' => $staterecords]);
    }

    public function updatecity(Request $request)
    {
        try {
            $id           = $request->cityid;
            $updatecity = City::where('Id', $id)->update([
                'StateId'   => $request->stateid,
                'CityName'  => $request->cityname,
                'shortName' => $request->shortname,
                "status" => $request->status,
                'cityrent' => $request->cityrent ?? '',
            ]);
            if ($updatecity) {
                return response()->json(
                    [
                        'success' => 'City has been updated successfully.',
                        'messages' => 'City has been updated successfully.',
                    ],
                    200
                );
            } else {
                return response()->json(['error' => 'Failed to update state. Please try again.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error updating state: ' . $e->getMessage(), [
                'stateid' => $request->stateid,
                'data'    => $request->all(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    public function deletecity($id)
    {
        $deletecity = City::where('Id', $id)->delete();
        if ($deletecity) {
            return response()->json(['message' => 'City Deleted Successfully ']);
        } else {
            return response()->json(['error' => 'Failed To Delete the City Please Try Again !']);
        }
    }

    public function addCity()
    {
        $staterecords = State::all();
        return view('admin.property.addCity', ['state' => $staterecords]);
    }

    public function createCity(Request $request)
    {
        $request->validate([
            'stateid'  => 'required',
            'cityname' => 'required',
        ]);
        try {
            City::create([
                'StateId'   => $request->stateid,
                'CityName'  => $request->cityname,
                'shortName' => $request->shortname,
                "status" => $request->status,
                'cityrent' => $request->cityrent ?? '',
            ]);
            return response()->json([
                'success' => 'City Created Successfully',
                'message' => 'City Created Successfully'
            ], 200);
        } catch (\Exception $err) {
            Log::error('City Not Created: ', [
                'error_message' => $err->getMessage(),
            ]);
            return response()->json(
                [
                    'error' => 'City Not Created. Please Try Again.',
                    'message' => 'City Not Created. Please Try Again.',
                ],
                500
            );
        }
    }

    public function submitProperty(Request $request)
    {

        $validatedData = $request->validate([
            'username'          => 'required',
            'propertyName'      => 'required',
            'managementCompany' => 'required',
            'propertyContact'   => 'required',
            'numberOfUnits'     => 'required',
            'year'              => 'required',
            'address'           => 'required',
            'leasingEmail'      => 'required',
            'state'             => 'required',
            'city'              => 'required',
            'area'              => 'required',
            'zone'              => 'required',
            'zipCode'           => 'required',
            'contactNo'         => 'required',
        ]);
        $embcode     = $request->embddedmap;
        $coordinates = $this->getLatLonFromIframe($embcode);
        try {

            $property = PropertyInfo::create([
                'UserId'          => $request->username,
                'PropertyName'    => $request->propertyName,
                'Company'         => $request->managementCompany,
                'PropertyContact' => $request->propertyContact,
                'Units'           => $request->numberOfUnits,
                'Year'            => $request->year,
                'YearRemodel'     => $request->yearremodeled,
                'Email'           => $request->leasingEmail,
                'Address'         => $request->address,
                'CityId'          => $request->city,
                'ContactNo'       => $request->contactNo,
                'Area'            => $request->area,
                'Zone'            => $request->zone,
                'Zip'             => $request->zipCode,
                'WebSite'         => $request->website,
                'CreatedOn'       => Carbon::now(),
                'ModifiedOn'      => Carbon::now(),
                'Fax'             => $request->fax,
                'officehour'      => $request->officeHours,
                'latitude'        => $coordinates['latitude'],
                'longitude'       => $coordinates['longitude'],
            ]);

            if ($request->hasFile('default-image')) {
                $this->uploadDefaultImage($request->file('default-image'), $property->id);
            }
            return response()->json(['message' => 'Property information submitted successfully!']);
        } catch (\Exception $err) {
            Log::error('Error occurred while submitting property information.', [
                'error_message' => $err->getMessage(),
                'trace'         => $err->getTraceAsString(),
                'request_data'  => $request->all(),
            ]);

            return response()->json(['error' => 'An error occurred while submitting the property information.'], 500);
        }
    }

    public function editPropertyDetails(Request $request)
    {
        dd($request->all());
    }

    public function uploadDefaultImage($image, $propertyId)
    {
        try {
            $file          = $image;
            $fileExtension = $file->getClientOriginalExtension();

            $galleryType = GalleryType::create([
                'PropertyId'  => $propertyId,
                'Title'       => 'General',
                'Description' => 'GalleryDescription',
                'CreatedOn'   => Carbon::now(),
                'ModifiedOn'  => Carbon::now(),
                'Status'      => 1,
            ]);

            $galleryTypeId = $galleryType->Id;

            $galleryDetail = GalleryDetails::create([
                'GalleryId'          => $galleryTypeId,
                'ImageTitle'         => 'General',
                'Description'        => 'GalleryDescription',
                'DefaultImage'       => '1',
                'display_in_gallery' => 1,
                'CreatedOn'          => Carbon::now(),
                'ModifiedOn'         => Carbon::now(),
                'Status'             => 1,
            ]);

            $updateImageNameId = $galleryDetail->id;

            $uploadedImageUrl = $this->uploadToS3($propertyId, $savedImageName, $file);

            if (! $uploadedImageUrl) {
                throw new \Exception('Failed to upload image to S3');
            }

            GalleryDetails::where('Id', $updateImageNameId)->update([
                'ImageName' => $savedImageName,
            ]);

            return true;
        } catch (\Exception $err) {
            Log::error('Error in uploading default image.', [
                'error_message' => $err->getMessage(),
                'trace'         => $err->getTraceAsString(),
                'property_id'   => $propertyId,
            ]);

            throw $err;
        }
    }

    public function getLatLonFromIframe($iframeUrl)
    {

        try {
            $query = parse_url($iframeUrl, PHP_URL_QUERY);
            parse_str($query, $params);

            if (isset($params['pb'])) {
                $pbParts = explode('!', $params['pb']);

                $latitude  = null;
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
        } catch (\Exception $err) {
            Log::error('Error parsing iframe URL for coordinates.', [
                'iframe_url'    => $iframeUrl,
                'error_message' => $err->getMessage(),
                'trace'         => $err->getTraceAsString(),
            ]);

            throw new \Exception('Failed to parse coordinates from iframe URL');
        }
    }

    public function uploadToS3($propertyID, $savedImageName, $file)
    {
        try {
            $filePath = 'Gallery/Property_' . $propertyID . '/Original/' . $savedImageName;
            $result   = Storage::disk('s3')->put($filePath, fopen($file->getRealPath(), 'rb'));

            if ($result) {
                return Storage::disk('s3')->url($filePath);
            } else {
                return false;
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    public function uploadGalleryImages(Request $request)
    {
        try {
            $request->validate([
                'propertyimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $propertyId    = $request->property_id;
            $propertyExist = GalleryType::where('PropertyId', $propertyId)->pluck('Id')->first();

            $file          = $request->file('propertyimage');
            $fileExtension = $file->getClientOriginalExtension();

            if ($propertyExist) {
                $galleryDetail = GalleryDetails::create([
                    'GalleryId'          => $propertyExist,
                    'ImageTitle'         => $request->imagetitle ?? '',
                    'Description'        => $request->description ?? '',
                    'DefaultImage'       => '0',
                    'display_in_gallery' => 1,
                    'CreatedOn'          => Carbon::now(),
                    'ModifiedOn'         => Carbon::now(),
                    'Status'             => 1,
                ]);

                $updateImageNameId = $galleryDetail->id;
                $savedImageName    = 'Gallery_propertyimage_' . $updateImageNameId . '_' . $propertyId . '.' . $fileExtension;

                $uploadedImageUrl = $this->uploadToS3($propertyId, $savedImageName, $file);
                if (! $uploadedImageUrl) {
                    throw new \Exception('Failed to upload image to S3');
                }

                GalleryDetails::where('Id', $updateImageNameId)->update([
                    'ImageName' => $savedImageName,
                ]);

            } else {
                $galleryType = GalleryType::create([
                    'PropertyId'  => $propertyId,
                    'Title'       => 'General',
                    'Description' => 'GalleryDescription',
                    'CreatedOn'   => Carbon::now(),
                    'ModifiedOn'  => Carbon::now(),
                    'Status'      => 1,
                ]);

                $galleryTypeId = $galleryType->PropertyId;

                $galleryDetail = GalleryDetails::create([
                    'GalleryId'          => $galleryTypeId,
                    'ImageTitle'         => $request->imagetitle ?? '',
                    'Description'        => $request->description ?? '',
                    'DefaultImage'       => '0',
                    'display_in_gallery' => 1,
                    'CreatedOn'          => Carbon::now(),
                    'ModifiedOn'         => Carbon::now(),
                    'Status'             => 1,
                ]);

                $updateImageNameId = $galleryDetail->id;
                $savedImageName    = 'Gallery_propertyimage_' . $updateImageNameId . '_' . $propertyId . '.' . $fileExtension;

                $uploadedImageUrl = $this->uploadToS3($propertyId, $savedImageName, $file);

                if (! $uploadedImageUrl) {
                    throw new \Exception('Failed to upload image to S3');
                }

                GalleryDetails::where('Id', $updateImageNameId)->update([
                    'ImageName' => $savedImageName,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Image uploaded successfully']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function propertySearch(Request $request)
    {
        $searchtext = $request->propertysearch;

        $properties = PropertyInfo::where(function ($query) use ($searchtext) {
            $query->where('PropertyName', 'LIKE', "%{$searchtext}%")
                ->orWhere('Area', 'LIKE', "%{$searchtext}%")
                ->orWhere('Zone', 'LIKE', "%{$searchtext}%")
                ->orWhere('Keyword', 'LIKE', "%{$searchtext}%");
        })
            ->orWhereHas('city', function ($query) use ($searchtext) {
                $query->where('CityName', 'LIKE', "%{$searchtext}%")
                    ->orWhereHas('state', function ($query) use ($searchtext) {
                        $query->where('StateName', 'LIKE', "%{$searchtext}%");
                    });
            })
            ->get();

        return view('admin.property.propertySearch', ['searchproperties' => $properties]);
    }

    public function petsManagement(Request $request)
    {
        $data = PetsManagement::all();
        if ($request->ajax()) {
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('pets', function ($row) {
                    return $row->Pets;
                })
                ->addColumn('status', function ($row) {
                    return @$row->Status;
                })
                ->addColumn('actions', function ($row) {
                    $editpet   = route('admin-edit-pets', ['id' => $row->id]);
                    $actionbtn = '<div class="table-actionss-icon table-actions-icons float-none">
                    <a href="' . $editpet . '" class="edit-btn"><i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i></a>
                    <a href="javascript:void(0)" id="delete-property" class="propertyDlt" data-id="" data-url="">
                            <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                    </a>
            </div>';
                    return $actionbtn;
                })
                ->rawColumns(['statename', 'cityname', 'actions'])
                ->make(true);
        }
        return view('admin.property.petsManagement', ['data' => $data]);
    }

    public function searchProperty()
    {
        $getManagers = Login::where('user_type', 'M')->get();
        return view('admin.property.searchProperty', ['getManagers' => $getManagers]);
    }

    public function propertySearching(Request $request)
    {
        $query = PropertyInfo::query();

        if ($request->propertysearch) {
            $query->where('PropertyName', 'LIKE', "%{$request->propertysearch}%")
                ->orWhere('Area', 'LIKE', "%{$request->propertysearcht}%")
                ->orWhere('Zone', 'LIKE', "%{$request->propertysearch}%")
                ->orWhere('Keyword', 'LIKE', "%{$request->propertysearch}%");
        }

        if ($request->propertytitle) {
            $query->where('PropertyName', 'like', '%' . $request->propertytitle . '%');
        }

        if ($request->propertymanager) {
            $query->whereHas('login', function ($q) use ($request) {
                $q->where('Id', 'like', $request->propertymanager);
            });
        }

        if ($request->added_from && $request->added_to) {
            $query->whereBetween('CreatedOn', [$request->added_from, $request->added_to]);
        }

        if ($request->districtschool) {
            $query->where('DistrictSchool', 'like', '%' . $request->districtschool . '%');
        }

        if ($request->filled('state')) {
            $query->whereHas('state', function ($q) use ($request) {
                $q->where('Id', $request->state)
                    ->where('status', '1');
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where('CityName', $request->city)
                    ->where('status', '1');
            });
        }

        if ($request->zipcode) {
            $query->where('ZipCode', $request->zipcode);
        }

        // if ($request->filled('bedroom')) {
        //     $bedroomFilter = $request->bedroom;

        //     if (in_array('all', $bedroomFilter)) {
        //         $query->whereHas('propertyfloorplandetails->propertyfloorplancategory', function ($q) {
        //             $q->where('Status', '1');
        //         });
        //     } else {
        //         $query->whereHas('propertyfloorplancategory', function ($q) use ($bedroomFilter) {
        //             $q->whereIn('Id', $bedroomFilter)
        //               ->where('Status', '1');
        //         });
        //     }
        // }

        if ($request->filled('bedroom')) {
            $bedroomFilter = $request->bedroom;

            if (in_array('all', $bedroomFilter)) {
                $query->whereHas('propertyfloorplandetails.propertyfloorplancategory', function ($q) {
                    $q->where('Status', '1');
                });
            } else {
                $query->whereHas('propertyfloorplancategory', function ($q) use ($bedroomFilter) {
                    $q->whereIn('Id', $bedroomFilter)
                        ->where('Status', '1');
                });
            }
        }

        if ($request->rangefrom && $request->rangeto) {
            $query->whereHas('propertyfloorplandetails', function ($q) use ($request) {
                $q->whereBetween('Price', [$request->rangefrom, $request->rangeto])
                    ->where('Status', '1');
            });
        }

        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        $properties = $query->with('city')->get();
        return view('admin.property.propertySearch', ['searchproperties' => $properties]);

    }

}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyCollection;
use App\Models\ApartmentFeature;
use App\Models\City;
use App\Models\CommunityAmenities;
use App\Models\CommunityDescription;
use App\Models\Favorite;
use App\Services\DataTableService;
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
use App\Models\PropertyAdditionalInfo;
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
            if ($request->ajax()) {
                $query = PropertyInfo::with(['city', 'login'])->select('propertyinfo.*');

                $admin = Auth::guard('admin')->user();
                if ($admin && $admin->admin_type !== 'S') {
                    $query->whereHas('city.adminaccess', function ($q) use ($admin) {
                        $q->where('admin_detail_id', $admin->id);
                    });
                }

                $query->orderBy('propertyinfo.Id', 'desc');

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('propertyname', function ($row) {
                        $url = route('admin-property-display', [$row->Id]);
                        return sprintf('<a href="%s" class="font-weight-bold text-primary">%s</a>', $url, e($row->PropertyName));
                    })
                    ->addColumn('city', DataTableService::safeColumn('city.CityName'))
                    ->addColumn('features', function ($row) {
                        return $row->Featured == 1
                            ? '<span class="badge badge-success">Featured</span>'
                            : '<span class="badge badge-light">General</span>';
                    })
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('action', DataTableService::actionColumn([
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-property', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn',
                            'permission' => 'property_addedit'
                        ],
                        'delete' => [
                            'route' => fn($row) => route('admin-delete-property', ['id' => $row->Id]),
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn',
                            'delete' => true,
                            'traditional' => true,
                            'permission' => 'property_delete'
                        ]
                    ]))
                    ->rawColumns(['propertyname', 'features', 'status', 'action'])
                    ->make(true);
            }

            return view('admin.property.listProperties');
        } catch (\Exception $e) {
            \Log::error('Error fetching property list: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Unable to fetch property list.'], 500)
                : redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function addProperty()
    {
        $listofManagers = Login::where('Status', 1)->where('user_type', 'M')->get();
        $zones          = Zone::all();
        $state          = State::all();
        return view(
            'admin.property.addProperty',
            [
                'listofManagers' => $listofManagers,
                'zones'          => $zones,
                'state'          => $state,
            ]
        );
    }

    public function deleteProperty($id)
    {
        try {
            $property = PropertyInfo::where('Id', $id)->first();
            if ($property) {
                // Delete related records
                $property->communitydescription()->delete();
                $property->propertyfloorplandetails()->delete();
                $property->propertyAdditionalInfo()->delete();
                
                // Get gallery images and delete them from storage if needed
                $galleryTypes = GalleryType::where('PropertyId', $id)->get();
                foreach ($galleryTypes as $type) {
                    $details = GalleryDetails::where('GalleryId', $type->Id)->get();
                    foreach ($details as $detail) {
                        if ($detail->ImageName) {
                            $filePath = 'Gallery/Property_' . $id . '/Original/' . $detail->ImageName;
                            if (Storage::disk('s3')->exists($filePath)) {
                                Storage::disk('s3')->delete($filePath);
                            }
                        }
                        $detail->delete();
                    }
                    $type->delete();
                }

                // Delete favorites related to this property
                Favorite::where('PropertyId', $id)->delete();

                // Delete the property itself
                $property->delete();

                if (request()->ajax()) {
                    return response()->json(['message' => 'Property and all related data deleted successfully']);
                }

                return redirect()->route('admin-property-listproperty')->with('success', 'Property deleted successfully.');
            } else {
                if (request()->ajax()) {
                    return response()->json(['error' => 'Property not found'], 404);
                }
                return redirect()->back()->with('error', 'Property not found.');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting property: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to delete property. ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete property.');
        }
    }

    public function editProperty($id)
    {
        
        $propertyinfo = PropertyInfo::where('Id', $id)
            ->with('propertyfloorplandetails.gallerydetail')
            ->with('propertyAdditionalInfo')
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
            'petList'          => PetsManagement::all(),
        ]);
    }

    public function editGeneralDetails(Request $request)
    {
        try {
            $apartmentfeatures     = $request->apartmentfeatures ?? [];
            $amenities             = $request->amenities ?? [];
            $amenitieslist         = implode(",", $amenities);
            $apartmentfeatureslist = implode(",", $apartmentfeatures);
            $propertyId            = $request->property_id;
            
            $agent_comments = $request->agent_comments ?? $request->editagentcomments;
            $keywords = $request->keywords ?? $request->editkeyword;
            $community_description = $request->community_description ?? $request->editcommunitydescription;

            PropertyInfo::where('Id', $propertyId)->update([
                'PropertyFeatures'  => $apartmentfeatureslist,
                'CommunityFeatures' => $amenitieslist,
                'Keyword'           => $keywords,
            ]);

            $existingInfo = CommunityDescription::where('PropertyId', $propertyId)->first();
            if ($existingInfo) {
                $existingInfo->update([
                    'Description'    => $community_description,
                    'ModifiedOn'     => Carbon::now(),
                    'Status'         => 1,
                    'Agent_comments' => $agent_comments,
                ]);
            } else {
                CommunityDescription::create([
                    'PropertyId'     => $propertyId,
                    'Description'    => $community_description,
                    'ModifiedOn'     => Carbon::now(),
                    'Status'         => 1,
                    'CreatedOn'      => Carbon::now(),
                    'Agent_comments' => $agent_comments,
                ]);
            }

            if ($request->ajax()) {
                return response()->json(['message' => 'Property General details updated successfully.'], 200);
            }

            return redirect()->back()->with('success', 'Property General details updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating property general details: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['message' => 'Failed to update property General details.'], 500);
            }

            return redirect()->back()->with('error', 'Failed to update property General details.');
        }
    }

    public function editAdditionalDetails(Request $request)
    {
        try {
            $propertyId = $request->property_id;
            $pets = $request->pets ?? [];
            $petsList = implode(',', $pets);

            $data = [
                'LeasingTerms'        => $request->editleasingterm,
                'QualifiyingCriteria' => $request->editqualifyingcriteria,
                'Parking'             => $request->editparking,
                'Neighborhood'        => $request->editneighbourhood,
                'drivedirection'      => $request->editdrivingdirection,
                'Pets'                => $petsList,
                'ModifiedOn'          => Carbon::now(),
            ];

            PropertyAdditionalInfo::updateOrCreate(
                ['PropertyId' => $propertyId],
                $data
            );

            if ($request->ajax()) {
                return response()->json(['message' => 'Property Additional details updated successfully.'], 200);
            }

            return redirect()->back()->with('success', 'Property Additional details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating property additional details: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['message' => 'Failed to update property Additional details.'], 500);
            }

            return redirect()->back()->with('error', 'Failed to update property Additional details.');
        }
    }

    public function addFloorPlan($id)
    {
        $categories = FloorPlanCategory::all();
        return view('admin.property.createFloorPlan', [
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
            'square_footage' => 'nullable|numeric',
            'starting_at' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
            'expiry_date' => 'nullable|date',
            'dates' => 'nullable|array',
            'dates.*' => 'nullable|date',
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

            if ($request->ajax()) {
                return response()->json(['message' => 'Floor plan created successfully.']);
            }

            return redirect()->route('admin-edit-property', ['id' => $request->propertyId])->with('success', 'Floor plan created successfully.');
        } catch (\Exception $e) {
            Log::error('Error storing floor plan', ['error' => $e->getMessage()]);
            
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Failed to save floor plan.');
        }
    }

    public function editFloorPlan($id)
    {
        $floorPlan = PropertyFloorPlanDetail::where('Id', $id)->first();
        if (!$floorPlan) {
            return redirect()->back()->with('error', 'Floor plan not found.');
        }
        $categories = FloorPlanCategory::all();
        return view('admin.property.editFloorPlan', [
            'floorPlan' => $floorPlan,
            'categories' => $categories
        ]);
    }

    public function updateFloorPlan(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'plan_name' => 'required|string|max:255',
            'square_footage' => 'nullable|numeric',
            'starting_at' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
            'expiry_date' => 'nullable|date',
            'dates' => 'nullable|array',
            'dates.*' => 'nullable|date',
        ]);

        try {
            $dates = $request->dates;
            $avail_date = is_array($dates) ? implode(',', array_filter($dates)) : $request->avail_date;

            $floorPlan = PropertyFloorPlanDetail::findOrFail($id);
            $floorPlan->update([
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

            if ($request->ajax()) {
                return response()->json(['message' => 'Floor plan updated successfully.']);
            }

            return redirect()->route('admin-edit-property', ['id' => $floorPlan->PropertyId])->with('success', 'Floor plan updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating floor plan', ['id' => $id, 'error' => $e->getMessage()]);
            
            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to update floor plan.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Failed to update floor plan.');
        }
    }

    public function deleteFloorPlan($id)
    {
        try {
            PropertyFloorPlanDetail::where('Id', $id)->delete();
            
            if (request()->ajax()) {
                return response()->json(['message' => 'Floor plan deleted successfully.']);
            }

            return redirect()->back()->with('success', 'Floor plan deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting floor plan', ['id' => $id, 'error' => $e->getMessage()]);
            
            if (request()->ajax()) {
                return response()->json(['message' => 'Failed to delete floor plan.'], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete floor plan.');
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
        if ($request->ajax()) {
            $query = School::query();
            return DataTableService::of($query)
                ->addIndexColumn()
                ->addColumn('schoolname', function ($row) {
                    return e($row->school_name);
                })
                ->addColumn('type', function ($row) {
                    return $row->school_type ?? 'N/A';
                })
                ->addColumn('status', DataTableService::statusColumn('status'))
                ->addColumn('actions', DataTableService::actionColumn([
                    'edit' => [
                        'route' => fn($row) => route('admin-edit-city', ['id' => $row->school_id]),
                        'icon' => 'fa-pen',
                        'class' => 'edit-btn'
                    ],
                    'delete' => [
                        'route' => fn($row) => route('admin-delete-school', ['id' => $row->school_id]),
                        'icon' => 'fa-trash',
                        'class' => 'delete-btn',
                        'delete' => true
                    ]
                ]))
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
        $SchoolManagement = School::all();
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
        try {
            $cities = City::where('StateId', $StateId)->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        if ($request->ajax()) {
            $query = State::query();
            return DataTableService::of($query)
                ->addIndexColumn()
                ->addColumn('statename', function ($row) {
                    return e($row->StateName);
                })
                ->addColumn('actions', DataTableService::actionColumn([
                    'edit' => [
                        'route' => fn($row) => route('admin-edit-states', ['id' => $row->Id]),
                        'icon' => 'fa-pen',
                        'class' => 'edit-btn'
                    ],
                    'delete' => [
                        'route' => fn($row) => route('admin-delete-states', ['id' => $row->Id]),
                        'icon' => 'fa-trash',
                        'class' => 'delete-btn',
                        'delete' => true
                    ]
                ]))
                ->rawColumns(['actions'])
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
            $query = City::with('state')->select('city.*');
            return DataTableService::of($query)
                ->addIndexColumn()
                ->addColumn('cityname', function ($row) {
                    return e($row->CityName);
                })
                ->addColumn('statename', function ($row) {
                    return optional($row->state)->StateName ?? 'N/A';
                })
                ->addColumn('status', DataTableService::statusColumn('status'))
                ->addColumn('actions', DataTableService::actionColumn([
                    'edit' => [
                        'route' => fn($row) => route('admin-edit-city', ['id' => $row->Id]),
                        'icon' => 'fa-pen',
                        'class' => 'edit-btn'
                    ],
                    'delete' => [
                        'route' => fn($row) => route('admin-delete-city', ['id' => $row->Id]),
                        'icon' => 'fa-trash',
                        'class' => 'delete-btn',
                        'delete' => true
                    ]
                 ]))
                ->rawColumns(['status', 'actions'])
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
        $request->validate([
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
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        if ($embcode && (empty($latitude) || empty($longitude))) {
            $coordinates = $this->getLatLonFromIframe($embcode);
            $latitude = $coordinates['latitude'] ?? null;
            $longitude = $coordinates['longitude'] ?? null;
        }

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
                'latitude'        => $latitude,
                'longitude'       => $longitude,
                'Status'          => $request->statuss ?? 1,
                'Featured'        => $request->featured ?? 0,
            ]);

            if ($request->hasFile('default-image')) {
                $this->uploadDefaultImage($request->file('default-image'), $property->Id);
            }

            if ($request->ajax()) {
                return response()->json(['message' => 'Property information submitted successfully!', 'redirect' => route('admin-property-listproperty')]);
            }

            return redirect()->route('admin-property-listproperty')->with('success', 'Property information submitted successfully!');
        } catch (\Exception $err) {
            Log::error('Error occurred while submitting property information.', [
                'error_message' => $err->getMessage(),
                'trace'         => $err->getTraceAsString(),
                'request_data'  => $request->all(),
            ]);

            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred: ' . $err->getMessage()], 500);
            }

            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $err->getMessage());
        }
    }

    public function editPropertyDetails(Request $request)
    {
        try {
            $propertyId = $request->propertyId;
            $property = PropertyInfo::where('Id', $propertyId)->first();
            
            if (!$property) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Property not found'], 404);
                }
                return redirect()->back()->with('error', 'Property not found');
            }

            $property->update([
                'UserId'          => $request->managername,
                'PropertyName'    => $request->propertyName,
                'Company'         => $request->managementCompany,
                'PropertyContact' => $request->propertyContact,
                'Units'           => $request->numberOfUnits,
                'Year'            => $request->yearBuilt,
                'YearRemodel'     => $request->yearRemodeled,
                'Email'           => $request->leasingEmail,
                'Address'         => $request->editaddress,
                'CityId'          => $request->editpropertycity,
                'ContactNo'       => $request->contactNo,
                'Area'            => $request->area,
                'Zone'            => $request->zone,
                'Zip'             => $request->zipCode,
                'WebSite'         => $request->website,
                'ModifiedOn'      => Carbon::now(),
                'Fax'             => $request->fax,
                'officehour'      => $request->officeHours,
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Property details updated successfully!']);
            }

            return redirect()->back()->with('success', 'Property details updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating property details: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to update property details.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Failed to update property details.');
        }
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

            $updateImageNameId = $galleryDetail->Id;
            $savedImageName    = 'Gallery_default_' . $updateImageNameId . '_' . $propertyId . '.' . $fileExtension;

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
                'propertyimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
                'property_id' => 'required'
            ]);

            $propertyId    = $request->property_id;
            $galleryType = GalleryType::firstOrCreate(
                ['PropertyId' => $propertyId],
                [
                    'Title' => 'General',
                    'Description' => 'Property Gallery',
                    'CreatedOn' => Carbon::now(),
                    'ModifiedOn' => Carbon::now(),
                    'Status' => 1,
                ]
            );

            $file          = $request->file('propertyimage');
            $fileExtension = $file->getClientOriginalExtension();

            $galleryDetail = GalleryDetails::create([
                'GalleryId'          => $galleryType->Id,
                'ImageTitle'         => $request->imagetitle ?? '',
                'Description'        => $request->description ?? '',
                'DefaultImage'       => '0',
                'display_in_gallery' => 1,
                'CreatedOn'          => Carbon::now(),
                'ModifiedOn'         => Carbon::now(),
                'Status'             => 1,
            ]);

            $updateImageNameId = $galleryDetail->Id;
            $savedImageName    = 'Gallery_propertyimage_' . $updateImageNameId . '_' . $propertyId . '.' . $fileExtension;

            $uploadedImageUrl = $this->uploadToS3($propertyId, $savedImageName, $file);

            if (!$uploadedImageUrl) {
                $galleryDetail->delete();
                throw new \Exception('Failed to upload image to S3');
            }

            $galleryDetail->update([
                'ImageName' => $savedImageName,
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Image uploaded successfully']);
            }

            return redirect()->back()->with('success', 'Image uploaded successfully');

        } catch (\Exception $e) {
            Log::error('Error uploading gallery image: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }

    public function deleteGalleryImage($id)
    {
        try {
            $image = GalleryDetails::with('gallerytype')->findOrFail($id);
            $propertyId = $image->gallerytype->PropertyId;
            $imageName = $image->ImageName;

            if ($imageName) {
                $filePath = 'Gallery/Property_' . $propertyId . '/Original/' . $imageName;
                if (Storage::disk('s3')->exists($filePath)) {
                    Storage::disk('s3')->delete($filePath);
                }
            }

            $image->delete();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            }

            return redirect()->back()->with('success', 'Image deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting gallery image: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to delete image.'], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete image.');
        }
    }

    public function updateGalleryDetails(Request $request)
    {
        try {
            $id = $request->id;
            $image = GalleryDetails::findOrFail($id);

            $updateData = [
                'ImageTitle' => $request->image_title,
                'Description' => $request->description,
                'floorplan_id' => $request->floorplan_id ?: null,
                'ModifiedOn' => Carbon::now(),
            ];

            if ($request->is_default) {
                GalleryDetails::where('GalleryId', $image->GalleryId)->update(['DefaultImage' => '0']);
                $updateData['DefaultImage'] = '1';
            }

            $image->update($updateData);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Gallery details updated successfully']);
            }

            return redirect()->back()->with('success', 'Gallery details updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating gallery details: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to update gallery details.'], 500);
            }

            return redirect()->back()->with('error', 'Failed to update gallery details.');
        }
    }

    public function propertySearch(Request $request)
    {
        try {
            if ($request->ajax()) {
                $searchtext = $request->propertysearch;
                $query = PropertyInfo::with(['city.state'])->select('propertyinfo.*');

                if ($searchtext) {
                    $query->where(function ($q) use ($searchtext) {
                        $q->where('PropertyName', 'LIKE', "%{$searchtext}%")
                            ->orWhere('Area', 'LIKE', "%{$searchtext}%")
                            ->orWhere('Zone', 'LIKE', "%{$searchtext}%")
                            ->orWhere('Keyword', 'LIKE', "%{$searchtext}%")
                            ->orWhereHas('city', function ($cq) use ($searchtext) {
                                $cq->where('CityName', 'LIKE', "%{$searchtext}%")
                                    ->orWhereHas('state', function ($sq) use ($searchtext) {
                                        $sq->where('StateName', 'LIKE', "%{$searchtext}%");
                                    });
                            });
                    });
                }

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('propertyname', function ($row) {
                        $url = route('admin-property-display', [$row->Id]);
                        return sprintf('<a href="%s" class="font-weight-bold text-primary">%s</a>', $url, e($row->PropertyName));
                    })
                    ->addColumn('city', DataTableService::safeColumn('city.CityName'))
                    ->addColumn('features', function ($row) {
                        return $row->Featured == 1
                            ? '<span class="badge badge-success">Featured</span>'
                            : '<span class="badge badge-light">General</span>';
                    })
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('action', DataTableService::actionColumn([
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-property', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn',
                            'permission' => 'property_addedit'
                        ],
                        'delete' => [
                            'route' => fn($row) => route('admin-delete-property', ['id' => $row->Id]),
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn',
                            'delete' => true,
                            'permission' => 'property_delete'
                        ]
                    ]))
                    ->rawColumns(['propertyname', 'status', 'action'])
                    ->make(true);
            }

            return view('admin.property.propertySearch', [
                'searchText' => $request->propertysearch
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in propertySearch: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'An error occurred.'], 500)
                : redirect()->back()->with('error', 'An error occurred.');
        }
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

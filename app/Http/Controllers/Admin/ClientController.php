<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCollection;
use App\Models\AdminDetail;
use App\Models\Call;

// Third Party
use App\Models\Favorite;

// Collections
use App\Models\Login;
use App\Models\NotifyDetail;

// Repositories
use App\Models\PropertyInfo;

// Services
use App\Models\RenterInfo;

// Models
use App\Models\Source;
use App\Models\UserProperty;
use App\Repositories\FavoriteRepository;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\DataTableService;

class ClientController extends Controller
{

    protected $searchService;
    protected $favoriteRepository;

    public function __construct(SearchService $searchService, FavoriteRepository $favoriteRepository)
    {
        $this->searchService      = $searchService;
        $this->favoriteRepository = $favoriteRepository;
    }

    public function addUser()
    {
        $agent   = AdminDetail::all();
        $sources = Source::all();
        return view('admin.client.addUser', [
            'agents'  => $agent,
            'sources' => $sources,
        ]);
    }


    public function createRenter(Request $request)
    {
        $validatedData = $request->validate([
            'assignAgent'           => 'required',
            'userName'              => 'required|string',
            'emailId'               => 'required|email',
            'password'              => 'required|same:password_confirmation',
            'password_confirmation' => 'required',
            'firstName'             => 'required',
            'lastName'              => 'required',
            'cell'                  => 'required',
        ]);

        DB::beginTransaction();

        try {
            $login = Login::create([
                'UserName'         => $validatedData['userName'],
                'Password'         => bcrypt($validatedData['password']),
                'Email'            => $validatedData['emailId'],
                'CreatedOn'        => now(),
                'ModifiedOn'       => now(),
                'Status'           => '1',
                'UserIp'           => $request->ip(),
                'user_type'        => 'C',
                'acc_to_craiglist' => 'No',
            ]);

            if (! $login) {
                throw new \Exception('Failed to create login');
            }

            $remainderdatetime = null;
            if ($request->filled(['setremainderdate', 'setremaindertime'])) {
                $remainderdatetime = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $request->setremainderdate . ' ' . $request->setremaindertime
                )->format('Y-m-d H:i:s');
            }

            RenterInfo::create([
                'Login_ID'            => $login->Id,
                'FirstName'           => $validatedData['firstName'],
                'LastName'            => $validatedData['lastName'],
                'phone'               => $validatedData['cell'],
                'Evening_phone'       => $request->input('otherphone'),
                'Current_address'     => $request->input('currentAddress'),
                'Cityid'              => $request->input('city'),
                'zipcode'             => $request->input('zipCode'),
                'Floor'               => $request->input('floorpreference'),
                'Garage'              => $request->input('garagePreference'),
                'Laundry'             => $request->input('laundryPreference'),
                'Cross_street'        => $request->input('specificCrossStreet'),
                'Communities_visited' => $request->input('communitiesVisited'),
                'Credit_history'      => $request->input('creditHistory'),
                'Rental_history'      => $request->input('rentalHistory'),
                'Criminal_history'    => $request->input('criminalHistory'),
                'Lease_Term'          => $request->input('leaseTerm'),
                'Work_name_address'   => $request->input('workNameAddress'),
                'Area_move'           => $request->input('moveToArea'),
                'Emove_date'          => $request->input('earliestMoveDate'),
                'Lmove_date'          => $request->input('latestMoveDate'),
                'Rent_start_range'    => $request->input('desiredRentRangeFrom'),
                'Rent_end_range'      => $request->input('desiredRentRangeTo'),
                'bedroom'             => $request->input('bedroom'),
                'Pet_weight'          => $request->input('petinfo'),
                'Additional_info'     => $request->input('additionalinfo'),
                'Locator_Comments'    => $request->input('locatorcomments'),
                'Tour_Info'           => $request->input('tourinfo'),
                'probability'         => $request->input('probability'),
                'Hearabout'           => $request->input('source'),
                'Reminder_date'       => $remainderdatetime,
                'reminder_note'       => $request->input('remaindernote'),
                'added_by'            => $validatedData['assignAgent'],
            ]);

            DB::commit();
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'Renter created successfully!ssss'
            ]);
            return redirect()->route('admin-view-profile', ['id' => $login->Id])->with('success', 'Renter created successfully!qqqq');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function activeRenter(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Login::where('user_type', 'C')
                    ->where('Status', '1')
                    ->with('renterinfo');

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('firstname', DataTableService::safeColumn('renterinfo.Firstname'))
                    ->addColumn('lastname', DataTableService::safeColumn('renterinfo.Lastname'))
                    ->addColumn('probability', function ($row) {
                        return !empty(optional($row->renterinfo)->probability) ? optional($row->renterinfo)->probability . "%" : '-';
                    })
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('adminname', function ($row) {
                        $adminId = optional($row->renterinfo)->added_by;
                        return $adminId ? AdminDetail::getAdminNameById($adminId) : '-';
                    })
                    ->addColumn('actions', DataTableService::actionColumn([
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-renter', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn',
                            'permission' => 'user_addedit'
                        ],
                        'view' => [
                            'route' => fn($row) => route('admin-view-profile', ['id' => $row->Id]),
                            'icon' => 'fa-eye',
                            'class' => 'view-btn'
                        ],
                        'delete' => [
                            'route' => fn($row) => route('admin-deleteRenter', ['id' => $row->Id]),
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn',
                            'delete' => true,
                            'permission' => 'user_delete'
                        ]
                    ], function($action, $row) {
                        $user = Auth::guard('admin')->user();
                        if (isset($action['permission'])) {
                            return $user && $user->hasPermission($action['permission']);
                        }
                        return true;
                    }))
                    ->rawColumns(['status', 'actions'])
                    ->make(true);
            }
            return view('admin.activeRenter');
        } catch (\Exception $e) {
            \Log::error('Error in activeRenter: ' . $e->getMessage());
            return $request->ajax() 
                ? response()->json(['error' => 'Something went wrong.'], 500)
                : redirect()->back()->withErrors('Something went wrong.');
        }
    }
    
    public function inactiveRenter(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Login::where('user_type', 'C')
                    ->where('Status', '0')
                    ->with('renterinfo');

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('firstname', DataTableService::safeColumn('renterinfo.Firstname'))
                    ->addColumn('lastname', DataTableService::safeColumn('renterinfo.Lastname'))
                    ->addColumn('probability', function ($row) {
                        return !empty(optional($row->renterinfo)->probability) ? optional($row->renterinfo)->probability . "%" : '-';
                    })
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('adminname', function ($row) {
                        $adminId = optional($row->renterinfo)->added_by;
                        return $adminId ? AdminDetail::getAdminNameById($adminId) : '-';
                    })
                    ->addColumn('actions', DataTableService::actionColumn([
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-renter', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn',
                            'permission' => 'user_addedit'
                        ],
                        'view' => [
                            'route' => fn($row) => route('admin-view-profile', ['id' => $row->Id]),
                            'icon' => 'fa-eye',
                            'class' => 'view-btn'
                        ],
                        'delete' => [
                            'route' => fn($row) => route('admin-deleteRenter', ['id' => $row->Id]),
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn',
                            'delete' => true,
                            'permission' => 'user_delete'
                        ]
                    ], function($action, $row) {
                        $user = Auth::guard('admin')->user();
                        if (isset($action['permission'])) {
                            return $user && $user->hasPermission($action['permission']);
                        }
                        return true;
                    }))
                    ->rawColumns(['status', 'actions'])
                    ->make(true);
            }
            return view('admin.inactiveRenter');
        } catch (\Exception $e) {
            \Log::error('Error in inactiveRenter: ' . $e->getMessage());
            return $request->ajax() 
                ? response()->json(['error' => 'Something went wrong.'], 500)
                : redirect()->back()->withErrors('Something went wrong.');
        }
    }
    
    public function leasedRenter(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Login::where('user_type', 'C')
                    ->where('Status', '2')
                    ->with('renterinfo');

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('firstname', DataTableService::safeColumn('renterinfo.Firstname'))
                    ->addColumn('lastname', DataTableService::safeColumn('renterinfo.Lastname'))
                    ->addColumn('probability', function ($row) {
                        return !empty(optional($row->renterinfo)->probability) ? optional($row->renterinfo)->probability . "%" : '-';
                    })
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('adminname', function ($row) {
                        $adminId = optional($row->renterinfo)->added_by;
                        return $adminId ? AdminDetail::getAdminNameById($adminId) : '-';
                    })
                    ->addColumn('actions', DataTableService::actionColumn([
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-renter', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn',
                            'permission' => 'user_addedit'
                        ],
                        'view' => [
                            'route' => fn($row) => route('admin-view-profile', ['id' => $row->Id]),
                            'icon' => 'fa-eye',
                            'class' => 'view-btn'
                        ],
                        'delete' => [
                            'route' => fn($row) => route('admin-deleteRenter', ['id' => $row->Id]),
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn',
                            'delete' => true,
                            'permission' => 'user_delete'
                        ]
                    ], function($action, $row) {
                        $user = Auth::guard('admin')->user();
                        if (isset($action['permission'])) {
                            return $user && $user->hasPermission($action['permission']);
                        }
                        return true;
                    }))
                    ->rawColumns(['status', 'actions'])
                    ->make(true);
            }
            return view('admin.leasedRenter');
        } catch (\Exception $e) {
            \Log::error('Error in leasedRenter: ' . $e->getMessage());
            return $request->ajax() 
                ? response()->json(['error' => 'Something went wrong.'], 500)
                : redirect()->back()->withErrors('Something went wrong.');
        }
    }
    
    public function unassignedRenters(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Login::where('user_type', 'C')
                    ->whereHas('renterinfo', function ($query) {
                        $query->whereNull('added_by');
                    })
                    ->with('renterinfo');

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('fullname', function ($row) {
                        $firstname = optional($row->renterinfo)->Firstname;
                        $lastname  = optional($row->renterinfo)->Lastname;
                        return $firstname || $lastname ? "<span class='fullname-tag'>{$firstname} {$lastname}</span>" : '-';
                    })
                    ->addColumn('probability', function ($row) {
                        $probability = optional($row->renterinfo)->probability;
                        return $probability ? $probability . '%' : '-';
                    })
                    ->addColumn('area', DataTableService::safeColumn('renterinfo.Area_move'))
                    ->addColumn('actions', function ($row) {
                        $user = Auth::guard('admin')->user();
                        if ($user && $user->hasPermission('renter_claim')) {
                            return "<div class='table-actions-icons'>
                                <a href='javascript:void(0)' class='btn btn-primary btn-sm' onclick='claimrenter({$row->Id})'>Claim</a>
                            </div>";
                        }
                        return '';
                    })
                    ->rawColumns(['fullname', 'actions'])
                    ->make(true);
            }
            return view('admin.unassignedRenters');
        } catch (\Exception $e) {
            \Log::error('Error in unassignedRenters: ' . $e->getMessage());
            return $request->ajax() 
                ? response()->json(['error' => 'Something went wrong.'], 500)
                : redirect()->back()->withErrors('Something went wrong.');
        }
    }
    
    public function deleteRenters($id)
    {
        $deleteRenter = Login::where('Id', $id)->first();
        if ($deleteRenter) {
            $deleteRenter->renterinfo()->delete();
            Login::where('Id', $id)->delete();
            return response()->json(['message' => 'Renter Deleted Successfully ']);
        } else {
            return response()->json(['error' => 'Failed To Delete the Renter Please Try Again !']);
        }
    }
    
    public function editRenter($id)
    {

        $pageTitle        = "Edit Renter";
        $renterInfo       = Login::with(['renterinfo', 'renterinfo.city.state', 'renterinfo.admindetails'])->findOrFail($id);
        $recentProperties = UserProperty::with([
            'propertyinfo.gallerytype.gallerydetail',
        ])
            ->where('userId', $id)
            ->whereRaw('DATEDIFF(now(), lastviewed) <= 110')
            ->orderByDesc('lastviewed')
            ->limit(100)
            ->get(['propertyId', 'lastviewed', 'userId']);

        $admins  = AdminDetail::select('id', 'admin_name')->get();
        $sources = Source::select('Id', 'SourceName')->get();

        return view('admin.client.editUser', [
            'data'         => $renterInfo,
            'recentviewed' => $recentProperties,
            'admins'       => $admins,
            'sources'      => $sources,
            'userid'       => $id,
            'pageTitle'    => $pageTitle,
        ]);
    }

    public function editRenterUpdate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'editassignAgent' => 'required',
                'edituserName'    => 'required',
                'editemailId'     => 'required|email',
                'editcell'        => 'required',
                'editfirstName'   => 'required',
                'editlastName'    => 'required',
            ]);

            $loginid = $request->userId;

            if (! $loginid) {
                \Log::error('User ID is missing from the request.', ['requestData' => $request->all()]);
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required.',
                ], 400);
            }

            $editstate         = $request->editstate;
            $editcity          = $request->editcity;
            $remainderdatetime = $request->editsetremainderdate . ' ' . $request->editsetremaindertime;
            $remainderdatetime = Carbon::createFromFormat('Y-m-d H:i', $remainderdatetime)->format('Y-m-d H:i:s');

            // Always update login details
            $editrenterlogin = Login::where('Id', $loginid)->update([
                'UserName' => $request->edituserName,
                'Email'    => $request->editemailId,
            ]);

            $checkRenterAvailability = RenterInfo::where('Login_ID', $loginid)->first();

            $renterData = [
                'added_by'            => $checkRenterAvailability ? $request->editassignAgent : $loginid,
                'Firstname'           => $request->editfirstName,
                'Lastname'            => $request->editlastName,
                'phone'               => $request->editcell,
                'Evening_phone'       => $request->editotherphone,
                'Cityid'              => $request->editcity,
                'Current_address'     => $request->editcurrentAddress,
                'zipcode'             => $request->editzipCode,
                'Floor'               => $request->editfloorpreference,
                'Garage'              => $request->editgaragePreference,
                'Laundry'             => $request->editlaundryPreference,
                'Cross_street'        => $request->editspecificCrossStreet,
                'Communities_visited' => $request->editcommunitiesVisited,
                'Credit_history'      => $request->editcreditHistory,
                'Rental_history'      => $request->editrentalHistory,
                'Criminal_history'    => $request->editcriminalHistory,
                'Lease_Term'          => $request->editleaseTerm,
                'Emove_date'          => $request->editearliestMoveDate,
                'Lmove_date'          => $request->editlatestMoveDate,
                'Area_move'           => $request->editmoveToArea,
                'Work_name_address'   => $request->editworkNameAddress,
                'Rent_start_range'    => $request->editdesiredRentRangeFrom,
                'Rent_end_range'      => $request->editdesiredRentRangeTo,
                'bedroom'             => $request->editbed,
                'Pet_weight'          => $request->editpetinfo,
                'Reminder_date'       => $remainderdatetime,
                'reminder_note'       => $request->editremaindernote,
                'Hearabout'           => $request->editsource,
                'probability'         => $request->editprobability,
                'Locator_Comments'    => $request->editlocatorcomments,
                'Tour_Info'           => $request->edittourinfo,
                'Additional_info'     => $request->editadditionalinfo,
            ];

            if (! $checkRenterAvailability) {
                $renterData['Login_ID'] = $loginid;
                $editrenterinfo         = RenterInfo::create($renterData);
            } else {
                $editrenterinfo = RenterInfo::where('Login_ID', $loginid)->update($renterData);
            }

            if ($editrenterlogin !== false && $editrenterinfo !== false) {
                return response()->json([
                    'success' => true,
                    'message' => 'Renter details updated successfully!',
                ]);
            } else {
                \Log::error('Failed to update renter details.', [
                    'loginId'     => $loginid,
                    'requestData' => $request->all(),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update renter details.',
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Validation error while updating renter details.', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error while updating renter details.', [
                'error'   => $e->getMessage(),
                'loginId' => $request->userId,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred.',
                'error'   => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            \Log::critical('Unexpected error while updating renter details.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function searchClient(Request $request)
    {
        $query = Login::where('user_type', 'C');
        if ($request->searchtype == 1) {
            if ($request->filled('status')) {
                $query->where('Status', $request->status);
            }

            if ($request->filled('PR_from') && $request->filled('PR_to')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->whereBetween('probability', [$request->PR_from, $request->PR_to]);
                });
            }

            if ($request->filled('firstname')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->where('Firstname', 'LIKE', '%' . $request->firstname . '%');
                });
            }

            if ($request->filled('lastname')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->where('Lastname', 'LIKE', '%' . $request->lastname . '%');
                });
            }

            if ($request->filled('phone')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->where('phone', 'LIKE', '%' . $request->phone . '%');
                });
            }

            if ($request->filled('CD_from') && $request->filled('CD_to')) {
                $query->whereBetween('CreatedOn', [$request->CD_from, $request->CD_to]);
            }

            if ($request->filled('Emove_date') && $request->filled('Lmove_date')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->whereBetween('move_date', [$request->Emove_date, $request->Lmove_date]);
                });
            }

            if ($request->filled('srch_bedroom')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->where('bedroom', $request->srch_bedroom);
                });
            }

            if ($request->filled('desiredrent_from') && $request->filled('desiredrent_to')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->whereBetween('desired_rent', [$request->desiredrent_from, $request->desiredrent_to]);
                });
            }

            if ($request->filled('email')) {
                $query->where('Email', 'LIKE', '%' . $request->email . '%');
            }

            if ($request->filled('admin')) {
                $query->whereHas('renterinfo', function ($q) use ($request) {
                    $q->where('added_by', $request->admin);
                });
            }
        } else {
            if ($request->filled('search')) {
                $txtsearch = $request->search;

                $query->where(function ($q) use ($txtsearch) {
                    $q->where('UserName', 'LIKE', "%$txtsearch%")
                        ->orWhere('Email', 'LIKE', "%$txtsearch%")
                        ->orWhereHas('renterinfo', function ($r) use ($txtsearch) {
                            $r->where('zipcode', 'LIKE', "%$txtsearch%")
                                ->orWhere('Firstname', 'LIKE', "%$txtsearch%")
                                ->orWhere('Lastname', 'LIKE', "%$txtsearch%")
                                ->orWhere('phone', 'LIKE', "%$txtsearch%");
                        });
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $rentersdata = $query->with('renterinfo')->paginate(10);

        return view('admin.clientSearch', compact('rentersdata'));
    }

    public function searchRenter(Request $request)
    {
        return view('admin.client.searchRenter');
    }
    
    public function searchRenters(Request $request)
    {
        $query = Login::where('user_type', 'C');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('PR_from') && $request->filled('PR_to')) {
            $query->whereHas('renterinfo', function ($q) use ($request) {
                $q->whereBetween('probability', [$request->PR_from, $request->PR_to]);
            });
        }

        $results = $query->with('renterinfo')->paginate(10);

        dd($results);
        return view('admin.client.searchRenter', compact('results'));
    }

    public function searchedRentersResult(Request $request)
    {
        try {
            $query = Login::query()
                ->where('user_type', 'C')
                ->with(['renterInfo.admindetails'])
                ->select('Id', 'UserName', 'Email', 'CreatedOn', 'ModifiedOn', 'Status');

            if ($request->filled('email')) {
                $query->where('Email', 'like', '%' . $request->email . '%');
            }

            if ($request->filled('CD_from') && $request->filled('CD_to')) {
                $query->whereBetween('CreatedOn', [$request->CD_from, $request->CD_to]);
            }

            if ($request->filled('status')) {
                $query->where('Status', $request->status);
            }

            if ($request->filled('PR_from') && $request->filled('PR_to')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->whereBetween('probability', [$request->PR_from, $request->PR_to]);
                });
            }

            if ($request->filled('firstname')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('Firstname', 'like', '%' . $request->firstname . '%');
                });
            }

            if ($request->filled('lastname')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('Lastname', 'like', '%' . $request->lastname . '%');
                });
            }

            if ($request->filled('phone')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('phone', 'like', '%' . $request->phone . '%');
                });
            }

            if ($request->filled('Emove_date')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('Emove_date', '>=', $request->Emove_date);
                });
            }

            if ($request->filled('Lmove_date')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('Lmove_date', '<=', $request->Lmove_date);
                });
            }

            if ($request->filled('srch_bedroom')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('bedrooms', $request->srch_bedroom);
                });
            }

            if ($request->filled('desiredrent_from') && $request->filled('desiredrent_to')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->whereBetween('Rent_start_range', [$request->desiredrent_from, $request->desiredrent_to]);
                });
            } elseif ($request->filled('desiredrent_from')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('Rent_start_range', '>=', $request->desiredrent_from);
                });
            } elseif ($request->filled('desiredrent_to')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('Rent_end_range', '<=', $request->desiredrent_to);
                });
            }

            if ($request->filled('admin') && $request->admin != 0) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('added_by', $request->admin);
                });
            }

            if ($request->filled('keywords_srch')) {
                $query->whereHas('renterInfo', function ($q) use ($request) {
                    $q->where('keywords', 'like', '%' . $request->keywords_srch . '%');
                });
            }
            $renters = $query->paginate(20);
            return response()->json($renters);
        } catch (\Exception $e) {
            \Log::error('Error searching renters: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }
    
    public function switchMapView($id)
    {
        return view('admin.client.mapView', ['userid' => $id]);
    }

    public function MapSearch($id)
    {
        return view('admin.client.mapSearch', ['userid' => $id]);
    }

    public function getFavoriteListing(Request $request, $id)
    {
        $favoriteslist   = $this->favoriteRepository->getFavoriteProperties($id);
        $collectedData   = new FavoriteCollection($favoriteslist);
        $transformeddata = $collectedData->toArray(request());
        if ($request->ajax()) {
            return DataTables::of($transformeddata)->addIndexColumn()
                ->addColumn('propertyName', function ($row) {
                    return $row['propertyname'] ?? 'N/A';
                })
                ->addColumn('city', function ($row) {
                    return $row['city'] ?? 'N/A';
                })
                ->addColumn('state', function ($row) {
                    return $row['state'] ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editurl   = route('admin-edit-property', [$row['id']]);
                    $actionbtn = '<div class="table-actions-icon">
                                    <a href="' . $editurl . '" class=""><i class="fa-solid fa-pen px-2 py-2 edit-icon border"></i></a>
                                    <a href="javascript:void(0)" class=""> <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i></a>
                                    <button id="openChatBtn"><i class="fa-solid fa-message  px-2 py-2 delete-icon border"></i></button>
                                </div>';
                    return $actionbtn;
                })
                ->addColumn('notify', function ($row) {
                    $notifybtn = '<div class="form-group col-md-12 d-flex">
                                    <a type="button" class="btn btn-primary float-right btn-sm text-white"> Notify </a>
                                </div>';
                    return $notifybtn;
                })
                ->rawColumns(['propertyName', 'city', 'state', 'action', 'notify'])
                ->make(true);
        }
    }

    public function getHistoryFavoriteListing(Request $request, $id)
    {
        $favoriteslist = Favorite::where('UserId', $id)->where('Status', 0)
            ->with('propertyinfo.city.state')
            ->with('propertyinfo.propertyspecial')
            ->with('propertyinfo.propertyfloorplandetails')
            ->get();
        if ($request->ajax()) {
            return DataTables::of($favoriteslist)
                ->addColumn('propertyName', function ($row) {
                    return $row->propertyinfo->PropertyName ?? 'N/A';
                })
                ->addColumn('city', function ($row) {
                    return $row->propertyinfo->city->CityName ?? 'N/A';
                })
                ->addColumn('state', function ($row) {
                    return $row->propertyinfo->city->state->StateName ?? 'N/A';
                })
                ->addColumn('price', function ($row) {
                    return "$" . $row->propertyinfo->propertyfloorplandetails->Price ?? 'N/A';
                })
                ->addColumn('special', function ($row) {
                    return $row->propertyinfo->propertyspecial->special ?? 'N/A';
                })
                ->addColumn('addedDate', function ($row) {
                    return $row->formatted_added_on ?? 'N/A';
                })

                ->addColumn('notes', function ($row) {
                    $notes = '<div class="demo-btn-list d-flex" style="gap:5px;">
                <a type="#" class="action-btn action-btn-delete m-1" "data-bs-toggle="tooltip" title="Delete"> <i class="fa fa-plus"></i></a>
                <a type="#" class="action-btn action-btn-delete m-1" "data-bs-toggle="tooltip" title="Delete"> <i class="fa fa-eye"></i></a>
            </div>';
                    return $notes;
                })
                ->rawColumns(['propertyName', 'city', 'state', 'addedDate', 'special', 'notes'])
                ->make(true);
        } else {
            return view('admin.renter.renter_list');
        }
    }

    public function showAll(Request $request)
    {
        $users         = $this->renterInfoRepository->getRenterInfo();
        $collectedData = new RenterInfoCollection($users);
        $renterDetails = $collectedData->toArray(request());

        if ($request->ajax()) {
            return DataTables::of($renterDetails)
                ->addColumn('firstname', function ($row) {
                    return $row['firstname'];
                })
                ->addColumn('lastname', function ($row) {
                    return $row['lastname'];
                })
                ->addColumn('emovedate', function ($row) {
                    return $row['emovedate'];
                })
                ->addColumn('lmovedate', function ($row) {
                    return $row['lmovedate'];
                })
                ->addColumn('probability', function ($row) {
                    return $row['probability'];
                })
                ->addColumn('view', function ($row) {
                    return $row['view'];
                })
                ->addColumn('edit', function ($row) {
                    return $row['edit'];
                })
                ->addColumn('delete', function ($row) {
                    return $row['delete'];
                })
                ->addColumn('remainderdate', function ($row) {
                    return $row['remainderdate'];
                })
                ->addColumn('status', function ($row) {
                    return $row['status'];
                })
                ->addColumn('admin', function ($row) {
                    return $row['admin'];
                })
                ->rawColumns(['firstname', 'lastname', 'emovedate', 'lmovedate', 'probability', 'view', 'edit', 'delete', 'status', 'remainderdate', 'admin'])
                ->make(true);
        } else {
        }
        return view('admin.showAll');
    }

    public function callHistory(Request $request)
    {
        try {
            $clickToCallHistoryTotalWithoutLimit = Call::with(['property', 'caller'])
                ->select('calls.*')
                ->addSelect([
                    'Property' => PropertyInfo::select('PropertyName')
                        ->whereColumn('PropertyInfo.Id', 'calls.property_id')
                        ->limit(1),
                    'Fullname' => Login::select('UserName')
                        ->whereColumn('Login.Id', 'calls.caller_id')
                        ->limit(1),
                    'usertype' => Login::select('user_type')
                        ->whereColumn('Login.Id', 'calls.caller_id')
                        ->limit(1),
                ])
                ->get();

            if ($request->ajax()) {
                return DataTables::of($clickToCallHistoryTotalWithoutLimit)
                    ->addColumn('selectall', function ($row) {
                        return '<div class="d-flex" style="gap:30px;">
                                <input type="checkbox" id="select_' . $row->id . '" name="select" value="' . $row->id . '">
                            </div>';
                    })
                    ->addColumn('propertyname', function ($row) {
                        return $row->Property ?? 'N/A';
                    })
                    ->addColumn('caller', function ($row) {
                        return $row->Fullname ?? 'N/A';
                    })
                    ->addColumn('datetime', function ($row) {
                        return $row->DateCreated ? $row->DateCreated->format('Y-m-d H:i:s') : 'N/A';
                    })
                    ->addColumn('recording', function ($row) {
                        return $row->RecordingUrl ? '<a href="' . $row->RecordingUrl . '" target="_blank">Listen</a>' : 'N/A';
                    })
                    ->addColumn('callduration', function ($row) {
                        return $row->Duration ?? 'N/A';
                    })
                    ->addColumn('status', function ($row) {
                        return '<div class="d-flex" style="gap:20px;">
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-call" data-id="' . $row->id . '">Delete</a>
                            </div>';
                    })
                    ->addColumn('actions', function ($row) {
                        return '<div class="d-flex" style="gap:20px;">
                                <a href="' . route('admin.call.view', $row->id) . '" class="btn btn-primary btn-sm">View</a>
                                <a href="' . route('admin.call.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>
                            </div>';
                    })
                    ->rawColumns(['selectall', 'propertyname', 'caller', 'datetime', 'recording', 'callduration', 'status', 'actions'])
                    ->make(true);
            } else {
                return view('admin.client.callHistory');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error in callHistory method: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'Database error. Please try again later.'], 500);
            }
            return redirect()->back()->withErrors('Database error. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('General error in callHistory method: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
            }
            return redirect()->back()->withErrors('Something went wrong. Please try again later.');
        }
    }

    public function renterReports()
    {
        return view('admin.client.renterReport');
    }

    public function listingFavorite(Request $request)
    {
        return view('admin.client.listingFavorite');
    }

    public function listingFavoriteReports(Request $request)
    {
        return view('admin.client.listingFavoriteReport');
    }

    public function notifyHistory(Request $request)
    {
        try {
            $notifyhistory = NotifyDetail::with('renterinfo')
                ->with('propertyinfo.login')
                ->orderBy('send_time', 'desc')
                ->get();

            if ($request->ajax()) {
                return DataTables::of($notifyhistory)->addIndexColumn()
                    ->addColumn('selectall', function ($row) {
                        $checkbox = '<input type="checkbox">';
                        return $checkbox;
                    })
                    ->addColumn('propertyname', function ($row) {
                        return $row->propertyinfo ? '<a href="#">' . e($row->propertyinfo->PropertyName) . '</a>' : '';
                    })
                    ->addColumn('owner', function ($row) {
                        return $row->propertyinfo ? '<a href="#">' . e($row->propertyinfo->login->UserName) . '</a>' : '';
                    })
                    ->addColumn('rentername', function ($row) {
                        return @$row->renterinfo->Firstname . '' . @$row->renterinfo->Lastname ?? '';
                    })
                    ->addColumn('sendtime', function ($row) {
                        return $row->send_time ? $row->send_time->format('Y-m-d H:i:s') : '';
                    })
                    ->addColumn('responsetime', function ($row) {
                        return @$row->respond_time ? $row->respond_time->format('Y-m-d H:i:s') : '';
                    })
                    ->addColumn('action', function ($row) {
                        $viewUrl = route('admin-view-notify-history', ['id' => $row->notification_id]);
                        $editUrl = route('admin-edit-notify-history', ['id' => $row->notification_id]);
                        // $deleteUrl = route('admin-delete-notify-history');
                        $action = ' <div class="table-actions-icons table-actions-icons float-left">
                                        <a href="' . $viewUrl . '">
                                            <i class="fa-solid fa-eye px-2 py-2 border px-2 py-2 view-icon"></i>
                                        </a>
                                        <a href="' . $editUrl . '" class="edit-btn">
                                            <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="">
                                            <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                        </a>
                                    </div>';
                        return $action;
                    })
                    ->rawColumns(['selectall', 'propertyname', 'owner', 'rentername', 'sendtime', 'responsetime', 'action'])
                    ->make(true);
            } else {
                return view('admin.client.notifyHistory');
            }
        } catch (\Exception $e) {
            \Log::error('Error in leasedRenter method: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
            }
            return redirect()->back()->withErrors('Something went wrong. Please try again later.');
        }
    }

    public function viewNotifyHistory($id)
    {
        $viewnotifyhistory = NotifyDetail::where('notification_id', $id)
            ->with('renterinfo')
            ->with('propertyinfo.login')
            ->orderBy('send_time', 'desc')
            ->first();
        return view('admin.client.viewNotifyHistory', ['rec' => $viewnotifyhistory]);
    }

    public function editNotifyHistory($id)
    {
        return view('admin.client.editNotifyHistory');
    }

    public function deleteNotifyHistory($id)
    {
        return view('admin.client.viewNotifyHistory');
    }
}

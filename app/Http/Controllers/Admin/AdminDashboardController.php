<?php
namespace App\Http\Controllers\Admin;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteCollection;
use App\Models\AdminAccess;
use App\Models\AdminDetail;
use App\Models\City;
use App\Models\ContactUsHanlding;
use App\Models\Login;
use App\Models\Message;
use App\Models\Notification;
use App\Models\PropertyInfo;
use App\Models\PropertyInquiry;
use App\Models\PropertySpecial;
use App\Models\RenterInfo;
use App\Models\Special;
use App\Models\UserProperty;
use App\Repositories\FavoriteRepository;
use App\Repositories\RenterInfoRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboardController extends Controller
{
    protected $renterInfoRepository;
    protected $favoriteRepository;

    public function __construct(RenterInfoRepository $renterInfoRepository, FavoriteRepository $favoriteRepository)
    {
        $this->renterInfoRepository = $renterInfoRepository;
        $this->favoriteRepository   = $favoriteRepository;
    }

    public function index()
    {
        $totalproperty    = PropertyInfo::count();
        $last7days        = PropertyInfo::where('CreatedOn', '>=', Carbon::now()->subDays(7))->count();
        $activeProperty   = PropertyInfo::where('Status', 1)->count();
        $inactiveProperty = PropertyInfo::where('Status', '!=', 1)->count();
        $totalUser        = Login::count();

        $totalRenters    = Login::where('user_type', 'C')->count();
        $activeRenters   = Login::where('user_type', 'C')->where('Status', '1')->count();
        $InactiveRenters = Login::where('user_type', 'C')->where('Status', '0')->count();
        $leasedRenters   = Login::where('user_type', 'C')->where('Status', '2')->count();

        $listUnassignedRenter = Login::where('user_type', 'C')
            ->whereHas('renterinfo', function ($query) {
                $query->whereNull('added_by');
            })
            ->with(['renterinfo:id,Login_ID,Firstname,Lastname,probability'])
            ->take(5)
            ->orderBy('Id', 'desc')
            ->get()
            ->map(function ($login) {
                return [
                    'id'          => $login->renterinfo->Login_ID,
                    'Firstname'   => $login->renterinfo->Firstname ?? null,
                    'Lastname'    => $login->renterinfo->Lastname ?? null,
                    'Probability' => $login->renterinfo->probability ?? null,
                ];
            });

        $authid             = Auth::guard('admin')->user()->id;
        $listassignedRenter = Login::where('user_type', 'C')
            ->whereHas('renterinfo', function ($query) use ($authid) {
                $query->where('added_by', $authid);
            })
            ->with('renterinfo')
            ->take(5)
            ->orderBy('Id', 'desc')
            ->get();

        $pendingProperties = PropertyInfo::where('Status', '0')
            ->with('city.state')
            ->orderBy('Id', 'desc')
            ->take(5)
            ->get();


        $activeProperties = PropertyInfo::where('Status', '1')
            ->with('city.state')
            ->orderBy('Id', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalproperty'        => $totalproperty,
            'last7days'            => $last7days,
            'activeProperty'       => $activeProperty,
            'inactiveProperty'     => $inactiveProperty,
            'totalUser'            => $totalUser,
            'pendingProperties'    => $pendingProperties,
            'activeProperties'     => $activeProperties,
            'totalRenters'         => $totalRenters,
            'activeRenters'        => $activeRenters,
            'InactiveRenters'      => $InactiveRenters,
            'leasedRenters'        => $leasedRenters,
            'listunassignedRenter' => $listUnassignedRenter,
            'listassignedRenter'   => $listassignedRenter,
        ]);
    }


    public function changePropertyStatus(Request $request)
    {
        $propertyid      = $request->id;
        $propertydetails = PropertyInfo::where('Id', $propertyid)->first();
        $propertyname    = $propertydetails->PropertyName;
        $propertystatus  = $request->statusid;

        $sender        = Auth::guard('admin')->user();
        $senderProfile = $sender->admin_headshot;
        $senderId      = $sender->id;
        $senderName    = $sender->admin_name;

        $managerId = $propertydetails->UserId;

        if ($propertystatus == 1) {
            PropertyInfo::where('Id', $propertyid)->update([
                'Status' => '0',
            ]);
            $message               = '<strong>' . $senderName . '</strong> has Changed Your Property to Inactive ';
            $notificationToManager = [
                'title'   => 'Referred Renter',
                'image'   => $senderProfile,
                'message' => $message,
            ];
            $notification = Notification::create([
                'from_id'        => $senderId,
                'form_user_type' => $sender->admin_type,
                'to_id'          => $managerId,
                'to_user_type'   => 'M',
                'property_id'    => $propertyid,
                'message'        => $message,
            ]);
            if ($notification) {
                event(new NotificationEvent($notificationToManager, $managerId));
            }
            return response()->json(['message' => "Status Changed To Active "]);
        } else {
            PropertyInfo::where('Id', $propertyid)->update([
                'Status' => '1',
            ]);
            $message               = '<strong>' . $senderName . '</strong> has Changed Your Property to Active ';
            $notificationToManager = [
                'title'   => 'Referred Renter',
                'image'   => $senderProfile,
                'message' => $message,
            ];
            $notification = Notification::create([
                'from_id'        => $senderId,
                'form_user_type' => $sender->admin_type,
                'to_id'          => $managerId,
                'to_user_type'   => 'M',
                'property_id'    => $propertyid,
                'message'        => $message,

            ]);
            if ($notification) {
                event(new NotificationEvent($notificationToManager, $managerId));
            }
            return response()->json(['message' => "Status Changed to InActive "]);
        }
    }
 

    public function agentRemainder(Request $request)
    {
        $pageTitle = "Agent Remainder";
        $loginUser = Auth::guard('admin')->user();
        $loginId   = $loginUser->id;
        $admintype = $loginUser->admin_type;

        $adminDetail = AdminDetail::find($loginId);
        $canEdit     = $adminDetail->adminuser_addedit ?? null;

        $adminCities = AdminAccess::where('admin_detail_id', $loginId)->pluck('admin_city_id')->toArray();

        $properties = PropertySpecial::with('propertyInfo')
            ->where('status', 1)
            ->whereNotNull('special')
            ->where('special', '!=', '')
            ->whereHas('propertyInfo', function ($query) use ($adminCities) {
                $query->whereIn('CityId', $adminCities);
            })
            ->orderByDesc('addeddate')
            ->get();

        if ($admintype == "S") {
            $renterQuery = RenterInfo::query();
        } else {
            $renterQuery = RenterInfo::where('added_by', $loginUser->id);
        }

        if ($request->filled('reminderfrom') && $request->filled('reminderto')) {
            $renterQuery->whereBetween('Reminder_date', [$request->reminderfrom, $request->reminderto]);
        } else {
            $renterQuery->whereBetween('Reminder_date', [
                now()->startOfYear()->toDateString(),
                now()->endOfYear()->toDateString(),
            ]);
        }

        if (! empty($adminCities)) {
            $renterQuery->whereIn('CityId', $adminCities);
        }

        if ($request->ajax()) {
            return DataTables::eloquent($renterQuery)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->Firstname . ' ' . $row->Lastname;
                })
                ->addColumn('bedroom', fn($row) => $row->bedroom ?? '')
                ->addColumn('Reminder_date', fn($row) => $row->Reminder_date ? \Carbon\Carbon::parse($row->Reminder_date)->format('d M Y, h:i A') : '')
                ->addColumn('reminder_note', fn($row) => $row->reminder_note ?? '')
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin-edit-renter', ['id' => $row->Id]);
                    $actionButtons = '<div class="table-actionss-icon table-actions-icons float-none">';
                    $actionButtons .= '<a href="' . $editUrl . '" class="edit-btn">
                                        <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i>
                                    </a>';
                   
                    $actionButtons .= '</div>';
                    return $actionButtons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.agentRemainder', [
            'properties' => $properties,
            'canEdit'    => $canEdit,
            'pageTitle' => $pageTitle
        ]);
    }


    public function viewProfile($id)
    {
        $authID     = Auth::guard('admin')->user()->id;
        $renterInfo = Login::where('Id', $id)->with('renterinfo.city.state')->with('renterinfo.admindetails')->first();

        $recentproperties = UserProperty::where('userId', $id)
            ->whereRaw('DATEDIFF(now(), lastviewed) <= 110')
            ->orderBy('lastviewed', 'desc')->limit(10)
            ->with('propertyinfo.gallerytype.gallerydetail')
            ->get();

        return view('admin.viewProfile', [
            'data'         => $renterInfo,
            'recentviewed' => $recentproperties,
        ]);
    }


    public function changeStatus(Request $request, $id)
    {
        $loginStatus = Login::find($id);
        $status      = $request->input('status');
        $update      = Login::where('Id', $id)->update([
            'status' => $status,
        ]);
        if ($update) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => false], 404);
        }
    }


    public function addLease()
    {
        return view('admin.addLease');
    }


    public function specials(Request $request)
    {
        $authID      = Auth::guard('admin')->user()->id;
        $citiesArray = AdminAccess::where('admin_detail_id', $authID)->get('admin_city_id');
        $results     = Special::where('status', '1')
            ->where('special', '!=', '')
            ->whereHas('propertyInfo', function ($query) use ($citiesArray) {
                $query->whereIn('CityId', $citiesArray);
            })
            ->with('propertyInfo')
            ->orderBy('addeddate', 'desc')
            ->get();
        if ($request->ajax()) {
            return DataTables::of($results)->addIndexColumn()
                ->addColumn('propertyname', function ($row) {
                    return $row->propertyinfo->PropertyName;
                })
                ->addColumn('special', function ($row) {
                    return $row->special;
                })
                ->addColumn('date', function ($row) {
                    return $row->addeddate;
                })
                ->rawColumns(['propertyname', 'special', 'date'])
                ->make(true);
        } else {
            return view('admin.specials');
        }

        return view('admin.specials');
    }


    public function getRemainders(Request $request)
    {
        $loginUserId = Auth::guard('admin')->user()->id;
        $cityids     = AdminAccess::where('admin_detail_id', $loginUserId)->pluck('admin_city_id')->toArray();

        $renterinfo = RenterInfo::where('added_by', $loginUserId)
            ->where('Reminder_date', '!=', '')
            ->orderBy('Reminder_date')
            ->get();

        return response([
            'data' => $renterinfo,
        ]);
    }


    public function getCities($state_id)
    {
        $cities = City::where('StateId', $state_id)->get();
        return response()->json($cities);
    }


    public function adminMessages()
    {
        return view('admin.adminMessages');
    }


    public function AdministrationCities(Request $request)
    {
        $stateIds = $request->stateIds;
        $cities   = City::whereIn('StateId', $stateIds)->get();
        return response()->json([
            'cities' => $cities,
        ]);
    }


    public function mapView($id)
    {
        $properties = PropertyInfo::where('ActiveOnSearch', 1)->where('Status', 1)
            ->whereHas('favorites', function ($query) use ($id) {
                $query->where('UserId', $id)->where('Status', 1);
            })
            ->with([
                'favorites' => function ($query) use ($id) {
                    $query->where('UserId', $id)->where('Status', 1);
                }
            ])
            ->with(['gallerytype.gallerydetail', 'city.state'])
            ->get();
        return view('admin.mapView', ['mapdata' => $properties]);
    }


    public function markAllAsRead()
    {
        $userId = auth()->guard('renter')->user()->Id;
        Notification::where('to_id', $userId)->where('seen', 0)->update(['seen' => 1]);

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    public function claimRenter(Request $request)
    {
        $authuser = Auth::guard('admin')->user();
        $renterId = $request->renterId;
        $adminName = $authuser->admin_name;

        $update = RenterInfo::where('Login_ID', $renterId)->update([
            'added_by' => $authuser->id,
        ]);

        $notificationStatus = true;

        try {
            $notificationToRenter = [
                'title' => 'Claim Profile',
                'image' => $adminName,
                'message' => '<strong>' . $adminName . '</strong> has Claimed Your Profile',
            ];
            event(new NotificationEvent($notificationToRenter, $renterId));
        } catch (\Exception $e) {
            $notificationStatus = false;
            \Log::error('Notification failed: ' . $e->getMessage());
        }

        if ($update) {
            return response()->json([
                'status' => 'success',
                'message' => $notificationStatus
                ? 'Renter claimed successfully and notified!'
                : 'Renter claimed successfully but notification failed.',
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to claim the renter.',
            ], 500);
        }
    }

    public function ManageProfile()
    {
        $user  = Auth::guard('admin')->user()->id;
        $admin = AdminDetail::where('id', $user)->first();
        return view('admin.manageProfile', ['admin' => $admin]);
    }


    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $uploadPath = public_path('/uploads/profile_pics');
        $imageName  = $admin->admin_headshot;

        if ($request->hasFile('admin_headshot')) {
            $image     = $request->file('admin_headshot');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            if (! $image->move($uploadPath, $imageName)) {
                return response()->json(['error' => true, 'message' => 'Failed to upload image.'], 500);
            }
        }
        $updateData = [
            'admin_name'     => $request->admin_name,
            'admin_login_id' => $request->admin_login_id,
            'admin_email'    => $request->email,
            'admin_headshot' => $imageName,
        ];

        $update = AdminDetail::where('id', $admin->id)->update($updateData);

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
        } else {
            return response()->json(['error' => true, 'message' => 'Failed to update profile.'], 500);
        }
    }

    public function changePassword()
    {
        return view('admin.changePassword');
    }

    public function revertContactUs(Request $request)
    {
        $listofcontactus = ContactUsHanlding::all();
        if (request()->ajax()) {
            return Datatables::of($listofcontactus)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return @$row->name ?? '';
                })
                ->addColumn('email', function ($row) {
                    return @$row->email ?? '';
                })
                ->addColumn('message', function ($row) {
                    return @$row->message ?? '';
                })
                ->addColumn('message', function ($row) {
                    return @$row->subject ?? '';
                })
                ->addColumn('revert', function ($row) {
                    if ($row->reverted == 'yes') {
                        return '<span class="badge badge-success">Reverted</span>';
                    } else {
                        return '
                            <button class="btn btn-warning btn-sm btn-pending" data-id="' . $row->id . '">Pending</button>
                            <div class="message-box mt-2" id="message-box-' . $row->id . '" style="display:none;">
                                <textarea class="form-control message-input" id="message-input-' . $row->id . '" placeholder="Type your message..."></textarea>
                                <button class="btn btn-primary btn-sm mt-2 btn-send-message" data-id="' . $row->id . '">Submit</button>
                            </div>
                        ';
                    }
                })
                ->rawColumns(['name', 'email', 'subject', 'message', 'revert'])
                ->make(true);
        }
        return view('contact_us');
    }

    public function revertContactUsUpdate(Request $request)
    {
        $request->validate([
            'id'      => 'required|integer',
            'message' => 'required|string|max:255',
        ]);
        $userinfo = ContactUsHanlding::where('id', $request->id)->first();
        $update   = ContactUsHanlding::where('id', $request->id)->update([
            'reverted' => 'yes',
        ]);
        $details = [
            'name'    => $userinfo->name,
            'email'   => $userinfo->email,
            'message' => $request->message,
        ];
        Mail::to('admin@yourdomain.com')->send(new ContactUsMail($details));
        return response()->json(['success' => true, 'message' => 'Reverted successfully.']);
    }


    public function revertPropertyInquiry(Request $request)
    {
        try {
            $listofpropertyinquiry = PropertyInquiry::with('propertyinfo', 'login')
                ->orderBy('Id', 'desc')
                ->take(200)
                ->get();

            if ($request->ajax()) {
                return Datatables::of($listofpropertyinquiry)
                    ->addIndexColumn()
                    ->addColumn('propertyname', function ($row) {
                        return htmlspecialchars(@$row->propertyinfo->PropertyName ?? '');
                    })
                    ->addColumn('username', function ($row) {
                        return htmlspecialchars(@$row->login->UserName ?? '');
                    })
                    ->addColumn('subject', function ($row) {
                        return htmlspecialchars(@$row->Subject ?? '');
                    })
                    ->addColumn('message', function ($row) {
                        return htmlspecialchars(@$row->Message ?? '');
                    })
                    ->addColumn('revert', function ($row) {
                        if ($row->reverted === 'yes') {
                            return '<span class="badge badge-success">Reverted</span>';
                        } else {
                            $rowId = htmlspecialchars($row->Id);
                            return '
                            <button class="btn btn-warning btn-sm btn-pending" data-id="' . $rowId . '">Pending</button>
                            <div class="message-box mt-2" id="message-box-' . $rowId . '" style="display:none;">
                                <textarea class="form-control message-input" id="message-input-' . $rowId . '" placeholder="Type your message..."></textarea>
                                <button class="btn btn-primary btn-sm mt-2 btn-send-message" data-id="' . $rowId . '">Submit</button>
                            </div>
                        ';
                        }
                    })
                    ->rawColumns(['revert'])
                    ->make(true);
            }

            return view('propertyInquiry');
        } catch (\Exception $e) {
            \Log::error('Error in revertPropertyInquiry: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'An error occurred while loading property inquiries. Please try again later.',
                ], 500);
            }

            return view('errors.general', ['message' => 'An error occurred while loading property inquiries.']);
        }
    }

    public function revertPropertyInquiryUpdate(Request $request)
    {
        $request->validate([
            'id'      => 'required|integer',
            'message' => 'required|string|max:255',
        ]);
        $userinfo = PropertyInquiry::where('Id', $request->id)->first();
        $update   = PropertyInquiry::where('Id', $request->id)->update([
            'reverted' => 'yes',
        ]);
        $details = [
            'name'    => $userinfo->name,
            'email'   => $userinfo->email,
            'message' => $request->message,
        ];
        Mail::to('admin@yourdomain.com')->send(new ContactUsMail($details));
        return response()->json(['success' => true, 'message' => 'Reverted successfully.']);
    }

    public function storeAgents(Request $request)
    {
        try {
            $admindetail = AdminDetail::create([
                'admin_name'                   => $request->fullname,
                'admin_email'                  => $request->email,
                'admin_login_id'               => $request->login_id,
                'password'                     => bcrypt($request->password),
                'admin_type'                   => 'N',
                'property_addedit'             => $request->property_addedit,
                'property_delete'              => $request->property_delete,
                'property_active'              => $request->property_active,
                'user_addedit'                 => $request->user_addedit,
                'user_delete'                  => $request->user_delete,
                'user_active'                  => $request->user_active,
                'company_addedit'              => $request->company_addedit,
                'company_delete'               => $request->company_delete,
                'company_active'               => $request->company_active,
                'call_history_delete'          => $request->call_history_delete,
                'adminuser_addedit'            => $request->adminuser_addedit,
                'adminuser_delete'             => $request->adminuser_delete,
                'fees_addedit'                 => $request->fees_addedit,
                'phone'                        => $request->phone,
                'cell'                         => $request->cell_number,
                'fax'                          => $request->phone,
                'renter_claim'                 => $request->renter_claim,
                'notify_delete'                => $request->notify_delete,
                'notify_addedit'               => $request->notify_addedit,
                'content_delete'               => $request->content_delete,
                'content_addedit'              => $request->content_addedit,
                'renter_update_history_delete' => $request->renter_update_history_delete,
                'access_school_management'     => $request->access_school_management,
                'access_delete_message'        => $request->access_delete_message,
                'access_csv_export'            => $request->access_csv_export,
                'title'                        => $request->title,
                'company'                      => $request->company,
            ]);

            foreach ($request->admincity as $city) {
                AdminAccess::create([
                    'admin_detail_id' => $admindetail->id,
                    'admin_state_id'  => $request->adminstate[0],
                    'admin_city_id'   => $city,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Administrator added Successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the administrator.',
            ], 500);
        }
    }

    public function editAgents(Request $request, $id)
    {
        try {
            $admindetail = AdminDetail::findOrFail($id);
            $admindetail->update([
                'admin_name'                   => $request->fullname,
                'admin_email'                  => $request->email,
                'admin_login_id'               => $request->login_id,
                'password'                     => $request->password ? bcrypt($request->password) : $admindetail->password,
                'admin_type'                   => 'N',
                'property_addedit'             => $request->property_addedit,
                'property_delete'              => $request->property_delete,
                'property_active'              => $request->property_active,
                'user_addedit'                 => $request->user_addedit,
                'user_delete'                  => $request->user_delete,
                'user_active'                  => $request->user_active,
                'company_addedit'              => $request->company_addedit,
                'company_delete'               => $request->company_delete,
                'company_active'               => $request->company_active,
                'call_history_delete'          => $request->call_history_delete,
                'adminuser_addedit'            => $request->adminuser_addedit,
                'adminuser_delete'             => $request->adminuser_delete,
                'fees_addedit'                 => $request->fees_addedit,
                'phone'                        => $request->phone,
                'cell'                         => $request->cell_number,
                'fax'                          => $request->phone,
                'renter_claim'                 => $request->renter_claim,
                'notify_delete'                => $request->notify_delete,
                'notify_addedit'               => $request->notify_addedit,
                'content_delete'               => $request->content_delete,
                'content_addedit'              => $request->content_addedit,
                'renter_update_history_delete' => $request->renter_update_history_delete,
                'access_school_management'     => $request->access_school_management,
                'access_delete_message'        => $request->access_delete_message,
                'access_csv_export'            => $request->access_csv_export,
                'title'                        => $request->title,
                'company'                      => $request->company,
            ]);

            if (is_array($request->admincity)) {
                foreach ($request->admincity as $city) {
                    AdminAccess::updateOrCreate(
                        [
                            'admin_detail_id' => $admindetail->id,
                            'admin_city_id'   => $city,
                        ],
                        [
                            'admin_state_id' => $request->adminstate[0],
                        ]
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Administrator user updated successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the administrator.',
            ], 500);
        }
    }

    public function revertContactUsForm(Request $request)
    {
        $listofcontactus = ContactUsHanlding::all();
        if (request()->ajax()) {
            return Datatables::of($listofcontactus)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return @$row->name ?? '';
                })
                ->addColumn('email', function ($row) {
                    return @$row->email ?? '';
                })
                ->addColumn('message', function ($row) {
                    return @$row->message ?? '';
                })
                ->addColumn('message', function ($row) {
                    return @$row->subject ?? '';
                })
                ->addColumn('revert', function ($row) {
                    if ($row->reverted == 'yes') {
                        return '<span class="badge badge-success">Reverted</span>';
                    } else {
                        return '
                            <button class="btn btn-warning btn-sm btn-pending" data-id="' . $row->id . '">Pending</button>
                            <div class="message-box mt-2" id="message-box-' . $row->id . '" style="display:none;">
                                <textarea class="form-control message-input" id="message-input-' . $row->id . '" placeholder="Type your message..."></textarea>
                                <button class="btn btn-primary btn-sm mt-2 btn-send-message" data-id="' . $row->id . '">Submit</button>
                            </div>
                        ';
                    }
                })
                ->rawColumns(['name', 'email', 'subject', 'message', 'revert'])
                ->make(true);
        }
        return view('admin.contactUsRevert');
    }

    public function setRemainder(Request $request)
    {

        $validated = $request->validate([
            'userid'           => 'required',
            'setremainderdate' => 'required',
            'setremaindertime' => 'required',
        ]);

        try {
            $remainderdatetime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $request->setremainderdate . ' ' . $request->setremaindertime
            )->format('Y-m-d H:i:s');

            $update = RenterInfo::where('Login_ID', $request->userid)->update([
                'Reminder_date' => $remainderdatetime,
                'reminder_note' => $request->remaindernote,
            ]);

            if ($update) {
                return response()->json([
                    'success' => true,
                    'message' => "Remainder set successfully.",
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Remainder could not be set. Please try again.",
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "An error occurred: " . $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccess;
use App\Models\AdminDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\RenterInfo;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Models\Source;

class AdministrationController extends Controller
{
    public function officeReport()
    {
        return view('admin.administration.officeReport');
    }

    public function manageMyAgents(Request $request)
    {
        $agents = AdminDetail::all();

        if ($request->ajax()) {
            return DataTables::of($agents)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    $adminamebtn = '<a href="javascript:void(0)" class="font-weight-bold">' . $row->admin_name . '</a>';
                    return $adminamebtn;
                })
                ->addColumn('userloginid', function ($row) {
                    return '<p class="font-weight-bold">' . $row->admin_login_id . '</p>';
                })
                ->addColumn('edit', function ($row) {
                    $editurl = route('admin-edit-admin-users', ['id' => $row->id]);
                    return '<div class="table-actions-icons float-left">
                                <a href="' . $editurl . '" class="edit-btn">
                                    <i class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i>
                                </a>
                                <a href="javascript:void(0)" data-id="' . $row->id . '" onclick="deleteAgent(' . $row->id . ')">
                                    <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['username', 'userloginid', 'edit'])
                ->make(true);
        } else {
            return view('admin.administration.manageMyAgents');
        }
    }
    public function addAdminUsers()
    {
        return view('admin.administration.addAdminUsers');
    }

    public function editAdminUsers($id)
    {
        $editAdmin = AdminDetail::where('id', $id)->with('accesses.city.state')->first();
        return view('admin.administration.editAdminUsers', ['editAdmin' => $editAdmin]);
    }

    public function adminDeleteAgent($id)
    {
        dd($id);
    }

    public function myOfficeReport(Request $request)
    {

        try {
            $data = Login::where('user_type', 'C')
                ->orderBy('Id', 'ASC')
                ->whereHas('renterinfo', function ($query) {
                    $query->where(function ($subQuery) {
                        $newloginid = Auth::guard('admin')->user()->id ?? null;
                        $subQuery->where('added_by', $newloginid)->orderBy('Id', 'ASC');
                    });
                })
                ->with('renterinfo')
                ->get();

            if ($request->ajax()) {
                return DataTables::of($data)->addIndexColumn()
                    ->addColumn('firstname', function ($row) {
                        return optional($row->renterinfo)->Firstname ?? '-';
                    })
                    ->addColumn('lastname', function ($row) {
                        return optional($row->renterinfo)->Lastname ?? '-';
                    })
                    ->addColumn('probability', function ($row) {
                        return !empty(optional($row->renterinfo)->probability) ? optional($row->renterinfo)->probability . "%" : '-';
                    })
                    ->addColumn('status', function ($row) {
                        $status = '';
                        switch ($row->Status) {
                            case "1":
                                $status = '<a href="javascript:void(0)" class="c-pill c-pill--success">Active</a>';
                                break;
                            case "0":
                                $status = '<a href="javascript:void(0)" class="c-pill c-pill--warning">Inactive</a>';
                                break;
                            case "2":
                                $status = '<a href="javascript:void(0)" class="c-pill c-pill--danger">Leased</a>';
                                break;
                            default:
                                $status = 'Unknown';
                        }
                        $statusText = $row->Status == 2 ? "Leased" : "Unknown";
                        return $status;
                    })
                    ->addColumn('adminname', function ($row) {
                        $adminId = optional($row->renterinfo)->added_by;
                        return $adminId ? AdminDetail::getAdminNameById($adminId) : '-';
                    })
                    ->addColumn('actions', function ($row) {
                        $user = Auth::guard('admin')->user();
                        $editUrl = route('admin-edit-renter', ['id' => $row->Id]);
                        $viewUrl = route('admin-view-profile', ['id' => $row->Id]);
                        $deleteUrl = route('admin-deleteRenter', ['id' => $row->Id]);
                        $actionButtons = '<div class="table-actionss-icon table-actions-icons float-none">';

                        if ($user && $user->hasPermission('property_addedit')) {
                            $actionButtons .= '<a href="' . $editUrl . '" class="edit-btn">
                                                <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i>
                                            </a>';
                        }
                        $actionButtons .= '<a href="' . $viewUrl . '" class=""><i class="fa-regular fa-eye border px-2 py-2 view-icon"></i></a> ';
                        if ($user && $user->hasPermission('user_delete')) {
                            $actionButtons .= '<a href="javascript:void(0)" class="deleteRenter" data-id="' . $row->Id . '" data-url="' . $deleteUrl . '">
                                                <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                            </a>';
                        }
                        $actionButtons .= '</div>';
                        return $actionButtons;
                    })
                    ->rawColumns(['firstname', 'lastname', 'probability', 'status', 'adminname', 'actions'])
                    ->make(true);
            } else {
                return view('admin.administration.myOfficeReport');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error in activeRenter method: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'Database error. Please try again later.'], 500);
            }
            return redirect()->back()->withErrors('Database error. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('General error in activeRenter method: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
            }
            return redirect()->back()->withErrors('Something went wrong. Please try again later.');
        }
    }

    public function storeAgents(Request $request)
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:admins,email',
            'title' => 'required',
            'company' => 'required',
            'login_id' => 'required',
            'phone' => 'required',
            'adminstate' => 'required|integer|exists:states,id',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'integer|exists:permissions,id',
            'admincity' => 'required|array|min:1',
            'admincity.*' => 'integer|exists:cities,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $fullname = $request->firstname . ' ' . $request->lastname;

        try {
            $admindetail = AdminDetail::create([
                'admin_name' => $fullname,
                'admin_email' => $request->email,
                'admin_login_id' => $request->login_id,
                'password' => bcrypt($request->password),
                'admin_type' => 'N',
                'property_addedit' => $request->property_addedit,
                'property_delete' => $request->property_delete,
                'property_active' => $request->property_active,
                'user_addedit' => $request->user_addedit,
                'user_delete' => $request->user_delete,
                'user_active' => $request->user_active,
                'company_addedit' => $request->company_addedit,
                'company_delete' => $request->company_delete,
                'company_active' => $request->company_active,
                'call_history_delete' => $request->call_history_delete,
                'adminuser_addedit' => $request->adminuser_addedit,
                'adminuser_delete' => $request->adminuser_delete,
                'fees_addedit' => $request->fees_addedit,
                'phone' => $request->phone,
                'cell' => $request->cell_number,
                'fax' => $request->phone,
                'renter_claim' => $request->renter_claim,
                'notify_delete' => $request->notify_delete,
                'notify_addedit' => $request->notify_addedit,
                'content_delete' => $request->content_delete,
                'content_addedit' => $request->content_addedit,
                'renter_update_history_delete' => $request->renter_update_history_delete,
                'access_school_management' => $request->access_school_management,
                'access_delete_message' => $request->access_delete_message,
                'access_csv_export' => $request->access_csv_export,
                'title' => $request->title,
                'company' => $request->company,
            ]);

            foreach ($request->admincity as $city) {
                AdminAccess::create([
                    'admin_detail_id' => $admindetail->id,
                    'admin_state_id' => $request->adminstate,
                    'admin_city_id' => $city,
                ]);
            }

            $admindetail->states()->attach($request->adminstate);
            $admindetail->permissions()->sync($request->permissions);

            return response()->json([
                'success' => true,
                'message' => 'Administrator user added successfully.',
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the administrator.',
            ], 500);
        }
    }

    public function manageSource(Request $request)
    {
        try {
            $sources = Source::all();
            if ($request->ajax()) {
                return DataTables::of($sources)
                    ->addIndexColumn()
                    ->addColumn('sourcename', function ($row) {
                        $sourceName = $row->SourceName ?? 'N/A';
                        return '<a href="javascript:void(0)" class="font-weight-bold">' . e($sourceName) . '</a>';
                    })
                    ->addColumn('actions', function ($row) {
                        $editUrl = route('admin-edit-admin-users', ['id' => $row->Id]);
                        $deleteUrl = route('admin-delete-source', ['id' => $row->Id]);
                        return '<div class="table-actions-icons float-left">
                                <a href="' . e($editUrl) . '" class="edit-btn">
                                <i class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i>
                            </a>
                            <a href="javascript:void(0)" id="delete-source" class="" data-id="' . $row->Id . '" data-url="' . $deleteUrl . '">
                                    <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                            </a>
                            </div>';
                    })
                    ->rawColumns(['sourcename', 'actions'])
                    ->make(true);
            }
            return view('admin.administration.manageSource');
        } catch (\Exception $e) {

            \Log::error("Error in manageSource: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching sources. Please try again later.'
            ], 500);
        }
    }

    public function createSource()
    {
        return view('admin.administration.addSource');
    }

    public function deleteSource($id)
    {
        $source = Source::where('Id', $id)->first();
        if ($source) {
            Source::where('Id', $id)->delete();
            return response()->json(['message' => 'Source deleted successfully']);
        } else {
            return response()->json(['error' => 'Failed To Delete the Source Please Try Again !']);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccess;
use App\Models\AdminDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\RenterInfo;
use App\Services\DataTableService;
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
        if ($request->ajax()) {
            $query = AdminDetail::query();
            return DataTableService::of($query)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return '<a href="javascript:void(0)" class="font-weight-bold">' . e($row->admin_name) . '</a>';
                })
                ->addColumn('userloginid', function ($row) {
                    return '<p class="mb-0">' . e($row->admin_login_id) . '</p>';
                })
                ->addColumn('edit', DataTableService::actionColumn([
                    'edit' => [
                        'route' => fn($row) => route('admin-edit-admin-users', ['id' => $row->id]),
                        'icon' => 'fa-pen',
                        'class' => 'edit-btn'
                    ],
                    'delete' => [
                        'route' => fn($row) => route('admin-delete-agent', ['id' => $row->id]),
                        'icon' => 'fa-trash',
                        'class' => 'delete-btn'
                    ]
                ]))
                ->rawColumns(['username', 'userloginid', 'edit'])
                ->make(true);
        }
        return view('admin.administration.manageMyAgents');
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
            if ($request->ajax()) {
                $newloginid = Auth::guard('admin')->user()->id ?? null;
                $query = Login::where('user_type', 'C')
                    ->whereHas('renterinfo', function ($q) use ($newloginid) {
                        $q->where('added_by', $newloginid);
                    })
                    ->with('renterinfo');

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('firstname', DataTableService::safeColumn('renterinfo.Firstname'))
                    ->addColumn('lastname', DataTableService::safeColumn('renterinfo.Lastname'))
                    ->addColumn('probability', function ($row) {
                        $prob = optional($row->renterinfo)->probability;
                        return $prob ? $prob . "%" : '-';
                    })
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('adminname', DataTableService::adminColumn('renterinfo.added_by'))
                    ->addColumn('actions', DataTableService::actionColumn([
                        'view' => [
                            'route' => fn($row) => route('admin-view-profile', ['id' => $row->Id]),
                            'icon' => 'fa-eye',
                            'class' => 'view-btn'
                        ],
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-renter', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn',
                            'permission' => 'property_addedit'
                        ],
                        'delete' => [
                            'route' => fn($row) => route('admin-deleteRenter', ['id' => $row->Id]),
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn deleteRenter',
                            'permission' => 'user_delete'
                        ]
                    ]))
                    ->rawColumns(['status', 'actions'])
                    ->make(true);
            }
            return view('admin.administration.myOfficeReport');
        } catch (\Exception $e) {
            \Log::error('Error in myOfficeReport: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'An error occurred.'], 500)
                : redirect()->back()->withErrors('An error occurred.');
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
            if ($request->ajax()) {
                $query = Source::query();
                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('sourcename', function ($row) {
                        return '<a href="javascript:void(0)" class="font-weight-bold">' . e($row->SourceName ?? 'N/A') . '</a>';
                    })
                    ->addColumn('actions', DataTableService::actionColumn([
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-admin-users', ['id' => $row->Id]), // Check if this should be a different route
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn'
                        ],
                        'delete' => [
                            'route' => fn($row) => route('admin-delete-source', ['id' => $row->Id]),
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn'
                        ]
                    ]))
                    ->rawColumns(['sourcename', 'actions'])
                    ->make(true);
            }
            return view('admin.administration.manageSource');
        } catch (\Exception $e) {
            \Log::error("Error in manageSource: " . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'An error occurred.'], 500)
                : redirect()->back()->withErrors('An error occurred.');
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

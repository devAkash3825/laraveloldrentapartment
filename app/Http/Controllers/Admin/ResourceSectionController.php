<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PropertyInfo;
use App\Models\AdminDetail;
use Carbon\Carbon;
use App\Models\RenterInfo;
use App\Services\DataTableService;


class ResourceSectionController extends Controller
{
    public function listManager(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Login::where('user_type', 'M')
                    ->where('Status', 1)
                    ->with('propertyinfo');

                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('managername', function ($row) {
                        return '<a href="' . route('admin-view-profile', ['id' => $row->Id]) . '" class="font-weight-bold text-primary">' . e($row->UserName) . '</a>';
                    })
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('action', DataTableService::actionColumn([
                        'view' => [
                            'route' => fn($row) => route('admin-view-profile', ['id' => $row->Id]),
                            'icon' => 'fa-eye',
                            'class' => 'view-btn'
                        ],
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-manager', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn'
                        ],
                        'delete' => [
                            'route' => '#', // Define delete route if available
                            'icon' => 'fa-trash',
                            'class' => 'delete-btn',
                            'delete' => true
                        ]
                    ]))
                    ->rawColumns(['managername', 'status', 'action'])
                    ->make(true);
            }
            return view('admin.resources.listManager');
        } catch (\Exception $e) {
            \Log::error('Error in listManager: ' . $e->getMessage());
            return $request->ajax() 
                ? response()->json(['error' => 'An error occurred.'], 500)
                : redirect()->back()->withErrors('An error occurred.');
        }
    }
    public function editManager($id)
    {
        $manager = Login::where('Id', $id)->first();
        return view('admin.resources.editManager', ['manager' => $manager]);
    }
    public function addManager()
    {
        return view('admin.resources.addManager');
    }
    public function createManager(Request $request)
    {
        $validatedData = $request->validate([
            'userName' => 'required|string',
            'emailId' => 'required|email|max:255|unique:Login,Email',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required'
        ]);

        try {
            Login::create([
                'UserName' => $request->input('userName'),
                'Password' => $request->input('password'),
                'Email' => $validatedData['emailId'],
                'CreatedOn' => Carbon::now(),
                'ModifiedOn' => Carbon::now(),
                'Status' => '1',
                'UserIp' => $request->ip(),
                'user_type' => 'M',
                'acc_to_craiglist' => 'No'
            ]);

            return response()->json(['success' => 'Manager created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the manager', 'details' => $e->getMessage()], 500);
        }
    }
    public function searchManager()
    {
        return view('admin.resources.searchManager');
    }
    public function managerLoginLog()
    {
        return view('admin.resources.managerLoginLog');
    }
    public function addCompany()
    {
        return view('admin.resources.addCompany');
    }

    public function manageCompany()
    {
        return view('admin.resources.manageCompany');
    }

    public function searchManagers(Request $request)
    {
        try {
            $query = Login::with(['propertyinfo'])->where('user_type', 'M');

            if ($request->filled('status')) {
                $query->where('Status', $request->status);
            }
            if ($request->filled('username')) {
                $query->where('UserName', 'LIKE', '%' . $request->username . '%');
            }
            if ($request->filled('email')) {
                $query->where('Email', 'LIKE', '%' . $request->email . '%');
            }
            if ($request->filled('company')) {
                $query->whereHas('propertyinfo', function ($q) use ($request) {
                    $q->where('Company', 'LIKE', '%' . $request->company . '%');
                });
            }
            if ($request->filled('propertyname')) {
                $query->whereHas('propertyinfo', function ($q) use ($request) {
                    $q->where('PropertyName', 'LIKE', '%' . $request->propertyname . '%');
                });
            }

            if ($request->ajax()) {
                return DataTableService::of($query)
                    ->addIndexColumn()
                    ->addColumn('status', DataTableService::statusColumn())
                    ->addColumn('username', function($row) {
                        return '<a href="' . route('admin-view-profile', ['id' => $row->Id]) . '">' . e($row->UserName) . '</a>';
                    })
                    ->addColumn('property_names', function($row) {
                        return $row->propertyinfo->map(function($p) {
                            return '<span class="badge badge-primary m-1"><a href="#" class="text-white">' . e($p->PropertyName) . '</a></span>';
                        })->join(' ');
                    })
                    ->addColumn('actions', DataTableService::actionColumn([
                        'view' => [
                            'route' => fn($row) => route('admin-view-profile', ['id' => $row->Id]),
                            'icon' => 'fa-eye',
                            'class' => 'view-btn'
                        ],
                        'edit' => [
                            'route' => fn($row) => route('admin-edit-manager', ['id' => $row->Id]),
                            'icon' => 'fa-pen',
                            'class' => 'edit-btn'
                        ]
                    ]))
                    ->rawColumns(['status', 'username', 'property_names', 'actions'])
                    ->make(true);
            }

            return response()->json(['error' => 'Invalid request'], 400);
        } catch (\Exception $e) {
            \Log::error('Error searching managers: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }







}
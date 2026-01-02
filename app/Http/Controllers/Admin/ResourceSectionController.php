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


class ResourceSectionController extends Controller
{
    public function listManager(Request $request)
    {
        try {
            $listmanagers = Login::where('user_type', 'M')->where('Status', 1)->with('propertyinfo')->orderBy('Id', 'desc')->get();

            if ($request->ajax()) {

                return DataTables::of($listmanagers)->addIndexColumn()
                    ->addColumn('managername', function ($row) {
                        $viewprofileURL = route('admin-view-profile', ['id' => $row->Id]);
                        $managername = "<a href=" . $viewprofileURL . " class='font-weight-bold'>$row->UserName</a>";
                        return $managername;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->Status == 1) {
                            return "<a href='javascript:void(0)' class='c-pill c-pill--success'> Active </a>";
                        } elseif ($row->Status == 2) {
                            return "<a href='javascript:void(0)' class='c-pill c-pill--danger'> Leased </a>";
                        } else {
                            return "<a href='javascript:void(0)' class='c-pill c-pill--warning'> InActive </a>";
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $viewprofileURL = route('admin-view-profile', ['id' => $row->Id]);
                        $editmanager = route('admin-edit-manager', ['id' => $row->Id]);
                        $actionbtn = '<div class="table-actions-icons float-left">
                                        <a href="' . $viewprofileURL . '" class="view-icon" data-id="">
                                            <i class="fa-solid fa-eye border px-2 py-2 view-icon"></i>
                                        </a>
                                        <a href="' . $editmanager . '" class="edit-btn" data-id="">
                                            <i class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="delete-btn delete-icon property-delete-btn"><i class="fa-solid fa-trash border px-2 py-2 delete-icon"></i></a>
                                </div>';
                        return $actionbtn;
                    })
                    ->rawColumns(['managername', 'status', 'action'])
                    ->make(true);
            } else {
                return view('admin.resources.listManager');
            }
        } catch (\Exception $e) {

            \Log::error('Error in listManager: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'There was an error processing your request. Please try again later.'
            ], 500);
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

        $recordsFiltered = $query->count();

        $managers = $query->skip($request->start ?? 0)->take($request->length ?? 10)->get();

        $data = $managers->map(function ($manager) {
            return [
                'status' => $manager->Status,
                'username' => '<a href="' . route('admin-view-profile', ['id' => $manager->Id]) . '">' . $manager->UserName . '</a>',
                'email' => $manager->Email,
                'property_names' => $manager->propertyinfo->pluck('PropertyName', 'Id')->map(function ($name) {
                    return '<ul><li style="color: white; background-color: #007bff; padding: 5px; margin: 5px 0; border-radius: 5px;"><a href="#" style="color: white; text-decoration: none;">' . $name . '</a></li></ul>';
                })->join(''),
                'managed_by' => $manager->Company,
            ];
        });

        return response()->json([
            'data' => $data,
            'recordsTotal' => Login::where('user_type', 'M')->count(),
            'recordsFiltered' => $recordsFiltered,
        ]);
    }







}
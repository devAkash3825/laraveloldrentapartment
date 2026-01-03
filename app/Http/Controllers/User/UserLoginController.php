<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Login;
use App\Models\RenterInfo;
use App\Models\User;
use App\Models\State;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserLoginController extends Controller
{


    public function showRegisterForm()
    {
        $state = State::all();
        $source = Source::all();
        return view('user.auth.register', compact('state', 'source'));
    }
    public function showUserLoginForm()
    {
        return view('user.auth.login');
    }

    public function userLogin(Request $request)
    {
        $loginId = $request->input('username') ?? $request->input('email') ?? $request->input('login_id');
        
        $request->merge(['login_id' => $loginId]);

        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ]);

        try {
            // Support both username and email login
            $user = Login::where('UserName', $loginId)
                         ->orWhere('Email', $loginId)
                         ->first();

            if ($user) {
                $isAuthenticated = false;
                
                // Try Bcrypt first (Standard Laravel)
                if (Hash::check($request->password, $user->Password)) {
                    $isAuthenticated = true;
                } 
                // Fallback for legacy plain text passwords if necessary
                else if ($request->password === $user->Password) {
                    $isAuthenticated = true;
                    // Auto-hash it for next time
                    $user->Password = Hash::make($request->password);
                    $user->save();
                    Log::info('Legacy password updated for user: ' . $user->UserName);
                }

                if ($isAuthenticated) {
                    Auth::guard('renter')->login($user, $request->has('remember'));
                    
                    // Regenerate session for security
                    $request->session()->regenerate();
                    
                    Log::info('User logged in: ' . $user->UserName);
                    return redirect()->intended('/');
                }
            }

            Log::warning('Failed login attempt for: ' . $loginId);
            return redirect()->back()
                ->withInput($request->all())
                ->with('error', 'Invalid username or password.');

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while trying to log in.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('renter')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('show-login');
    }

    public function managerRegister(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:login',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = Login::create([
                'UserName'   => $request->username,
                'Password'   => Hash::make($request->password),
                'Email'      => $request->email,
                'user_type'  => 'M',
                'UserIp'     => $request->ip(),
                'CreatedOn'  => now(),
                'ModifiedOn' => now(),
                'Status'     => '1',
            ]);

            Auth::guard('renter')->login($user);

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Manager registered and logged in successfully.',
                ]);
            }

            return redirect()->intended('/');
        } catch (\Exception $e) {
            Log::error('Manager registration error: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'An error occurred during registration.',
                ], 500);
            }
            return back()->with('error', 'An error occurred while trying to register. Please try again later.');
        }
    }

    public function renterRegister(Request $request)
    {
        $request->validate([
            'username'              => 'required',
            'email'                 => 'required|email|unique:login',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
            'firstname'             => 'required',
            'lastname'              => 'required',
            'zip'                   => 'required',
            'cell'                  => 'required',
            'renterstate'           => 'required',
            'rentercity'            => 'required',
            'aboutmovein'           => 'required',
            'latestdate'            => 'required',
            'petinfo'               => 'required',
            'source'                => 'required',
            'additional_info'       => 'required',
            'price_from'            => 'required',
            'price_to'              => 'required',
            'currentAddress'        => 'required',
        ]);

        try {
            $login = Login::create([
                'UserName'         => $request->username,
                'Password'         => Hash::make($request->password),
                'Email'            => $request->email,
                'CreatedOn'        => now(),
                'ModifiedOn'       => now(),
                'Status'           => '1',
                'UserIp'           => $request->ip(),
                'user_type'        => 'C',
                'acc_to_craiglist' => 'No',
            ]);

            RenterInfo::create([
                'Login_ID'         => $login->Id,
                'Firstname'        => $request->firstname,
                'Lastname'         => $request->lastname,
                'phone'            => $request->cell,
                'Evening_phone'    => $request->otherphone,
                'Current_address'  => $request->currentAddress,
                'Cityid'           => $request->rentercity,
                'zipcode'          => $request->zip,
                'Area_move'        => $request->aboutmovein,
                'Emove_date'       => $request->earliestdate,
                'Lmove_date'       => $request->latestdate,
                'Rent_start_range' => $request->price_from,
                'Rent_end_range'   => $request->price_to,
                'Additional_info'  => $request->additional_info,
                'Hearabout'        => $request->source,
            ]);

            Auth::guard('renter')->login($login);

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Renter registered and logged in successfully.',
                ]);
            }

            return redirect()->intended('/');

        } catch (\Exception $e) {
            Log::error('Error adding renter: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'An error occurred while adding the renter. Please try again later.',
                ], 500);
            }
            return back()->with('error', 'An error occurred while trying to register. Please try again later.');
        }
    }

    public function changePassword()
    {
        $pagetitle = "Change Password";
        return view('user.changePassword',['pagetitle' => $pagetitle ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|confirmed|min:8',
        ]);

        $user = Auth::guard('renter')->user();

        if (!Hash::check($request->old_password, $user->Password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 400);
        }

        $user->Password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => 'Password changed successfully!'], 200);
    }

    public function forgotPasswod()
    {
        return view('user.auth.forgotPassword');
    }

    public function loginUserForm()
    {
        return view('user.pages.loginUser');
    }

}
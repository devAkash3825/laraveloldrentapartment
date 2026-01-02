<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Login;
use App\Models\RenterInfo;
use App\Models\User;
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
        return view('user.auth.register');
    }
    public function showUserLoginForm()
    {
        return view('user.auth.login');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $renter = Login::where('UserName', $request->username)->first();

            if ($renter) {
                $dbPassword    = $renter->Password;
                $inputPassword = $request->password;

                $passwordMatches = false;

                // Check if password is hashed (e.g., bcrypt hashes start with $2y$)
                if (Str::startsWith($dbPassword, '$2y$')) {
                    $passwordMatches = Hash::check($inputPassword, $dbPassword);
                } else {
                    // Fallback to plain password comparison
                    $passwordMatches = $dbPassword === $inputPassword;
                }

                if ($passwordMatches) {
                    Auth::guard('renter')->login($renter);
                    return redirect()->intended('/');
                }
            }

            return redirect()->route('login')->with('error', 'Invalid credentials');
        } catch (Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'An error occurred while trying to log in. Please try again later.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function managerRegister(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:login',
            'password' => 'required|confirmed',
        ]);
        $email      = $request->email;
        $password   = $request->password;
        $username   = $request->username;
        $ip_address = $request->ip();
        $createdOn  = Carbon::now();
        $modifiedOn = Carbon::now();
        $usertype   = "M";
        try {
            $user = Login::create([
                'UserName'   => $username,
                'Password'   => $password,
                'Email'      => $email,
                'user_type'  => $usertype,
                'UserIp'     => $ip_address,
                'CreatedOn'  => $createdOn,
                'ModifiedOn' => $modifiedOn,
            ]);
            $credentials = $request->only('username', 'password');
            $manager     = Login::where('UserName', $request->username)->first();

            if ($request->password === $manager->Password) {
                Auth::guard('renter')->login($manager);
                return redirect()->intended('/');
                // return response()->json([
                //     'success' => 'Manager Register success',
                // ]);
            } else {
                return response()->json([
                    'error',
                    'error',
                ]);
            }
        } catch (Exception $e) {
            Log::error('Admin login error: ' . $e->getMessage());
            return redirect()->route('admin-login')->with('error', 'An error occurred while trying to log in. Please try again later.');
        }
    }

    public function renterRegister(Request $request)
    {
        if ($request->ajax()) {
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
                    'Password'         => $request->password,
                    'Email'            => $request->email,
                    'CreatedOn'        => now(),
                    'ModifiedOn'       => now(),
                    'Status'           => '1',
                    'UserIp'           => $request->ip(),
                    'user_type'        => 'C',
                    'acc_to_craiglist' => 'No',
                ]);

                $Id = $login->Id;

                RenterInfo::create([
                    'Login_ID'         => $Id,
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

                $renterlogin = Login::where('Email', $request->email)->first();

                if (Hash::check($request->password, $renterlogin->Password) || $renterlogin->Password === $request->password) {
                    Auth::guard('renter')->login($renterlogin);

                    return response()->json([
                        'success' => 'Renter registered and logged in successfully.',
                    ]);
                } else {
                    return response()->json([
                        'error' => 'Invalid credentials.',
                    ], 401);
                }

            } catch (\Exception $e) {
                Log::error('Error adding renter: ' . $e->getMessage());
                $file = 'leads-log.log';
                file_put_contents($file, print_r($e->getMessage(), true), FILE_APPEND);
                return response()->json([
                    'status'  => 'error',
                    'message' => 'An error occurred while adding the renter. Please try again later.',
                ], 500);
            }
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
            'password'     => 'required|confirmed',
        ]);

        $user            = Auth::guard('renter')->user();
        $userid          = Auth::guard('renter')->user()->Id;
        $currentPassword = $user->Password;

        if (Hash::check($request->old_password, $currentPassword)) {
            if (! Hash::check($request->old_password, $currentPassword)) {
                return response()->json(['error' => 'Old password is incorrect'], 400);
            } else {
                $updatePassword = $request->password;
                $changePassword = Login::where('Id', $userid)->update([
                    'Password' => $updatePassword,
                ]);
                if ($$changePassword) {
                    return response()->json(['success' => 'Password changed successfully'], 200);
                }
            }
        } else {
            if ($request->old_password !== $currentPassword) {
                return response()->json(['error' => 'Old password is incorrect'], 400);
            } else {
                $updatePassword = $request->password;
                $changePassword = Login::where('Id', $userid)->update([
                    'Password' => $updatePassword,
                ]);
                if ($changePassword) {
                    return response()->json(['success' => 'Password changed successfully'], 200);
                }
            }
        }
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
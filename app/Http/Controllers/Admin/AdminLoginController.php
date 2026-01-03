<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminDetail;
use Illuminate\Support\Facades\Auth;
use LoginHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotAndResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;
class AdminLoginController extends Controller
{

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    public function adminLogin(Request $request)
    {
        $request->validate([
            'admin_login_id' => 'required',
            'password' => 'required',
        ]);

        try {
            $admin = AdminDetail::where('admin_login_id', $request->admin_login_id)->first();

            if ($admin && Hash::check($request->password, $admin->password)) {
                Auth::guard('admin')->login($admin);
                return redirect()->intended('/admin/agent-remainder');
            }

            return redirect()->route('admin-login')->with('error', 'Invalid credentials');
        } catch (Exception $e) {
            Log::error('Admin login error: ' . $e->getMessage());
            return redirect()->route('admin-login')->with('error', 'An error occurred while trying to log in.');
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin-login');
    }
    public function forgotPassword()
    {
        return view('admin.auth.forgotPassword');
    }
    public function requestPasswordReset(Request $request)
    {
        $request->validate([
            'adminemail' => 'required',
        ]);

        $otp = random_int(100000, 999999);
        $adminemail = $request->adminemail;
        $expiresAt = Carbon::now()->addMinutes(15);

        $update = AdminDetail::where('admin_email', $adminemail)->update([
            'otp' => $otp,
            'otp_expires_at' => $expiresAt,
        ]);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update OTP. Please try again.'
            ]);
        }

        $details = [
            'otp' => $otp,
            'email' => $adminemail,
            'expires_at' => $expiresAt->toDateTimeString(),
        ];

        try {
            Mail::to($adminemail)->send(new ForgotAndResetPasswordMail($details));

            return response()->json([
                'email' => $adminemail,
                'success' => true,
                'message' => 'OTP sent to your email. It will expire in 15 minutes.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please check your email configuration.'
            ]);
        }
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'emailwithotp' => 'required|email',
            'otp' => 'required|numeric',
        ]);
        $email = $request->emailwithotp;
        $admin = AdminDetail::where('admin_email', $request->emailwithotp)->where('otp', $request->otp)->first();

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP.']);
        }

        return response()->json([
            'email' => $email,
            'success' => true,
            'message' => 'OTP verified.'
        ]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'resetpasswordemail' => 'required',
            'password' => 'required',
        ]);

        AdminDetail::where('admin_email', $request->resetpasswordemail)->update([
            'password' => Hash::make($request->password),
            'otp' => null,
        ]);

        return response()->json(['success' => true, 'message' => 'Password reset successfully.']);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email|exists:admin_detail,admin_email',
            'password' => 'required|confirmed|min:8',
        ]);

        $admin = AdminDetail::where('admin_email', $request->admin_email)->first();

        $admin->password = Hash::make($request->password);
        $admin->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }



}

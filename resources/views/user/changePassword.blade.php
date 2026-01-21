@extends('user.layout.app')
@section('content')
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Security Settings</h1>
                <p class="text-white opacity-75 lead mb-0">Manage your account password and security</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Change Password</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section id="dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="dashboard_content mt-0">
                    <div class="my_listing list_mar mt-0">
                        <h4>Change Password</h4>
                        <form id="changePasswordForm" method="POST">
                            <div class="row">
                                <div class="col-xl-12 col-md-6">
                                    <div class="my_listing_single">
                                        <label>current password</label>
                                        <div class="input_area" style="position: relative;">
                                            <input type="password" placeholder="Current Password" name="old_password" id="old_password">
                                            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('old_password', event)" style="position: absolute; right: 10px; top: 12px; border: none; background: none; color: #999;">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-6">
                                    <div class="my_listing_single">
                                        <label>new password</label>
                                        <div class="input_area" style="position: relative;">
                                            <input type="password" placeholder="New Password" name="password" id="new_password">
                                            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('new_password', event)" style="position: absolute; right: 10px; top: 12px; border: none; background: none; color: #999;">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label>confirm password</label>
                                        <div class="input_area" style="position: relative;">
                                            <input type="password" placeholder="Confirm Password" name="password_confirmation" id="confirm_password">
                                            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('confirm_password', event)" style="position: absolute; right: 10px; top: 12px; border: none; background: none; color: #999;">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <button type="submit" class="read_btn float-right">Change Password </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('user.layout.app')
@section('content')
<div id="breadcrumb_part"
    style="background: url(../images/breadcroumb_bg.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4> {{ $pagetitle }} </h4>
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{ $pagetitle }} </li>
                        </ol>
                    </nav>
                </div>
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
@extends('admin/layouts/app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle">Change Password  </h6>
        </div>
        <div class="section-wrapper">
            <form action="">
                <div class="form-layout">
                    <div class="row mg-b-25">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Current Password</label>
                                <input class="form-control" type="password" name="currentpassword" id="currentpassword">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">New Password</label>
                                <input class="form-control" type="password" name="newpassword" id="newpassword">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Confirm Password </label>
                                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword">
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="form-group">
                                <button class="btn btn-primary float-right">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
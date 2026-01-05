@extends('admin.layouts.app')
@section('content')
@php
$settings = DB::table('settings')->pluck('value', 'key');
@endphp
@push('style')
<link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.3.0/css/bootstrap-colorpicker.min.css">
<style>
    .image-preview,
    #callback-preview {
        width: 250px;
        height: 250px;
        border: 2px dashed #ddd;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
        background-color: #ffffff;
        color: #ecf0f1;
    }

    .image-preview,
    #callback-preview:hover {
        /* background-color: black; */
        cursor: pointer;
    }

    .image-preview input,
    #callback-preview input {
        line-height: 200px;
        font-size: 200px;
        position: absolute;
        opacity: 0;
        z-index: 10;
        cursor: pointer;
    }

    .image-hover-label {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        justify-content: center;
        align-items: center;
        font-size: 16px;
        cursor: pointer;
    }

    .image-preview:hover .image-hover-label {
        display: flex;
    }

    #image-upload {
        display: none;
        /* Hide the file input */
    }
</style>
@endpush
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> General Settings </h6>
        </div>
        <div class="section-wrapper">
            <nav>
                <ul class="tabs">
                    <li class="tab-li">
                        <a href="#sitesettings" class="tab-li__link">Site Settings </a>
                    </li>
                    <li class="tab-li">
                        <a href="#logoandfavicon" class="tab-li__link">Logo and Favicon Settings </a>
                    </li>
                    <li class="tab-li">
                        <a href="#appearancesettings" class="tab-li__link">Appearance Settings </a>
                    </li>
                    <li class="tab-li">
                        <a href="#mailsettings" class="tab-li__link">Mail Settings </a>
                    </li>
                    {{-- <li class="tab-li">
                            <a href="#pushersettings" class="tab-li__link">Pusher Settings </a>
                        </li> --}}
                </ul>
            </nav>

            <section id="sitesettings" data-tab-content class="p-0">
                <form action="" method="POST" enctype="multipart/form-data" id="updatesitenamesform">
                    <div class="row mt-3">
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label for="">Site Name <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="site_name"
                                    value="{{ config('settings.site_name') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Site Email <span class="text-danger"></span></label>
                                <input type="email" class="form-control" name="site_email"
                                    value="{{ config('settings.site_email') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Site Phone <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="site_phone"
                                    value="{{ config('settings.site_phone') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Select Time Zone <span class="text-danger"></span></label>
                                <select name="site_timezone" class="form-control select2">
                                    <option value="">Select</option>
                                    <option value="UTC">UTC</option>
                                    @foreach (config('time-zone') as $key => $timezone)
                                    <option @selected($key===$settings['site_timezone'] ) value="{{ $key }}">
                                        {{ $key }}
                                        - {{ $timezone }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-4">
                            <div class="form-layout-footer" style="float: right;">
                                <button type="submit" class="btn btn-primary bd-0 submit-spinner" id="update-titles">
                                    Update </button>
                            </div>
                        </div>

                    </div>
                </form>
            </section>

            <section id="logoandfavicon" data-tab-content class="p-0">
                <form action="" method="POST" enctype="multipart/form-data" id="updatelogoandfavicons">
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Site Logo <span class="text-danger"></span></label>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" class="image-hover-label">Choose File</label>
                                    <input type="file" name="logo" id="image-upload" style="display: none;" />
                                    <input type="hidden" name="old_logo" value="{{ $settings['logo'] }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Site Favicon <span class="text-danger"></span></label>
                                <div id="image-favicon-preview" class="image-preview">
                                    <label for="image-upload-favicon" class="image-hover-label">Choose File</label>
                                    <input type="file" name="favicon" id="image-upload-favicon" style="display: none;" />
                                    <input type="hidden" name="old_favicon" value="{{ $settings['favicon'] }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-4">
                            <div class="form-layout-footer" style="float: right;">
                                <button type="submit" class="btn btn-primary bd-0 submit-spinner"
                                    id="update-titles">
                                    Update </button>
                            </div>
                        </div>

                    </div>
                </form>
            </section>

            <section id="appearancesettings" data-tab-content class="p-0">
                <form action="" method="POST" id="appearenceform" novalidate>
                    <div class="row mt-3">
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label for="">Default Site Color <span class="text-danger"> * </span></label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="site_default_color"
                                        value="{{ $settings['site_default_color'] }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label for="">Default Buttons Color <span class="text-danger"> * </span></label>
                                <div class="input-group colorpickerinput">
                                    <input type="text" class="form-control" name="site_btn_color"
                                        value="{{ $settings['site_btn_color'] }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-fill-drip"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-4">
                            <div class="form-layout-footer" style="float:right;">
                                <button type="submit" class="btn btn-primary bd-0 submit-spinner">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>

            <section id="mailsettings" data-tab-content class="p-0">
                <form action="" method="POST" id="mailsettingsform">
                    <div class="row mt-3">
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail Driver</label>
                                <input type="text" class="form-control" name="mail_driver" value="{{ $settings['mail_driver'] ?? 'smtp' }}">
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail Host</label>
                                <input type="text" class="form-control" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail Port</label>
                                <input type="text" class="form-control" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}">
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail Encryption</label>
                                <input type="text" class="form-control" name="mail_encryption" value="{{ $settings['mail_encryption'] ?? 'tls' }}">
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail Username</label>
                                <input type="text" class="form-control" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail Password</label>
                                <input type="text" class="form-control" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail From Address</label>
                                <input type="text" class="form-control" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="form-group">
                                <label for="">Mail From Name</label>
                                <input type="text" class="form-control" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-lg-12 mt-4">
                            <div class="form-layout-footer" style="float:right;">
                                <button type="submit" class="btn btn-primary bd-0 submit-spinner">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script src="{{ asset('admin_asset/js/tabviewform.js') }}"></script>
<script src="{{ asset('admin_asset/js/jquery.uploadPreview.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.3.0/js/bootstrap-colorpicker.min.js">
</script>

<script>
    $(document).ready(function() {
        var logoimageurl = "{{ asset(config('settings.logo', 'img/no-img.jpg')) }}";
        var faviconimageurl = "{{ asset(config('settings.favicon', 'img/no-img.jpg')) }}";

        $('#image-preview').css({
            'background-image': `url(${logoimageurl})`,
            'background-size': 'contain',
            'background-position': 'center center',
            'background-repeat': 'no-repeat',
        });

        $('#image-upload').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').css('background-image', `url(${e.target.result})`);
                };
                reader.readAsDataURL(file);
            }
        });

        $('#image-favicon-preview').css({
            'background-image': `url(${faviconimageurl})`,
            'background-size': 'contain',
            'background-position': 'center center',
            'background-repeat': 'no-repeat',
        });

        $('#image-upload-favicon').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-favicon-preview').css('background-image', `url(${e.target.result})`);
                };
                reader.readAsDataURL(file);
            }
        });

        $(".colorpickerinput").colorpicker({
            format: 'hex',
            component: '.input-group-append'
        });

        $("#appearenceform").submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin-update-appearence') }}";
            var formData = $(this).serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    )
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        AdminToast.success(response.message);
                    }
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
                error: function(xhr) {
                    AdminToast.error("Something went wrong");
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
            });
            $(this).addClass('was-validated');
        });

        $("#updatesitenamesform").submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin-update-sitenames') }}";
            var formData = $(this).serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    )
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        AdminToast.success(response.message);
                    }
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
                error: function(xhr) {
                    AdminToast.error("Something went wrong");
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
            });
            $(this).addClass('was-validated');
        });

        $("#updatelogoandfavicons").submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin-update-logo') }}";
            var formData = new FormData(this);
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    )
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        AdminToast.success(response.message);
                    }
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
                error: function(xhr) {
                    AdminToast.error("Something went wrong");
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
            });
        });

        $("#mailsettingsform").submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin-update-mail-settings') }}";
            var formData = $(this).serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    )
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        AdminToast.success(response.message);
                    }
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
                error: function(xhr) {
                    AdminToast.error("Failed to update mail settings");
                    $('.submit-spinner').html(`Update`)
                    $('.submit-spinner').prop('disabled', false);
                },
            });
        });
    });
</script>
@endpush
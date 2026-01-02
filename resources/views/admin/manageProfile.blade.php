@extends('admin.layouts.app')
@section('content')
    <style>
        .profile-container {
            max-width: 960px;
            /* margin: 10px auto; */
            padding: 0px 10px;
        }

        .profile-container h1 {
            font-size: 20px;
            text-align: center;
            margin: 20px 0;
        }

        .profile-container h1 small {
            display: block;
            font-size: 15px;
            margin-top: 8px;
            color: gray;
        }

        .profile-container .avatar-upload {
            position: relative;
            max-width: 205px;
            /* margin: 20px auto; */
        }

        .profile-container .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            top: 10px;
            z-index: 1;
        }

        .profile-container .avatar-upload .avatar-edit input {
            display: none;
        }

        .profile-container .avatar-upload .avatar-edit input+label {
            display: inline-block;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            text-align: center;
            line-height: 34px;
        }

        .profile-container .avatar-upload .avatar-edit input+label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        .profile-container .avatar-upload .avatar-edit input+label:after {
            content: "\f040";
            font-family: 'FontAwesome';
            color: #757575;
        }

        .profile-container .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            /* border-radius: 50%; */
            border: 6px solid #F8F8F8;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .profile-container .avatar-upload .avatar-preview>div {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"></li>
                </ol>
                <h6 class="slim-pagetitle">Manage Profile </h6>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card card-profile">
                            <div class="card-body">

                                <form id="adminProfileForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="media">
                                        <div class="profile-container">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type="file" id="imageUpload" name="admin_headshot"
                                                        accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview"
                                                        style="background-image: url('{{ asset('uploads/profile_pics/' . Auth::guard('admin')->user()->admin_headshot) }}');">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="form-layout py-2">
                                                <div class="row mg-b-25">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Admin Name: <span
                                                                    class="tx-danger">*</span></label>
                                                            <input class="form-control" type="text" name="admin_name"
                                                                value="{{ Auth::guard('admin')->user()->admin_name }}"
                                                                placeholder="Enter Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Admin Username: <span
                                                                    class="tx-danger">*</span></label>
                                                            <input class="form-control" type="text" name="admin_login_id"
                                                                value="{{ Auth::guard('admin')->user()->admin_login_id }}"
                                                                placeholder="Enter Username">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Email Address: <span
                                                                    class="tx-danger">*</span></label>
                                                            <input class="form-control" type="email" name="email"
                                                                value="{{ Auth::guard('admin')->user()->admin_email }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <button type="submit"
                                                            class="btn btn-primary bd-0 float-right submit-spinner"> Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        $('#adminProfileForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin-update-profile') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                            <span role="status">Updating...</span>`
                    );
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        if (response.data.admin_headshot) {
                            $('#imagePreview').css('background-image', 'url(' +
                                "{{ asset('admin_asset/upload_pics/') }}" + '/' +
                                response.data.admin_headshot + ')');
                        }
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toastr.error(response.message);
                }
            });
        });
    </script>
@endpush

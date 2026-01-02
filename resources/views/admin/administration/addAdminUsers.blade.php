@extends('admin.layouts.app')

@section('content')
    <style>
        .show-password {
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 0px !important;
        }

        label.error {
            color: red;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        input.error,
        select.error,
        textarea.error {
            border-color: red;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        .input-group {
            margin-bottom: 1rem;
        }

        input {
            transition: all 0.3s ease-in-out;
        }
    </style>
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Add Administrator User</h6>
            </div>

            <div class="section-wrapper">
                <form id="addAdminForm" novalidate="">
                    <div class="form-layout form-layout-4">

                        <div class="form-row">
                            <!-- Full Name -->
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="fullname" class="font-weight-bold">Full Name <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    </div>
                                    <input type="text" id="fullname" name="fullname" class="form-control"
                                        placeholder="Enter Full Name" required>
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="title" class="font-weight-bold">Title <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-heading"></i></span>
                                    </div>
                                    <input type="text" id="title" name="title" class="form-control"
                                        placeholder="Enter Title" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="email" class="font-weight-bold">Email <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    </div>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Enter Email Address" required>
                                </div>
                            </div>

                            <!-- Company -->
                            <div class="form-group col-lg-12 col-md-12 col-12">
                                <label for="company" class="font-weight-bold">Company</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-building"></i></span>
                                    </div>
                                    <input type="text" id="company" name="company" class="form-control"
                                        placeholder="Enter Company Name">
                                </div>
                            </div>

                            <!-- Login ID -->
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="login_id" class="font-weight-bold">Login ID <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
                                    </div>
                                    <input type="text" id="login_id" name="login_id" class="form-control"
                                        placeholder="Enter Login ID" required>
                                </div>
                                <div class="invalid-feedback">Please enter a login ID.</div>
                            </div>

                            <!-- Password -->
                            <div class="form-group col-lg-4 col-md-6 col-12">
                                <label for="password" class="font-weight-bold">Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                    </div>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Enter Password" required>
                                    <i class="fa-regular fa-eye toggle-password show-password" id="togglePassword"
                                        style="position: absolute;top:14px;right:10px;"></i>
                                </div>
                                <div class="invalid-feedback">Please enter a password.</div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group col-lg-4 col-md-6 col-12">
                                <label for="password_confirmation" class="font-weight-bold">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control" placeholder="Confirm Password" required>
                                    <i class="fa-regular fa-eye toggle-password show-confirm_password"
                                        id="toggleConfirmationPassword"
                                        style="position: absolute;top:14px;right:10px;"></i>
                                </div>
                                <div class="invalid-feedback">Passwords do not match.</div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="phone" class="font-weight-bold">Phone <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="phone" name="phone" type="text" class="form-control"
                                        placeholder="(999) 999-9999" required>
                                </div>
                                <div class="invalid-feedback">Please enter your phone number.</div>
                            </div>

                            <!-- Twilio Number -->
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="twilio_number" class="font-weight-bold">Twilio Number <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="twilio_number" name="twilio_number" type="text" class="form-control"
                                        placeholder="(999) 999-9999" required>
                                </div>
                                <div class="invalid-feedback">Please enter your Twilio number.</div>
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="cell_number" class="font-weight-bold">Cell Number <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="cell_number" name="cell_number" type="text" class="form-control"
                                        placeholder="(999) 999-9999" required>
                                </div>
                                <div class="invalid-feedback">Please enter your Cell number.</div>
                            </div>
                        </div>





                        <table class="table mg-b-0 mt-4">
                            <thead>
                                <tr>
                                    <th>Select State </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <div class="row mt-2">
                                            @foreach ($state as $row)
                                                <div class="col-md-2">
                                                    <label class="ckbox">
                                                        <input type="checkbox" class="state-checkbox"
                                                            value="{{ $row->Id }}" name="adminstate[]">
                                                        <span class="font-weight-bold">{{ $row->StateName }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table mg-b-0 mt-4">
                            <thead>
                                <tr>
                                    <th>Select City</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <div class="row mt-2" id="city-section">
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table mg-b-0 mt-4">
                            <thead>
                                <tr>
                                    <th>Access Rights <span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="container my-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="section">
                                        <div class="section-title">Property Management</div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="property_addedit" value="1">
                                                    <span>Add/Edit Property</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="property_delete" value="1">
                                                    <span>Delete Property</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="property_active" value="1">
                                                    <span>Active/Inactive Property</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- User Management Section -->
                                    <div class="section">
                                        <div class="section-title">User Management</div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="user_addedit" value="1">
                                                    <span>Add/Edit User</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="user_delete" value="1">
                                                    <span>Delete User</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="user_active" value="1">
                                                    <span>Active/Inactive User</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Featured Company Management Section -->
                                    <!-- <div class="section">
                                        <div class="section-title">Featured Company Management</div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="company_addedit" value="1">
                                                    <span>Add/Edit Company</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="company_delete" value="1">
                                                    <span>Delete Company</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="company_active" value="1">
                                                    <span>Active/Inactive Company</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr> -->

                                    <!-- Administrator User Management Section -->
                                    <div class="section">
                                        <div class="section-title">Administrator User Management</div>
                                        <div class="row mt-2">
                                            <div class="col-md-6 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="adminuser_addedit" value="1">
                                                    <span>Add/Edit User</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="adminuser_delete" value="1">
                                                    <span>Delete User</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- <div class="section">
                                        <div class="section-title">Fees Management</div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="fees_addedit" value="1">
                                                    <span>Add/Edit Fees</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr> -->

                                    <div class="section">
                                        <div class="section-title">Notify History Management</div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="notify_addedit" value="1">
                                                    <span>Add/Edit Notify</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="notify_delete" value="1">
                                                    <span>Delete Notify</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="section">
                                        <div class="section-title">Content Management</div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="content_addedit" value="1">
                                                    <span>Add/Edit Content</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="content_delete" value="1">
                                                    <span>Delete Content</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                </div>

                                <div class="col-md-4">
                                    <div class="section">
                                        <div class="section-title">Renter Update History</div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="renter_update_history_delete"
                                                        value="1">
                                                    <span>Delete Renter Update History</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="section">
                                        <div class="section-title">Claim Renter</div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="renter_claim" value="1">
                                                    <span>Claim Unassigned Renter</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="section">
                                        <div class="section-title">School Management</div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="access_school_management" value="1">
                                                    <span>Access to School Management</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="section">
                                        <div class="section-title">Delete Messages</div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="access_delete_message" value="1">
                                                    <span>Access to Delete Messages</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="section">
                                        <div class="section-title">Access to CSV Export</div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" name="access_csv_export" value="1">
                                                    <span>Access to Export CSV</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <div class="col-sm-12">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-primary bd-0 float-right submit-spinner">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            $(".show-password").on("click", function() {
                const passwordField = $("#password");
                const type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);
                $(this).toggleClass("fa-eye fa-eye-slash");
            });

            $(".show-confirm_password").on("click", function() {
                const passwordField = $("#password_confirmation");
                const type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);
                $(this).toggleClass("fa-eye fa-eye-slash");
            });

            $.validator.addMethod(
                "pwcheck",
                function(value) {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/.test(value);
                },
                "Password must include at least one uppercase letter, one lowercase letter, and a number."
            );

            $('#addAdminForm').validate({
                errorClass: "error",
                validClass: "is-valid",
                rules: {
                    fullname: {
                        required: true,
                        maxlength: 255
                    },
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    login_id: {
                        required: true,
                        maxlength: 255
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        pwcheck: true
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                    phone: {
                        required: true,
                        maxlength: 15,
                        digits: true
                    },
                    twilio_number: {
                        required: true,
                        maxlength: 15,
                        digits: true
                    },
                    cell_number: {
                        required: true,
                        maxlength: 15,
                        digits: true
                    }
                },
                messages: {
                    fullname: {
                        required: "Full Name is required."
                    },
                    email: {
                        required: "Valid email is required.",
                        email: "Please enter a valid email address."
                    },
                    title: {
                        required: "Title is required."
                    },
                    login_id: {
                        required: "Login ID is required."
                    },
                    password: {
                        required: "Password is required.",
                        minlength: "Password must be at least 8 characters.",
                        pwcheck: "Must include upper, lower, digit."
                    },
                    password_confirmation: {
                        required: "Confirm password.",
                        equalTo: "Passwords do not match."
                    },
                    phone: {
                        required: "Phone number is required.",
                        digits: "Phone number must contain only numeric digits."
                    },
                    twilio_number: {
                        required: "Twilio number is required.",
                        digits: "Twilio number must contain only numeric digits."
                    },
                    cell_number: {
                        required: "Cell Number is required.",
                        digits: "Cell number must contain only numeric digits."
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('admin-store-agents') }}",
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $('.submit-spinner').html(
                                `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submitting...`
                            )
                            $('.submit-spinner').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $("#addAdminForm")[0].reset();
                                $("#city-section").html("");
                                $("#updatesectiontitles")[0].reset();
                                $('.submit-spinner').html(`Submit`)
                                $('.submit-spinner').prop('disabled', false);
                            } else {
                                if (response.errors) {
                                    $.each(response.errors, function(key, value) {
                                        $("#error_" + key).text(value[0]);
                                    });
                                    toastr.error(response.message);
                                }
                            }
                        },
                        error: function(xhr) {
                            toastr.error(response.message);
                            $('.submit-spinner').html(`Submit`)
                            $('.submit-spinner').prop('disabled', false);
                        },
                    });
                }
            });
        });
    </script>
@endpush

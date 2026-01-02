@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Add Manager </h6>
            </div>

            <div class="section-wrapper">
                {{-- <form id="addmanageform" novalidate>
                    <div class="form-row">
                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="userName" class="font-weight-bold">User Name <span class="text-danger"> *
                                </span></label>
                            <input type="text" class="form-control" id="userName" name="userName" value="{{ $manager->UserName }}" required>
                            <div class="invalid-feedback">
                                Please enter a user name.
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="emailId" class="font-weight-bold">Email ID <span class="text-danger"> *
                                </span></label>
                            <input type="email" class="form-control" id="emailId" name="emailId" value="{{ $manager->Email }}" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="password" class="font-weight-bold">Password <span class="text-danger"> *
                                </span></label>
                            <input type="password" class="form-control" id="password" name="password" vallue="{{ $manager->Password }}" required>
                            <div class="invalid-feedback">
                                Please enter a password.
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="password_confirmation" class="font-weight-bold">Confirm Password <span
                                    class="text-danger"> * </span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                            <div class="invalid-feedback">
                                Passwords do not match.
                            </div>
                        </div>

                    </div>
                    <div class="form-row justify-content-end">
                        <button type="submit" class="btn btn-primary submit-spinner">Edit Manager</button>
                    </div>
                </form> --}}
                <form id="addmanageform" novalidate>
                    <div class="form-row">
                        <!-- User Name -->
                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="userName" class="font-weight-bold">User Name <span class="text-danger">
                                    *</span></label>
                            <input type="text" class="form-control" id="userName" name="userName"
                                value="{{ $manager->UserName }}" required>
                            <div class="invalid-feedback">
                                Please enter a user name.
                            </div>
                        </div>

                        <!-- Email ID -->
                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="emailId" class="font-weight-bold">Email ID <span class="text-danger">
                                    *</span></label>
                            <input type="email" class="form-control" id="emailId" name="emailId"
                                value="{{ $manager->Email }}" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group col-lg-6 col-md-6 col-12 position-relative">
                            <label for="password" class="font-weight-bold">Password <span class="text-danger">
                                    *</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    value="{{ $manager->Password }}" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-target="#password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Please enter a password.
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group col-lg-6 col-md-6 col-12 position-relative">
                            <label for="password_confirmation" class="font-weight-bold">Confirm Password <span
                                    class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" value="{{ $manager->Password }}" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-target="#password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Passwords do not match.
                            </div>
                        </div>
                    </div>

                    <div class="form-row justify-content-end">
                        <button type="button" class="btn btn-primary submit-spinner">Edit Manager</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $("#addmanageform").submit(function(e) {
        //         e.preventDefault();
        //         if (this.checkValidity() === false) {
        //             event.stopPropagation();
        //         } else {
        //             var url = "{{ route('admin-create-manager') }}";
        //             var formData = $(this).serialize();
        //             $.ajax({
        //                 url: url,
        //                 type: "POST",
        //                 data: formData,
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 beforeSend: function() {
        //                     $('.submit-spinner').html(
        //                         `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Adding...`
        //                     )
        //                     $('.submit-spinner').prop('disabled', true);
        //                 },
        //                 success: function(response) {
        //                     if (response.success) {
        //                         $('.submit-spinner').html(`Add Manager`);
        //                         $('.submit-spinner').prop('disabled', false);
        //                         toastr.success(" Created Successfully ");
        //                         $("#addourfeatures")[0].reset();
        //                     } else {
        //                         if (response.errors) {
        //                             toastr.error(" Not Created ");
        //                         }
        //                     }
        //                 },
        //                 error: function(xhr) {
        //                     toastr.error("An error occurred. Please try again.");
        //                     $('.submit-spinner').html(`Add Manager`);
        //                     $('.submit-spinner').prop('disabled', false);
        //                 },
        //                 complete: function() {
        //                     $('.submit-spinner').html(`Add Manager`);
        //                     $('.submit-spinner').prop('disabled', false);
        //                 },
        //             });
        //         }
        //         $(this).addClass('was-validated');
        //     });
        // });


        $(document).ready(function() {
            // Toggle password visibility
            $(".toggle-password").on("click", function() {
                const input = $($(this).data("target"));
                const icon = $(this).find("i");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });

            // AJAX form submission
            $("#addmanageform").on("submit", function(e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const url = ""; // Adjust with your route

                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    beforeSend: function() {
                        $(".submit-spinner").prop("disabled", true).text("Saving...");
                    },
                    success: function(response) {
                        $(".submit-spinner").prop("disabled", false).text("Edit Manager");
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        $(".submit-spinner").prop("disabled", false).text("Edit Manager");
                        if (xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error("An error occurred while saving.");
                        }
                    },
                });
            });
        });
    </script>
@endpush

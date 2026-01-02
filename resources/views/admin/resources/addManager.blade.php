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
                <form id="addmanageform" novalidate>
                    <div class="form-row">
                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="userName" class="font-weight-bold">User Name <span class="text-danger"> *
                                </span></label>
                            <input type="text" class="form-control" id="userName" name="userName" required>
                            <div class="invalid-feedback">
                                Please enter a user name.
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="emailId" class="font-weight-bold">Email ID <span class="text-danger"> *
                                </span></label>
                            <input type="email" class="form-control" id="emailId" name="emailId" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="password" class="font-weight-bold">Password <span class="text-danger"> *
                                </span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
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
                        <button type="submit" class="btn btn-primary submit-spinner">Add Manager</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#addmanageform").submit(function(e) {
                e.preventDefault();
                if (this.checkValidity() === false) {
                    event.stopPropagation();
                } else {
                    var url = "{{ route('admin-create-manager') }}";
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
                                `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Adding...`
                            )
                            $('.submit-spinner').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.submit-spinner').html(`Add Manager`);
                                $('.submit-spinner').prop('disabled', false);
                                toastr.success(" Created Successfully ");
                                $("#addourfeatures")[0].reset();
                            } else {
                                if (response.errors) {
                                    toastr.error(" Not Created ");
                                }
                            }
                        },
                        error: function(xhr) {
                            toastr.error("An error occurred. Please try again.");
                            $('.submit-spinner').html(`Add Manager`);
                            $('.submit-spinner').prop('disabled', false);
                        },
                        complete: function() {
                            $('.submit-spinner').html(`Add Manager`);
                            $('.submit-spinner').prop('disabled', false);
                        },
                    });
                }
                $(this).addClass('was-validated');
            });
        });
    </script>
@endpush

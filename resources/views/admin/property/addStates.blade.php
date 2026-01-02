@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add States </li>
                </ol>
                <h6 class="slim-pagetitle">Add States </h6>
            </div>

            <div class="section-wrapper">
                <form id="createstateform" novalidate class="needs-validation">
                    <div class="form-group">
                        <label for="schoolName">State Name <span class="text-danger"></span> </label>
                        <input type="text" class="form-control" id="statename" name="statename"
                            placeholder="Enter State name" required>
                            <div class="invalid-feedback">
                                Please enter a State name.
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="schoolName">State Code <span class="text-danger"></span> </label>
                        <input type="text" class="form-control" id="statecode" name="statecode"
                            placeholder="Enter State Code " required>
                            <div class="invalid-feedback">
                                Please enter a State Code .
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="schoolName">State Status <span class="text-danger"></span> </label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <div class="invalid-feedback">
                            Please enter a State Status.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="schoolName">Zone Time(GMT) </label>
                        <input type="text" class="form-control" id="zonetime" name="zonetime" placeholder="Enter Zone">

                    </div>
                    <div class="form-row justify-content-end">
                        <button type="submit" class="btn btn-primary submit-spinner"> Add States </button>
                    </div>
                </form>
            </div>


            
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            $("#createstateform").submit(function(e) {
                e.preventDefault();

                var url = $(this).data('url');
                if (!this.checkValidity()) {
                    $(this).addClass('was-validated');
                    return;
                }
                
                var stateName = $("#statename").val().trim();
                var stateCode = $("#statecode").val().trim();
                if (stateName === "" || stateCode === "") {
                    toastr.error("State name and state code are required.");
                    return;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin-create-state') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.submit-spinner').html(
                            `<div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>`
                        ).prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.message) {
                            toastr.success(response.message || "State updated successfully.");
                        } else {
                            toastr.error(response.error)
                        }
                        $('.submit-spinner').html(`Add States`).prop('disabled', false);
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                        xhr.responseJSON.error : "An error occurred. Please try again.";
                        toastr.error(errorMessage);
                        $('.submit-spinner').html(`Add States`).prop('disabled', false);
                    },
                });

                $(this).addClass('was-validated');
            });
        });
    </script>
@endpush

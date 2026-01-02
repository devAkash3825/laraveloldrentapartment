@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit States </li>
                </ol>
                <h6 class="slim-pagetitle">Edit States </h6>
            </div>

            <div class="section-wrapper">
                <form id="updatestateform">
                    <input type="hidden" name="stateid" id="stateid" value="{{ $states->Id }}">
                    <div class="form-group">
                        <label for="schoolName">State Name</label>
                        <input type="text" class="form-control" id="statename" name="statename"
                            placeholder="Enter State name" value="{{ $states->StateName }}">
                    </div>
                    <div class="form-group">
                        <label for="schoolName">State Code </label>
                        <input type="text" class="form-control" id="statecode" name="statecode"
                            placeholder="Enter State Code " value="{{ $states->StateCode }}">
                    </div>
                    <div class="form-group">
                        <label for="schoolName">State Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1" {{ $states->status == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $states->status == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="schoolName">Zone Time(GMT) </label>
                        <input type="text" class="form-control" id="zonetime" name="zonetime" placeholder="Enter Zone">
                    </div>
                    <div class="form-row justify-content-end">
                        <button type="submit" class="btn btn-primary submit-spinner ">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            $("#updatestateform").submit(function(e) {
                e.preventDefault();

                var url = $(this).data('url');
                if (!this.checkValidity()) {
                    // If form validation fails
                    $(this).addClass('was-validated');
                    return;
                }

                // Trim and validate state name and code
                var stateName = $("#statename").val().trim();
                var stateCode = $("#statecode").val().trim();
                if (stateName === "" || stateCode === "") {
                    toastr.error("State name and state code are required.");
                    return;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin-update-states') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.submit-spinner').html(
                            `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                        ).prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.message) {
                            toastr.success(response.message || "State updated successfully.");
                        } else {
                            toastr.error(response.error)
                        }
                        $('.submit-spinner').html(`Update`).prop('disabled', false);
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                            xhr.responseJSON.error :
                            "An error occurred. Please try again.";
                        toastr.error(errorMessage);
                        $('.submit-spinner').html(`Update`).prop('disabled', false);
                    },
                });

                $(this).addClass('was-validated');
            });
        });
    </script>
@endpush

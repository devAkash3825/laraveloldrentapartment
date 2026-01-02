@extends('admin/layouts/app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle"> Update Adminstator User
                </h6>
            </div>

            <div class="section-wrapper">
                <form id="editAdminuser" data-url="{{ route('admin-edit-agents', ['id' => $editAdmin->id]) }}">
                    <div class="form-layout form-layout-4">
                        <div class="row">
                            <label class="col-sm-4 form-control-label align-self-center" for="firstname">Full Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    </div>
                                    <input type="text" id="firstname" name="fullname" class="form-control"
                                        value="{{ $editAdmin->admin_name }}" placeholder="Enter Full Name" required>
                                    <span class="text-danger" id="error_firstname"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center" for="title">Title <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-heading"></i></span>
                                    </div>
                                    <input type="text" id="title" name="title" class="form-control"
                                        placeholder="Enter title" value="{{ $editAdmin->title }}">
                                    <span class="text-danger" id="error_title"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center">Email <span
                                    class="text-danger">*</span> </label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    </div>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Enter email address" value="{{ $editAdmin->admin_email }}">
                                    <span class="text-danger" id="error_email"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center" for="company">Company <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-building"></i></span>
                                    </div>
                                    <input type="text" id="company" name="company" class="form-control"
                                        placeholder="Enter company name" value="{{ $editAdmin->company }}">
                                    <span class="text-danger" id="error_company"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center" for="login_id">Username <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
                                    </div>
                                    <input type="text" id="login_id" name="login_id" class="form-control"
                                        placeholder="Enter login ID" value="{{ $editAdmin->admin_login_id }}">
                                    <span class="text-danger" id="error_login_id"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center" for="login_id">Password <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
                                    </div>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Enter login ID" value="{{ $editAdmin->password }}">
                                    <span class="text-danger" id="error_login_id"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center" for="phone">Phone <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="phone" name="phone" type="text" class="form-control"
                                        placeholder="(999) 999-9999" value="{{ $editAdmin->phone }}">
                                </div>
                                <span class="text-danger" id="error_phone"></span>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center" for="twilio_number">Twilio
                                Number</label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="twilio_number" name="twilio_number" type="text" class="form-control"
                                        placeholder="(999) 999-9999" value="{{ $editAdmin->cell }}">
                                </div>
                                <span class="text-danger" id="error_twilio_number"></span>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label align-self-center" for="cell_number">Cell
                                Number</label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input id="cell_number" name="cell_number" type="text" class="form-control"
                                        placeholder="(999) 999-9999" value="{{ $editAdmin->cell }}">
                                </div>
                                <span class="text-danger" id="error_cell_number"></span>
                            </div>
                        </div>

                        @php
                            $cities = App\Models\city::all();
                            $checkedStateIds = $editAdmin->accesses->pluck('admin_state_id')->toArray();
                            $checkedCityIds = $editAdmin->accesses->pluck('admin_city_id')->toArray();
                            $selectedStateCities = $cities
                                ->whereIn('StateId', $checkedStateIds)
                                ->where('status', 1)
                                ->toArray();
                        @endphp

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
                                                        <input type="checkbox" class="edit-state-checkbox"
                                                            value="{{ $row->Id }}" id="editadminstate"
                                                            {{ in_array($row->Id, $checkedCityIds) ? 'checked' : '' }}>
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
                                        <div class="row mt-2">
                                            @foreach ($selectedStateCities as $row)
                                                <div class="col-md-2">
                                                    <label class="ckbox">
                                                        <input type="checkbox" class="edit-state-checkbox"
                                                            value="{{ $row['Id'] }}" id="editadminstate"
                                                            {{ in_array($row['Id'], $checkedCityIds) ? 'checked' : '' }}>
                                                        <span class="font-weight-bold">{{ $row['CityName'] }}</span>
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
                                    <th> Access Rights </th>
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
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="property_addedit"
                                                        {{ $editAdmin->property_addedit == 1 ? 'checked' : '' }}>
                                                    <span class="">Add/Edit Property</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="property_delete"
                                                        {{ $editAdmin->property_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete Property</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="property_active"
                                                        {{ $editAdmin->property_active == 1 ? 'checked' : '' }}>
                                                    <span>Active/Inactive Property</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- User Management Section -->
                                    <div class="section">
                                        <div class="section-title">User Management</div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="user_addedit"
                                                        {{ $editAdmin->user_addedit == 1 ? 'checked' : '' }}>
                                                    <span>Add/Edit User</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="user_delete"
                                                        {{ $editAdmin->user_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete User</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="user_active"
                                                        {{ $editAdmin->user_active == 1 ? 'checked' : '' }}>
                                                    <span>Active/Inactive User</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Featured Company Management Section -->
                                    <div class="section">
                                        <div class="section-title">Featured Company Management</div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="company_addedit"
                                                        {{ $editAdmin->company_addedit == 1 ? 'checked' : '' }}>
                                                    <span>Add/Edit Company</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="company_delete"
                                                        {{ $editAdmin->company_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete Company</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="company_active"
                                                        {{ $editAdmin->company_active == 1 ? 'checked' : '' }}>
                                                    <span>Active/Inactive Company</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Administrator User Management Section -->
                                    <div class="section">
                                        <div class="section-title">Administrator User Management</div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="adminuser_addedit"
                                                        {{ $editAdmin->adminuser_addedit == 1 ? 'checked' : '' }}>
                                                    <span>Add/Edit User</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="adminuser_delete"
                                                        {{ $editAdmin->adminuser_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete User</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Fees Management Section -->
                                    <div class="section">
                                        <div class="section-title">Fees Management</div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="fees_addedit"
                                                        {{ $editAdmin->fees_addedit == 1 ? 'checked' : '' }}>
                                                    <span>Add/Edit Fees</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Notify History Management Section -->
                                    <div class="section">
                                        <div class="section-title">Notify History Management</div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="notify_addedit"
                                                        {{ $editAdmin->notify_addedit == 1 ? 'checked' : '' }}>
                                                    <span>Add/Edit Notify</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="notify_delete"
                                                        {{ $editAdmin->notify_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete Notify</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Content Management Section -->
                                    <div class="section">
                                        <div class="section-title">Content Management</div>
                                        <div class="row mt-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="content_addedit"
                                                        {{ $editAdmin->content_addedit == 1 ? 'checked' : '' }}>
                                                    <span>Add/Edit Content</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="content_delete"
                                                        {{ $editAdmin->content_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete Content</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <div class="section">
                                        <div class="section-title">Call History</div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="call_history_delete"
                                                        {{ $editAdmin->call_history_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete Call History</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Renter Update History Section -->
                                    <div class="section">
                                        <div class="section-title">Renter Update History</div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="renter_update_history_delete"
                                                        {{ $editAdmin->renter_update_history_delete == 1 ? 'checked' : '' }}>
                                                    <span>Delete Renter Update History</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Claim Renter Section -->
                                    <div class="section">
                                        <div class="section-title">Claim Renter</div>
                                        <div class="row mt-3    ">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="renter_claim"
                                                        {{ $editAdmin->renter_claim == 1 ? 'checked' : '' }}>
                                                    <span>Claim Unassigned Renter</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- School Management Section -->
                                    <div class="section">
                                        <div class="section-title">School Management</div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="access_school_management"
                                                        {{ $editAdmin->access_school_management == 1 ? 'checked' : '' }}>
                                                    <span>Access to School Management</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Delete Messages Section -->
                                    <div class="section">
                                        <div class="section-title">Delete Messages</div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="access_delete_message"
                                                        {{ $editAdmin->access_delete_message == 1 ? 'checked' : '' }}>
                                                    <span>Access to Delete Messages</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Access to CSV Export Section -->
                                    <div class="section">
                                        <div class="section-title">Access to CSV Export</div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label class="ckbox">
                                                    <input type="checkbox" class="state-checkbox" value="1"
                                                        name="access_csv_export"
                                                        {{ $editAdmin->access_csv_export == 1 ? 'checked' : '' }}>
                                                    <span>Access to Export CSV</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                                <button class="btn btn-primary bd-0 float-right submit-spinner"> Edit Admin </button>
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
        $("#editAdminuser").on("submit", function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            $.ajax({
                url: url,
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: $(this).serialize(),
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Editing...`
                    )
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        toastr.success(response.message);
                        $("#submitcontactus")[0].reset();
                        $('.submit-spinner').html(`Edit Admin`)
                        $('.submit-spinner').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error("An error occurred. Please try again.");
                    $('.submit-spinner').html(
                        `Edit Admin`
                    )
                    $('.submit-spinner').prop('disabled', false);
                },
            });
        });
    </script>
@endpush

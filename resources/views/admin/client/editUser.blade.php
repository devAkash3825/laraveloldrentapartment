@extends('admin.layouts.app')
@section('title', 'RentApartments Admin | Edit Renter')
@section('content')



<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin-activeRenter') }}">Renters</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Renter</li>
            </ol>
            <h6 class="slim-pagetitle">Edit Renter</h6>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="slim-card-title mb-0">
                    <i class="fa-solid fa-user-edit me-2"></i>
                    Edit Renter: {{ $data->renterinfo->Firstname ?? '' }} {{ $data->renterinfo->Lastname ?? '' }}
                </h6>
            </div>
            <div class="card-body">
                <form id="editRenterForm" action="{{ route('admin-edit-renter-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="userId" value="{{ $userid }}">

                    {{-- Section: Account Information --}}
                    <div class="section-title mb-3">
                        <h6 class="text-primary"><i class="fa-solid fa-user me-2"></i>Account Information</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Assign Agent <span class="text-danger">*</span></label>
                                <select class="form-control @error('editassignAgent') is-invalid @enderror" 
                                        name="editassignAgent" id="editassignAgent" required>
                                    <option value="">Select Agent</option>
                                    @foreach ($admins as $agent)
                                        <option value="{{ $agent->id }}"
                                            {{ old('editassignAgent', $data->renterinfo->added_by ?? '') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->admin_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('editassignAgent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('edituserName') is-invalid @enderror" 
                                       name="edituserName" id="edituserName"
                                       value="{{ old('edituserName', $data->UserName ?? '') }}" required>
                                @error('edituserName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('editemailId') is-invalid @enderror" 
                                       name="editemailId" id="editemailId"
                                       value="{{ old('editemailId', $data->Email ?? '') }}" required>
                                @error('editemailId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Probability (%)</label>
                                <input type="number" class="form-control" name="editprobability" id="editprobability"
                                       min="0" max="100"
                                       value="{{ old('editprobability', $data->renterinfo->probability ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Profile Picture</label>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($data->profile_pic)
                                            <img src="{{ asset('uploads/profile_pics/' . $data->profile_pic) }}" alt="Profile" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('img/temp_profile.png') }}" alt="Profile" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" name="profile_pic" id="profile_pic" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Personal Information --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-id-card me-2"></i>Personal Information</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('editfirstName') is-invalid @enderror" 
                                       name="editfirstName" id="editfirstName"
                                       value="{{ old('editfirstName', $data->renterinfo->Firstname ?? '') }}" required>
                                @error('editfirstName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('editlastName') is-invalid @enderror" 
                                       name="editlastName" id="editlastName"
                                       value="{{ old('editlastName', $data->renterinfo->Lastname ?? '') }}" required>
                                @error('editlastName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Cell Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('editcell') is-invalid @enderror" 
                                       name="editcell" id="editcell"
                                       value="{{ old('editcell', $data->renterinfo->phone ?? '') }}" required>
                                @error('editcell')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Other Phone</label>
                                <input type="tel" class="form-control" name="editotherphone" id="editotherphone"
                                       value="{{ old('editotherphone', $data->renterinfo->Evening_phone ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Section: Location --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-location-dot me-2"></i>Location Details</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">State</label>
                                <select class="form-control select2 state-dropdown" name="editstate" id="editstate" data-city-target="#editcity">
                                    <option value="">Choose State</option>
                                    @foreach ($state ?? [] as $row)
                                        <option value="{{ $row->Id }}"
                                            {{ old('editstate', $data->renterinfo->city->state->Id ?? '') == $row->Id ? 'selected' : '' }}>
                                            {{ $row->StateName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">City</label>
                                <input type="hidden" id="selectedCity" value="{{ old('editcity', $data->renterinfo->Cityid ?? '') }}">
                                <select class="form-control select2" name="editcity" id="editcity">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="text" class="form-control" name="editzipCode" id="editzipCode"
                                       value="{{ old('editzipCode', $data->renterinfo->zipcode ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Move To Area</label>
                                <input type="text" class="form-control" name="editmoveToArea" id="editmoveToArea"
                                       value="{{ old('editmoveToArea', $data->renterinfo->Area_move ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Current Address</label>
                                <textarea class="form-control" name="editcurrentAddress" id="editcurrentAddress" rows="2">{{ old('editcurrentAddress', trim($data->renterinfo->Current_address ?? '')) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Preferences --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-sliders me-2"></i>Preferences</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Bedrooms</label>
                                <select class="form-control" name="editbed" id="editbed">
                                    <option value="">Select</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('editbed', $data->renterinfo->bedroom ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Floor Preference</label>
                                <input type="text" class="form-control" name="editfloorpreference" id="editfloorpreference"
                                       value="{{ old('editfloorpreference', $data->renterinfo->Floor ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Garage Preference</label>
                                <input type="text" class="form-control" name="editgaragePreference" id="editgaragePreference"
                                       value="{{ old('editgaragePreference', $data->renterinfo->Garage ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Laundry Preference</label>
                                <input type="text" class="form-control" name="editlaundryPreference" id="editlaundryPreference"
                                       value="{{ old('editlaundryPreference', $data->renterinfo->Laundry ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Rent Range From ($)</label>
                                <input type="number" class="form-control" name="editdesiredRentRangeFrom" id="editdesiredRentRangeFrom"
                                       value="{{ old('editdesiredRentRangeFrom', $data->renterinfo->Rent_start_range ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Rent Range To ($)</label>
                                <input type="number" class="form-control" name="editdesiredRentRangeTo" id="editdesiredRentRangeTo"
                                       value="{{ old('editdesiredRentRangeTo', $data->renterinfo->Rent_end_range ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Pet Info</label>
                                <input type="text" class="form-control" name="editpetinfo" id="editpetinfo"
                                       value="{{ old('editpetinfo', $data->renterinfo->Pet_weight ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Section: Lease Information --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-file-contract me-2"></i>Lease Information</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">New Rental Address</label>
                                <input type="text" class="form-control" name="new_rental_adddress" id="new_rental_adddress"
                                       value="{{ old('new_rental_adddress', $data->renterinfo->new_rental_adddress ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" name="unit" id="unit"
                                       value="{{ old('unit', $data->renterinfo->unit ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Landlord / Community</label>
                                <input type="text" class="form-control" name="landloard" id="landloard"
                                       value="{{ old('landloard', $data->renterinfo->landloard ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Rent Amount ($)</label>
                                <input type="text" class="form-control" name="rent_amount" id="rent_amount"
                                       value="{{ old('rent_amount', $data->renterinfo->rent_amount ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Lease End Date</label>
                                <input type="date" class="form-control" name="LeaseEndDate" id="LeaseEndDate"
                                       value="{{ old('LeaseEndDate', $data->renterinfo->LeaseEndDate ? date('Y-m-d', strtotime($data->renterinfo->LeaseEndDate)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group mb-3 d-flex align-items-center" style="height: 100%; pt-20">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="ready_to_invoice" id="ready_to_invoice" value="1"
                                        {{ old('ready_to_invoice', $data->renterinfo->ready_to_invoice ?? 0) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-primary fw-bold" for="ready_to_invoice">Ready to Invoice</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Move Dates --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-calendar me-2"></i>Move Dates</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Earliest Move Date</label>
                                <input type="date" class="form-control" name="editearliestMoveDate" id="editearliestMoveDate"
                                       value="{{ old('editearliestMoveDate', $data->renterinfo->Emove_date ? date('Y-m-d', strtotime($data->renterinfo->Emove_date)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Latest Move Date</label>
                                <input type="date" class="form-control" name="editlatestMoveDate" id="editlatestMoveDate"
                                       value="{{ old('editlatestMoveDate', $data->renterinfo->Lmove_date ? date('Y-m-d', strtotime($data->renterinfo->Lmove_date)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Lease Term</label>
                                <input type="text" class="form-control" name="editleaseTerm" id="editleaseTerm"
                                       value="{{ old('editleaseTerm', $data->renterinfo->Lease_Term ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Source</label>
                                <select class="form-control" name="editsource" id="editsource">
                                    <option value="">Select Source</option>
                                    @foreach ($sources ?? [] as $source)
                                        <option value="{{ $source->Id }}"
                                            {{ old('editsource', $data->renterinfo->Hearabout ?? '') == $source->Id ? 'selected' : '' }}>
                                            {{ $source->SourceName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Section: History --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-clock-rotate-left me-2"></i>History</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Credit History</label>
                                <input type="text" class="form-control" name="editcreditHistory" id="editcreditHistory"
                                       value="{{ old('editcreditHistory', $data->renterinfo->Credit_history ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Rental History</label>
                                <input type="text" class="form-control" name="editrentalHistory" id="editrentalHistory"
                                       value="{{ old('editrentalHistory', $data->renterinfo->Rental_history ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Criminal History</label>
                                <input type="text" class="form-control" name="editcriminalHistory" id="editcriminalHistory"
                                       value="{{ old('editcriminalHistory', $data->renterinfo->Criminal_history ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Work Name/Address</label>
                                <input type="text" class="form-control" name="editworkNameAddress" id="editworkNameAddress"
                                       value="{{ old('editworkNameAddress', $data->renterinfo->Work_name_address ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Specific Cross Street</label>
                                <input type="text" class="form-control" name="editspecificCrossStreet" id="editspecificCrossStreet"
                                       value="{{ old('editspecificCrossStreet', $data->renterinfo->Cross_street ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Communities Visited</label>
                                <input type="text" class="form-control" name="editcommunitiesVisited" id="editcommunitiesVisited"
                                       value="{{ old('editcommunitiesVisited', $data->renterinfo->Communities_visited ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Section: Notes --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-note-sticky me-2"></i>Notes & Comments</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Additional Info</label>
                                <textarea class="form-control" name="editadditionalinfo" id="editadditionalinfo" rows="3">{{ old('editadditionalinfo', trim($data->renterinfo->Additional_info ?? '')) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Locator Comments</label>
                                <textarea class="form-control" name="editlocatorcomments" id="editlocatorcomments" rows="3">{{ old('editlocatorcomments', trim($data->renterinfo->Locator_Comments ?? '')) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Tour Info</label>
                                <textarea class="form-control" name="edittourinfo" id="edittourinfo" rows="3">{{ old('edittourinfo', trim($data->renterinfo->Tour_Info ?? '')) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Reminder --}}
                    <div class="section-title mb-3 mt-4">
                        <h6 class="text-primary"><i class="fa-solid fa-bell me-2"></i>Set Reminder</h6>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Reminder Date</label>
                                <input type="date" class="form-control" name="editsetremainderdate" id="editsetremainderdate"
                                       value="{{ old('editsetremainderdate', $data->renterinfo->Reminder_date ? date('Y-m-d', strtotime($data->renterinfo->Reminder_date)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Reminder Time</label>
                                <input type="time" class="form-control" name="editsetremaindertime" id="editsetremaindertime"
                                       value="{{ old('editsetremaindertime', $data->renterinfo->Reminder_date ? date('H:i', strtotime($data->renterinfo->Reminder_date)) : '') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Reminder Note</label>
                                <input type="text" class="form-control" name="editremaindernote" id="editremaindernote"
                                       value="{{ old('editremaindernote', $data->renterinfo->reminder_note ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="form-actions mt-4 pt-3 border-top d-flex justify-content-between">
                        <a href="{{ route('admin-view-profile', ['id' => $userid]) }}" class="btn btn-premium btn-premium-outline-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-premium btn-premium-primary">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('adminscripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#editRenterForm').validate({
        rules: {
            editassignAgent: { required: true },
            edituserName: { required: true, minlength: 3 },
            editemailId: { required: true, email: true },
            editcell: { required: true },
            editfirstName: { required: true, minlength: 2 },
            editlastName: { required: true, minlength: 2 }
        },
        messages: {
            editassignAgent: { required: "Please select an agent" },
            edituserName: { required: "Username is required", minlength: "Username must be at least 3 characters" },
            editemailId: { required: "Email is required", email: "Please enter a valid email" },
            editcell: { required: "Cell phone is required" },
            editfirstName: { required: "First name is required", minlength: "First name must be at least 2 characters" },
            editlastName: { required: "Last name is required", minlength: "Last name must be at least 2 characters" }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2')) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Trigger initial city load for edit mode
    const editState = document.getElementById('editstate');
    if (editState && editState.value) {
        const editCity = document.getElementById('editcity');
        const selectedCityId = document.getElementById('selectedCity').value;
        if (editCity) {
            window.CityStateHandler.loadCities(editState.value, editCity, false).then(() => {
                if (selectedCityId) {
                    editCity.value = selectedCityId;
                    if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
                        jQuery(editCity).trigger('change');
                    }
                }
            });
        }
    }
});
</script>
@endpush

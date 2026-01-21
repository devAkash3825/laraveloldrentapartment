@extends('user.layout.app')
@section('content')
@section('title', 'RentApartments | Dashboard')
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">My Profile</h1>
                <p class="text-white opacity-75 lead mb-0">Manage your account settings and personal information</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">My Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section id="dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="dashboard_content">
                    <div class="my_listing">
                        @if (Auth::guard('renter')->user()->user_type == 'M')
                        <h4> {{ $renterInfo->UserName }} information </h4>
                        @else
                        <h4> {{ $renterInfo->renterinfo->Firstname }} {{ $renterInfo->renterinfo->Lastname }} information</h4>
                        @endif
                        @if (Auth::guard('renter')->user()->user_type == 'M')
                        <form id="editmanagerForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="row">
                                        <div class="col-xl-8 col-md-12">
                                            <div class="row">
                                                <div class="col-xl-12 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="username"><i class="fa-solid fa-user-tag me-2"></i> User Name</label>
                                                        <div class="input_area">
                                                            <input type="text" id="username" name="username"
                                                                placeholder="User Name" value="{{ $renterInfo->UserName }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="email">Email</label>
                                                        <div class="input_area">
                                                            <input type="email" id="email" name="email"
                                                                placeholder="Email" value="{{ $renterInfo->Email }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="my_listing_single">
                                                        <label>About Me</label>
                                                        <div class="input_area">
                                                            <textarea cols="3" rows="3" placeholder="Your Text" name="about_me">{{ $renterInfo->about_me }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-5">
                                            <div class="profile_pic_upload">
                                                @if($renterInfo->profile_pic == '')
                                                <img src="images/user_large_img.jpg" alt="img" class="imf-fluid w-100">
                                                @else
                                                <img src="{{ asset('uploads/profile_pics/'.$renterInfo->profile_pic ) }}" alt="img" class="imf-fluid w-100" style="height:250px !important;">
                                                @endif
                                                <input type="file" name="managerprofile_pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <button type="button" class="read_btn float-right send-btn" id="managerEdit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @else
                        <form id="editUserForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="row">
                                        <div class="col-xl-8 col-md-12">
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="username">User Name</label>
                                                        <div class="input_area">
                                                            <input type="text" id="username" name="username"
                                                                placeholder="User Name" value="{{ $renterInfo->UserName }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="email">Email</label>
                                                        <div class="input_area">
                                                            <input type="email" id="email" name="email"
                                                                placeholder="Email" value="{{ $renterInfo->Email }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="firstname">First Name </label>
                                                        <div class="input_area">
                                                            <input type="text" id="firstname" name="firstname"
                                                                placeholder="First Name"
                                                                value="{{ $renterInfo->renterinfo->Firstname }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lastname">Last Name </label>
                                                        <div class="input_area">
                                                            <input type="text" id="lastname" name="lastname"
                                                                placeholder="Last Name"
                                                                value="{{ $renterInfo->renterinfo->Lastname }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <div class="my_listing_single">
                                                        <label>About Me</label>
                                                        <div class="input_area">
                                                            <textarea cols="3" rows="3" placeholder="Your Text"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-5">
                                            <div class="profile_pic_upload">
                                                @if($renterInfo->profile_pic == '')
                                                <img src="images/user_large_img.jpg" alt="img" class="imf-fluid w-100">
                                                @else
                                                <img src="{{ asset('uploads/profile_pics/'.$renterInfo->profile_pic ) }}" alt="img" class="imf-fluid w-100" style="height:250px !important;">
                                                @endif
                                                <input type="file" name="renterprofile_pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="zipcode">Preferred Zip Code </label>
                                                <div class="input_area">
                                                    <input type="text" id="zipcode" name="zipcode"
                                                        placeholder="Zip Code"
                                                        value="{{ $renterInfo->renterinfo->zipcode }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="cell">Cell </label>
                                                <div class="input_area">
                                                    <input type="text" id="cell" name="cell"
                                                        placeholder="Cell"
                                                        value="{{ $renterInfo->renterinfo->phone }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="other_phone">Other Phone</label>
                                                <div class="input_area">
                                                    <input type="text" id="other_phone" name="other_phone"
                                                        placeholder="Other Phone"
                                                        value="{{ $renterInfo->renterinfo->Evening_phone }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="state">Destination State</label>
                                                <div class="input_area">
                                                    <select
                                                        class="form-control form-select form-control-a state-dropdown"
                                                        name="editstate" id="editstate" data-city-target="#editcity" required>
                                                        @foreach ($state as $row)
                                                        <option value="{{ $row->Id }}"
                                                            {{ $renterInfo->renterinfo->state == $row->Id ? 'selected' : '' }}>
                                                            {{ $row->StateName }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="city">Destination City</label>
                                                <input type="hidden" id="selectedCity"
                                                    value="{{ $renterInfo->renterinfo->Cityid }}">
                                                <div class="input_area">
                                                    <select id="editcity" name="editcity" class="select_2">
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="earliest_move_date">Earliest Move Date</label>
                                                <div class="input_area">
                                                    <input type="date" id="earliest_move_date"
                                                        name="earliest_move_date"
                                                        value="{{ \Carbon\Carbon::parse($renterInfo->renterinfo->Emove_date)->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="latest_move_date">Latest Move Date</label>
                                                <div class="input_area">
                                                    <input type="date" id="latest_move_date"
                                                        name="latest_move_date"
                                                        value="{{ \Carbon\Carbon::parse($renterInfo->renterinfo->Lmove_date)->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="num_bedrooms">Number of Bedrooms </label>
                                                <div class="input_area">
                                                    <select id="num_bedrooms" name="num_bedrooms"
                                                        class="select_2">
                                                        <option value="1"
                                                            {{ $renterInfo->renterinfo->bedroom == 1 ? 'selected' : '' }}>
                                                            1</option>
                                                        <option value="2"
                                                            {{ $renterInfo->renterinfo->bedroom == 2 ? 'selected' : '' }}>
                                                            2</option>
                                                        <option value="3"
                                                            {{ $renterInfo->renterinfo->bedroom == 3 ? 'selected' : '' }}>
                                                            3</option>
                                                        <option value="4"
                                                            {{ $renterInfo->renterinfo->bedroom == 4 ? 'selected' : '' }}>
                                                            4</option>
                                                        <option value="5"
                                                            {{ $renterInfo->renterinfo->bedroom == 5 ? 'selected' : '' }}>
                                                            5</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-md-12">
                                            <div class="my_listing_single">
                                                <label for="moving_to">Moving To </label>
                                                <div class="input_area">
                                                    <textarea id="moving_to" name="moving_to" cols="3" rows="3" placeholder="Your Text">{{ $renterInfo->renterinfo->Area_move }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="hear_about">Hear About </label>
                                                <div class="input_area">
                                                    <select id="hear_about" name="hear_about" class="select_2">
                                                        @foreach ($source as $row)
                                                        <option value="{{ $row->Id }}"
                                                            {{ $renterInfo->renterinfo->Hearabout == $row->Id ? 'selected' : 'sssss' }}>
                                                            {{ $row->SourceName }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="rent_range_from">Desired Rent Range From </label>
                                                <div class="input_area">
                                                    <input type="text" id="rent_range_from"
                                                        name="rent_range_from" placeholder="From"
                                                        value="{{ $renterInfo->renterinfo->Rent_start_range }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="my_listing_single">
                                                <label for="rent_range_to">Desired Rent Range To </label>
                                                <div class="input_area">
                                                    <input type="text" id="rent_range_to" name="rent_range_to"
                                                        placeholder="To"
                                                        value="{{ $renterInfo->renterinfo->Rent_end_range }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-md-12">
                                            <div class="my_listing_single">
                                                <label for="areas_neighborhoods">What area/neighborhoods are you
                                                    wanting to move to? </label>
                                                <div class="input_area">
                                                    <textarea id="areas_neighborhoods" name="areas_neighborhoods" cols="3" rows="3"
                                                        placeholder="Your Text">{{ $renterInfo->renterinfo->areas_neighborhoods }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="button" class="read_btn float-right send-btn" id="renterEdit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Trigger initial city load for dashboard if state is pre-selected
        const editState = document.getElementById('editstate');
        const editCity = document.getElementById('editcity');
        const selectedCityId = document.getElementById('selectedCity')?.value;

        if (editState && editState.value && editCity) {
            window.CityStateHandler.loadCities(editState.value, editCity, false).then(() => {
                if (selectedCityId) {
                    $(editCity).val(selectedCityId).trigger('change');
                }
            });
        }
    });

    $("#renterEdit").on("click", function() {
        var formData = new FormData($("#editUserForm")[0]);
        $.ajax({
            url: "/update-user",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".send-btn").html(
                    ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
                );
                $(".send-btn").prop("disabled", true);
            },
            success: function(response) {
                $(".send-btn").html(`Submit`);
                toastr.success(response.success);
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    window.ValidationHandler.showErrors($("#editUserForm"), xhr.responseJSON.errors);
                } else {
                    toastr.error(xhr.responseJSON?.message || "Something went wrong. Please try again.");
                }
                $("#submitBtn").prop("disabled", false);
            },
            complete: function() {
                $(".send-btn").html(`Submit`);
                $(".send-btn").prop("disabled", false);
            },
        });
    });


    $("#managerEdit").on("click", function() {
        var formData = new FormData($("#editmanagerForm")[0]);

        $.ajax({
            url: "/update-user",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".send-btn").html(
                    ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
                );
                $(".send-btn").prop("disabled", true);
            },
            success: function(response) {
                $(".send-btn").html(`Submit`);
                toastr.success(response.success);
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    window.ValidationHandler.showErrors($("#editmanagerForm"), xhr.responseJSON.errors);
                } else {
                    toastr.error(xhr.responseJSON?.message || "Something went wrong. Please try again.");
                }
                $("#submitBtn").prop("disabled", false);
            },
            complete: function() {
                $(".send-btn").html(`Submit`);
                $(".send-btn").prop("disabled", false);
            },
        });
    });
</script>
@endpush
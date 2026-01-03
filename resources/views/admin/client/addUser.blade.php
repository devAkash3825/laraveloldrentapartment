@extends('admin.layouts.app')
@push('style')
<style>
    .show-password {
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 1rem !important;
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

    input {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush
@section('content')
<div class="slim-mainpanel">
    <div class="container">

        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Renters </li>
            </ol>
            <h6 class="slim-pagetitle">Add Renter</h6>
        </div>

        <div class="section-wrapper">
            <form id="rentersubmitform" novalidate="" action="{{ route('admin-create-renter') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="assignAgent" class="font-weight-bold"> Assign Agent <span class="text-danger"> *
                            </span></label>
                        <select class="form-control" id="assignAgent" name="assignAgent" required>
                            <option value=""> Select Agent </option>
                            @foreach ($agents as $row)
                            <option value="{{ $row->id }}">{{ $row->admin_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="userName" class="font-weight-bold"> User Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="userName" name="userName" required>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="emailId" class="font-weight-bold"> Email ID <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" id="emailId" name="emailId" required>
                    </div>


                    <div class="form-group col-lg-6 col-md-6 col-12">
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
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="password_confirmation" class="font-weight-bold">Confirm Password <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Confirm Password" required>
                            <i class="fa-regular fa-eye toggle-password show-confirm_password"
                                id="toggleConfirmationPassword" style="position: absolute;top:14px;right:10px;"></i>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="cell" class="font-weight-bold"> Cell <span class="text-danger">*</span> </label>
                        <input type="number" class="form-control" id="cell" name="cell" required>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="otherphone" class="font-weight-bold">Other Phone </label>
                        <input type="text" class="form-control" id="otherphone" name="otherphone">
                    </div>

                    <div class="form-group col-lg-3 col-md-2 col-12">
                        <label for="firstName" class="font-weight-bold">First Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="lastName" class="font-weight-bold">Last Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-12">
                        <label for="state" class="font-weight-bold">State <span class="text-danger">*</span>
                        </label>
                        <select class="form-control select2" data-placeholder="Choose State" name="state"
                            id="state">
                            <option label="Choose State"></option>
                            @foreach ($state as $row)
                            <option value="{{ $row->Id }}">
                                {{ $row->StateName }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-12">
                        <label for="city" class="font-weight-bold"> City <span class="text-danger">*</span>
                        </label>
                        <input type="hidden" id="selectedCity">
                        <select class="form-control select2" id="city" name="city">
                            <option>Select City</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-2 col-md-2 col-12">
                        <label for="zipCode" class="font-weight-bold"> Zip Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="zipCode" name="zipCode">
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="currentAddress" class="font-weight-bold"> Moving From <span
                                class="text-danger">*</span> </label>
                        <textarea class="form-control" id="currentAddress" name="currentAddress"> </textarea>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="floorpreference" class="font-weight-bold"> Floor Preference</label>
                        <input type="text" class="form-control" id="floorpreference" name="floorpreference">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="garagePreference" class="font-weight-bold"> Garage Preference</label>
                        <input type="text" class="form-control" id="garagePreference" name="garagePreference">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="laundryPreference" class="font-weight-bold"> Laundry Preference</label>
                        <input type="text" class="form-control" id="laundryPreference" name="laundryPreference">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="specificCrossStreet" class="font-weight-bold"> Specific Cross Street</label>
                        <input type="text" class="form-control" id="specificCrossStreet"
                            name="specificCrossStreet">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="communitiesVisited" class="font-weight-bold"> Communities Visited </label>
                        <input type="text" class="form-control" id="communitiesVisited"
                            name="communitiesVisited">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="creditHistory" class="font-weight-bold"> Credit History</label>
                        <input type="text" class="form-control" id="creditHistory" name="creditHistory">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="rentalHistory" class="font-weight-bold"> Rental History</label>
                        <input type="text" class="form-control" id="rentalHistory" name="rentalHistory">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="criminalHistory" class="font-weight-bold"> Criminal History</label>
                        <input type="text" class="form-control" id="criminalHistory" name="criminalHistory">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="leaseTerm" class="font-weight-bold"> Lease Term</label>
                        <input type="text" class="form-control" id="leaseTerm" name="leaseTerm">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="earliestMoveDate" class="font-weight-bold"> Earliest Move Date</label>
                        <input type="date" class="form-control" id="earliestMoveDate" name="earliestMoveDate">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="latestMoveDate" class="font-weight-bold">Latest Move Date</label>
                        <input type="date" class="form-control" id="latestMoveDate" name="latestMoveDate">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-12">
                        <label for="workNameAddress" class="font-weight-bold">Work Name/Address</label>
                        <input type="text" class="form-control" id="workNameAddress" name="workNameAddress">
                    </div>

                    <div class="form-group col-lg-4 col-md-4 col-12">
                        <label for="moveToArea" class="font-weight-bold">What area are you wanting to move
                            to?/Other</label>
                        <input type="text" class="form-control" id="moveToArea" name="moveToArea">
                    </div>

                    <div class="form-group col-lg-4 col-md-4 col-12">
                        <label for="desiredRentRangeFrom" class="font-weight-bold">Desired Rent Range From</label>
                        <input type="number" class="form-control" id="desiredRentRangeFrom" name="desiredRentRangeFrom">
                    </div>

                    <div class="form-group col-lg-4 col-md-4 col-12">
                        <label for="desiredRentRangeTo" class="font-weight-bold">Desired Rent Range To</label>
                        <input type="number" class="form-control" id="desiredRentRangeTo"
                            name="desiredRentRangeTo">
                    </div>

                    <div class="form-group col-lg-3 col-md-4 col-12">
                        <label for="source" class="font-weight-bold">Select Source </label>
                        <select class="form-control" id="source" name="source">
                            <option value="">Select Source </option>
                            @foreach ($sources as $source)
                            <option value="{{ $source->Id }}">
                                {{ $source->SourceName }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-3 col-md-4 col-12">
                        <label for="bed" class="font-weight-bold">No of Bedroom</label>
                        <select class="form-control" id="bedroom" name="bedroom">
                            <option value="">Select Bedroom</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-3 col-md-4 col-12">
                        <label for="petinfo" class="font-weight-bold">Pet Info</label>
                        <input type="text" class="form-control" id="petinfo" name="petinfo">
                    </div>

                    <div class="form-group col-lg-3 col-md-4 col-12">
                        <label for="probability" class="font-weight-bold">Probability (%) </label>
                        <input type="number" class="form-control" id="probability" name="probability">
                    </div>


                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="additionalinfo" class="font-weight-bold"> Additional Info </label>
                        <textarea class="form-control" id="additionalinfo" name="additionalinfo">  </textarea>
                    </div>

                    <div class="form-group col-md-12 col-md-6 col-12">
                        <label for="locatorcomments" class="font-weight-bold"> Locator Comments </label>
                        <textarea class="form-control" id="locatorcomments" name="locatorcomments"></textarea>
                    </div>

                    <div class="form-group col-md-12 col-md-6 col-12">
                        <label for="tourinfo" class="font-weight-bold"> Tour Info </label>
                        <textarea class="form-control" id="tourinfo" name="tourinfo"></textarea>
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="remaindernote" class="font-weight-bold">Set Reminder</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="setremainderdate" name="setremainderdate"
                                value="">
                            <input type="time" class="form-control" id="setremaindertime" name="setremaindertime"
                                value="">
                        </div>
                    </div>

                    <div class="form-group col-md-12 col-md-6 col-12">
                        <label for="remaindernote" class="font-weight-bold"> Reminder Note </label>
                        <textarea class="form-control" id="remaindernote" name="remaindernote"></textarea>
                    </div>

                </div>
                <div class="form-row justify-content-end mg-t-20">
                    <button type="submit" class="btn btn-primary btn-premium submit-spinner px-4">Add Renter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script>
    $(document).ready(function() {
        $('#rentersubmitform').validate({
            errorClass: "error",
            validClass: "is-valid",
            rules: {
                assignAgent: {
                    required: true
                },
                userName: {
                    required: true
                },
                emailId: {
                    required: true,
                    email: true
                },
                firstName: {
                    required: true,
                    maxlength: 255
                },
                lastName: {
                    required: true,
                    maxlength: 255
                },
                cell: {
                    required: true,
                    maxlength: 15,
                    digits: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                assignAgent: {
                    required: "Assign Agent is required."
                },
                userName: {
                    required: "User Name is required."
                },
                emailId: {
                    required: "Valid email is required.",
                    email: "Please enter a valid email address."
                },
                firstName: {
                    required: "First Name is required."
                },
                lastName: {
                    required: "Last Name is required."
                },
                cell: {
                    required: "Cell Number is required.",
                    digits: "Cell number must contain only numeric digits."
                },
                password: {
                    required: "Password is required."
                },
                password_confirmation: {
                    required: "Confirm password.",
                    equalTo: "Passwords do not match."
                },
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
            submitHandler: function(form, event) {
                event.preventDefault();
                FormHelpers.submit($(form), {
                    success: function(response) {
                        AdminToast.success(response.message || "Renter created successfully!");
                        setTimeout(() => {
                            window.location.href = "{{ route('admin-activeRenter') }}";
                        }, 1500);
                    }
                });
            }
        });

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


        $("#state").on("change", function() {
            let stateId = $(this).val();
            let citySelect = $("#city");
            citySelect.empty();
            citySelect.append('<option value="">Select City</option>');
            if (stateId) {
                let url = "{{ route('admin-get-cities', ['state_id' => ':state_id']) }}".replace(
                    ':state_id', stateId);
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        if (Array.isArray(data) && data.length > 0) {
                            $.each(data, function(key, city) {
                                citySelect.append(
                                    '<option value="' + city.Id + '">' + city
                                    .CityName +
                                    "</option>"
                                );
                            });

                            let selectedCity = $("#selectedCity").val();
                            if (selectedCity) {
                                citySelect.val(selectedCity);
                            }
                        } else {
                            citySelect.append('<option> No cities available </option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching cities:", error);
                        alert("Failed to fetch cities. Please try again.");
                    },
                });
            }
        });
        $("#state").trigger("change");
    });
</script>
@endpush
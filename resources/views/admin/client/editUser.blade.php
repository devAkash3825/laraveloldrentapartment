@extends('admin.layouts.app')
@section('content')
    <style>
        .show-password {
            cursor: pointer;
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
                    <li class="breadcrumb-item active" aria-current="page"> {{ $pageTitle }} </li>
                </ol>
                <h6 class="slim-pagetitle">Edit Renter</h6>
            </div>


            <div class="section-wrapper">
                <form id="editrenterform" action="{{ route('admin-edit-renter-update') }}" method="POST" novalidate>
                    @csrf
                    <div class="form-row">

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <input type="hidden" class="form-control" id="userId" name="userId"
                                value="{{ $userid }}" required>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-12">
                            <label for="editassignAgent" class="font-weight-bold"> Assign Agent <span
                                    class="text-danger">*</span> </label>
                            <select class="form-control" id="editassignAgent" name="editassignAgent" required>
                                <option value=""> Select Agent </option>
                                @foreach ($admins as $agent)
                                    <option value="{{ $agent->id }}"
                                        {{ @$data->renterinfo->added_by == $agent->id ? 'selected' : '' }}>
                                        {{ @$agent->admin_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="edituserName" class="font-weight-bold"> User Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edituserName" name="edituserName"
                                value="{{ $data->UserName }}" required>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="emailId" class="font-weight-bold"> Email ID <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="editemailId" name="editemailId"
                                value="{{ $data->Email }}" required>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="editcell" class="font-weight-bold"> Cell <span class="text-danger">*</span> </label>
                            <input type="number" class="form-control" id="editcell" name="editcell"
                                value="{{ @$data->renterinfo->phone }}">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-12">
                            <label for="editotherphone" class="font-weight-bold">Other Phone </label>
                            <input type="text" class="form-control" id="editotherphone" name="editotherphone"
                                value="{{ @$data->renterinfo->Evening_phone }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-2 col-12">
                            <label for="editfirstName" class="font-weight-bold">First Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editfirstName" name="editfirstName"
                                value="{{ @$data->renterinfo->Firstname }}" required>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editlastName" class="font-weight-bold">Last Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editlastName" name="editlastName"
                                value="{{ @$data->renterinfo->Lastname }}" required>
                        </div>

                        <div class="form-group col-lg-2 col-md-2 col-12">
                            <label for="state" class="font-weight-bold">State <span class="text-danger">*</span> </label>
                            <select class="form-control select2" data-placeholder="Choose State" name="editstate"
                                id="editstate" >
                                <option label="Choose State"></option>
                                @foreach ($state as $row)
                                    <option value="{{ $row->Id }}"
                                        {{ @$data->renterinfo->city->state->Id == $row->Id ? 'selected' : '' }}>
                                        {{ @$row->StateName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-2 col-md-2 col-12">
                            <label for="city" class="font-weight-bold"> City <span class="text-danger">*</span>
                            </label>
                            <input type="hidden" id="selectedCity" value="{{ @$data->renterinfo->Cityid }}">
                            <select class="form-control select2" id="editcity" name="editcity">
                                <option value="">Select City</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-2 col-md-2 col-12">
                            <label for="editzipCode" class="font-weight-bold"> Zip Code <span
                                    class="text-danger">*</span> </label>
                            <input type="text" class="form-control" id="editzipCode" name="editzipCode"
                                value="{{ @$data->renterinfo->zipcode }}" >
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-12">
                            <label for="editcurrentAddress" class="font-weight-bold"> Current Address <span
                                    class="text-danger">*</span> </label>
                            <textarea class="form-control" id="editcurrentAddress" name="editcurrentAddress" > {{ @$data->renterinfo->Current_address }} </textarea>
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editgaragePreference" class="font-weight-bold"> Floor Preference</label>
                            <input type="text" class="form-control" id="editfloorpreference"
                                name="editfloorpreference" value="{{ @$data->renterinfo->Floor }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editgaragePreference" class="font-weight-bold"> Garage Preference</label>
                            <input type="text" class="form-control" id="editgaragePreference"
                                name="editgaragePreference" value="{{ @$data->renterinfo->Garage }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editlaundryPreference" class="font-weight-bold"> Laundry Preference</label>
                            <input type="text" class="form-control" id="editlaundryPreference"
                                name="editlaundryPreference" value="{{ @$data->renterinfo->Laundry }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editspecificCrossStreet" class="font-weight-bold"> Specific Cross Street</label>
                            <input type="text" class="form-control" id="editspecificCrossStreet"
                                name="editspecificCrossStreet" value="{{ @$data->renterinfo->Cross_street }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editcommunitiesVisited" class="font-weight-bold"> Communities Visited</label>
                            <input type="text" class="form-control" id="editcommunitiesVisited"
                                name="editcommunitiesVisited" value="{{ @$data->renterinfo->Communities_visited }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editcreditHistory" class="font-weight-bold"> Credit History</label>
                            <input type="text" class="form-control" id="editcreditHistory" name="editcreditHistory"
                                value="{{ @$data->renterinfo->Credit_history }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editrentalHistory" class="font-weight-bold"> Rental History</label>
                            <input type="text" class="form-control" id="editrentalHistory" name="editrentalHistory"
                                value="{{ @$data->renterinfo->Rental_history }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editcriminalHistory" class="font-weight-bold"> Criminal History</label>
                            <input type="text" class="form-control" id="editcriminalHistory"
                                name="editcriminalHistory" value="{{ @$data->renterinfo->Criminal_history }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="editleaseTerm" class="font-weight-bold"> Lease Term</label>
                            <input type="text" class="form-control" id="editleaseTerm" name="editleaseTerm"
                                value="{{ @$data->renterinfo->Lease_Term }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="earliestMoveDate" class="font-weight-bold"> Earliest Move Date</label>
                            <input type="date" class="form-control" id="editearliestMoveDate"
                                name="editearliestMoveDate"
                                value="{{ date('Y-m-d', strtotime(@$data->renterinfo->Emove_date)) }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="latestMoveDate" class="font-weight-bold">Latest Move Date</label>
                            <input type="date" class="form-control" id="editlatestMoveDate" name="editlatestMoveDate"
                                value="{{ date('Y-m-d', strtotime(@$data->renterinfo->Lmove_date)) }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-12">
                            <label for="workNameAddress" class="font-weight-bold">Work Name/Address</label>
                            <input type="text" class="form-control" id="editworkNameAddress"
                                name="editworkNameAddress" value="{{ @$data->renterinfo->Work_name_address }}">
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-12">
                            <label for="moveToArea" class="font-weight-bold">What area are you wanting to move to?
                                /Other</label>
                            <input type="text" class="form-control" id="editmoveToArea" name="editmoveToArea"
                                value="{{ @$data->renterinfo->Area_move }}">
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-12">
                            <label for="editdesiredRentRangeFrom" class="font-weight-bold">Desired Rent Range From</label>
                            <input type="text" class="form-control" id="editdesiredRentRangeFrom"
                                name="editdesiredRentRangeFrom" value="{{ @$data->renterinfo->Rent_start_range }}">
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-12">
                            <label for="editdesiredRentRangeTo" class="font-weight-bold">Desired Rent Range To</label>
                            <input type="text" class="form-control" id="editdesiredRentRangeTo"
                                name="editdesiredRentRangeTo" value="{{ @$data->renterinfo->Rent_end_range }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-4 col-12">
                            <label for="editsource" class="font-weight-bold">Select Source </label>
                            <select class="form-control" id="editsource" name="editsource">
                                <option value="">Select Source </option>
                                @foreach ($sources as $source)
                                    <option value="{{ $row->Id }}"
                                        {{ @$data->renterinfo->Hearabout == $source->Id ? 'selected' : '' }}>
                                        {{ @$source->SourceName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-4 col-12">
                            <label for="editbed" class="font-weight-bold">No of Bedroom</label>
                            <select class="form-control" id="editbed" name="editbed">
                                <option value="">Select Bedroom</option>
                                <option value="1" {{ @$data->renterinfo->bedroom == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ @$data->renterinfo->bedroom == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ @$data->renterinfo->bedroom == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ @$data->renterinfo->bedroom == 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ @$data->renterinfo->bedroom == 5 ? 'selected' : '' }}>5</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-4 col-12">
                            <label for="editpetinfo" class="font-weight-bold">Pet Info</label>
                            <input type="text" class="form-control" id="editpetinfo" name="editpetinfo"
                                value="{{ @$data->renterinfo->Pet_weight }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-4 col-12">
                            <label for="editprobability" class="font-weight-bold">Probability (%)</label>
                            <input type="text" class="form-control" id="editprobability" name="editprobability"
                                value="{{ @$data->renterinfo->probability }}">
                        </div>


                        <div class="form-group col-lg-12 col-md-12 col-12">
                            <label for="editadditionalinfo" class="font-weight-bold"> Additional Info</label>
                            <textarea class="form-control" id="editadditionalinfo" name="editadditionalinfo"> {{ @$data->renterinfo->Additional_info }} </textarea>
                        </div>



                        <div class="form-group col-md-12 col-md-6 col-12">
                            <label for="editlocatorcomments" class="font-weight-bold"> Locator Comments </label>
                            <textarea class="form-control" id="editlocatorcomments" name="editlocatorcomments">{{ @$data->renterinfo->Locator_Comments }}</textarea>
                        </div>

                        <div class="form-group col-md-12 col-md-6 col-12">
                            <label for="edittourinfo" class="font-weight-bold"> Tour Info </label>
                            <textarea class="form-control" id="tourinfo" name="edittourinfo">{{ @$data->renterinfo->Tour_Info }}</textarea>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-12">
                            <label for="remaindernote" class="font-weight-bold">Set Remainder</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="editsetremainderdate"
                                    name="editsetremainderdate" value="{{ date('Y-m-d', strtotime(@$data->renterinfo->Reminder_date)) }}">
                                <input type="time" class="form-control" id="editsetremaindertime"
                                    name="editsetremaindertime" value="{{ date('H:i', strtotime(@$data->renterinfo->Reminder_date)) }}">
                            </div>
                        </div>

                        <div class="form-group col-md-12 col-md-6 col-12">
                            <label for="workNameAddress" class="font-weight-bold"> Reminder Note</label>
                            <textarea class="form-control" id="remaindernote" name="editremaindernote">{{ @$data->renterinfo->reminder_note }}</textarea>
                        </div>

                    </div>
                    <div class="form-row justify-content-end mg-t-20">
                        <button type="submit" class="btn btn-primary btn-premium submit-spinner px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {

            $.validator.addMethod(
                "pwcheck",
                function(value) {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/.test(value);
                },
                "Password must include at least one uppercase letter, one lowercase letter, and a number."
            );
            $('#editrenterform').validate({
                errorClass: "error",
                validClass: "is-valid",
                rules: {
                    editassignAgent: {
                        required: true
                    },
                    edituserName: {
                        required: true
                    },
                    editemailId: {
                        required: true,
                        email: true
                    },
                    editfirstName: {
                        required: true,
                        maxlength: 255
                    },
                    editlastName: {
                        required: true,
                        maxlength: 255
                    },
                    editcell: {
                        required: true,
                        maxlength: 15,
                        digits: true
                    },
                    editcurrentAddress: {
                        required: true,
                        maxlength: 255
                    },
                    editstate: {
                        required: true
                    },
                    editcity: {
                        required: true
                    },
                    editzipCode: {
                        required: true
                    }
                },
                messages: {
                    editassignAgent: {
                        required: "Assign Agent is required."
                    },
                    edituserName: {
                        required: "User Name is required."
                    },
                    // password: {
                    //     required: "Password is required.",
                    // },
                    editemailId: {
                        required: "Valid email is required.",
                        email: "Please enter a valid email address."
                    },
                    editfirstName: {
                        required: "First Name is required."
                    },
                    editlastName: {
                        required: "Last Name is required."
                    },
                    editcell: {
                        required: "Cell Number is required.",
                        digits: "Cell number must contain only numeric digits."
                    },
                    editcurrentAddress: {
                        required: "Current Address is required."
                    },
                    editstate: {
                        required: "State is required."
                    },
                    editcity: {
                        required: "City is required."
                    },
                    editzipCode: {
                        required: "Zip Code is required."
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
                submitHandler: function(form, event) {
                    event.preventDefault();
                    FormHelpers.submit($(form), {
                        success: function(response) {
                            if (response.success) {
                                setTimeout(() => {
                                    window.location.href = "{{ route('admin-activeRenter') }}";
                                }, 1500);
                            }
                        }
                    });
                }
            });



            $("#editstate").on("change", function() {
                let stateId = $(this).val();
                let citySelect = $("#editcity");
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
                                        '<option value="' +
                                        city.Id +
                                        '">' +
                                        city.CityName +
                                        "</option>"
                                    );
                                });

                                let selectedCity = $("#selectedCity").val();
                                if (selectedCity) {
                                    citySelect.val(selectedCity);
                                }
                            } else {
                                citySelect.append(
                                    '<option value="">No cities available</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching cities:", error);
                            alert("Failed to fetch cities. Please try again.");
                        },
                    });
                }
            });
            $("#editstate").trigger("change");

            $(".show-password").on("click", function() {
                const passwordField = $("#password");
                const type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);
                $(this).toggleClass("fa-eye fa-eye-slash");
            });
        });
    </script>
@endpush

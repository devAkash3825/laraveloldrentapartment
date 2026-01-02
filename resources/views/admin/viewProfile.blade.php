@extends('admin.layouts.app')
@section('content')
<style>
    .invoice-info-row:hover {
        background-color: #f3f3f3;
        cursor: pointer;
    }

    .tabs {
        display: flex;
        justify-content: space-around;
        margin-bottom: 10px;
    }

    .tab-button {
        background-color: #f1f1f1;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .tab-button:hover {
        background-color: #ddd;
    }

    .tab-button.active {
        background-color: #ccc;
    }

    .tab-content {
        display: none;
        border: 1px solid #ddd;
        border-top: none;
    }

    .tab-content.active {
        display: block;
    }

    .tab-button.active a {
        background: #1b84e7;
        color: white;
    }

    .remainder-box-container {
        position: relative;
        background: #f3f3f3;
        z-index: 9999;
    }
</style>
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Profile </li>
            </ol>
            <h6 class="slim-pagetitle">View Profile of {{ @$data->renterInfo->Firstname }}
                {{ @$data->renterInfo->Lastname }}
            </h6>
        </div>

        <div class="row row-sm">
            <div class="col-lg-8">
                <div class="card card-profile">
                    <div class="card-body">
                        <div class="media">
                            <img src="{{ $data->profile_pic ? asset('uploads/profile_pics/' . $data->profile_pic) : asset('img/no-img.jpg') }}"
                                alt="Profile Picture">
                            <div class="media-body ml-3">
                                <h3 class="card-profile-name">
                                    {{ @$data->renterInfo->Firstname ?? 'N/A' }}
                                    {{ @$data->renterInfo->Lastname ?? '' }}
                                </h3>
                                <p class="invoice-info-row">
                                    <span class="font-weight-bold">Agent Name</span>
                                    <span>{{ @$data->renterInfo->admindetails->admin_name ?? 'N/A' }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span class="font-weight-bold">Email</span>
                                    <span>{{ @$data->Email ?? 'N/A' }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span class="font-weight-bold">Tel No</span>
                                    <span>{{ @$data->renterInfo->phone ?? 'N/A' }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span class="font-weight-bold">City, State, Zip</span>
                                    <span>
                                        <a href="">
                                            {{ @$data->renterInfo->city->CityName ?? 'N/A' }},
                                            {{ @$data->renterInfo->city->state->StateName ?? 'N/A' }}
                                        </a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer justify-content-start mx-auto">
                        <div>
                            <a href="{{ route('admin-edit-renter', ['id' => $data->Id]) }}">Add Lease</a>
                            <a href="{{ route('admin-edit-renter', ['id' => $data->Id]) }}">Change Inactive</a>
                            <a href="javascript:void(0)" class="set-remainder" data-id="{{ $data->Id }}">Set
                                Reminder</a>
                            <a href="{{ route('admin-edit-renter', ['id' => $data->Id]) }}">Edit Profile</a>
                            <a href="{{ route('admin-map-view', ['id' => $data->Id]) }}">Switch To Map View</a>
                        </div>
                    </div>

                    <div class="container remainder-box-container p-4" id="remainder-box-{{ $data->Id }}"
                        style="display:none;">
                        <div class="remainder-box mt-2 border p-4 shadow-lg">
                            <form action="" id="set-remainder-form" data-url="{{ route('admin-set-remainder', ['id' => $data->Id]) }}">
                                <div class="form-row">

                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <label for="remaindernote" class="font-weight-bold">Set Remainder</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="setremainderdate" name="setremainderdate" value="{{ date('Y-m-d', strtotime(@$data->renterinfo->Reminder_date)) }}">
                                            <input type="time" class="form-control" id="setremaindertime" name="setremaindertime" value="{{ date('H:i', strtotime(@$data->renterinfo->Reminder_date)) }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 col-md-6 col-12">
                                        <label for="remaindernote" class="font-weight-bold"> Reminder Note </label>
                                        <textarea class="form-control" id="remaindernote" name="remaindernote"> {{@$data->renterinfo->reminder_note}}</textarea>
                                    </div>

                                    <input type="hidden" value="{{ $data->Id }}" name="userid">
                                </div>
                                <button class="btn btn-primary mt-2 btn-send-message submit-spinner" type="submit">Set Remainder
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card card-profile">
                    <div class="media px-4 py-2 mt-1">
                        <div class="media-body">
                            <div class="row mx-auto">
                                <div class="col-md-6">
                                    @foreach ([
                                    'Created On' => $data->formatted_created_on ?? 'N/A',
                                    'Status' => $data->Status == '1' ? 'Active' : 'Inactive',
                                    'User Type' => $data->user_type == 'C' ? 'Renter' : 'Manager',
                                    'User IP' => $data->UserIp ?? 'N/A',
                                    'Garage Preference' => $data->renterInfo->Garage ?? 'N/A',
                                    'Specific Cross Street' => $data->renterInfo->Cross_street ?? 'N/A',
                                    'Credit History' => $data->renterInfo->Credit_history ?? 'N/A',
                                    'Criminal History' => $data->renterInfo->Criminal_history ?? 'N/A',
                                    'Rental History' => $data->renterInfo->Rental_history ?? 'N/A',
                                    'Locator Comments' => $data->renterInfo->Locator_Comments ?? 'N/A',
                                    'Laundry Preference' => $data->renterInfo->Laundry ?? 'N/A',
                                    'Communities Visited' => $data->renterInfo->Communities_visited ?? 'N/A',
                                    'Tour Info' => $data->renterInfo->Tour_Info ?? 'N/A',
                                    'Time to Reach' => $data->renterInfo->Timetoreach ?? 'N/A',
                                    ] as $label => $value)
                                    <p class="invoice-info-row">
                                        <span class="font-weight-bold">{{ $label }}</span>
                                        <span>{{ $value }}</span>
                                    </p>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    @foreach ([
                                    'Modified On' => $data->formatted_modified_on ?? 'N/A',
                                    'Floor Preference' => $data->renterInfo->Floor ?? 'N/A',
                                    'Lease Term' => $data->renterInfo->Lease_Term ?? 'N/A',
                                    'Rent Range' => 'From ' . ($data->renterInfo->Rent_start_range ?? 'N/A') . ' to ' . ($data->renterInfo->Rent_end_range ?? 'N/A'),
                                    'No. of Bedrooms' => $data->renterInfo->bedroom ?? 'N/A',
                                    'Pet Info' => $data->renterInfo->Pet_weight ?? 'N/A',
                                    'Additional Information' => $data->renterInfo->Additional_info ?? 'N/A',
                                    'Earliest Move In Date' => $data->renterInfo->formatted_emove_date ?? 'N/A',
                                    'Latest Move In Date' => $data->renterInfo->formatted_lmove_date ?? 'N/A',
                                    'Reminder Date' => $data->renterInfo->Reminder_date ?? 'N/A',
                                    'Area to Move' => $data->renterInfo->Area_move ?? 'N/A',
                                    'Reminder Time' => $data->renterInfo->Reminder_time ?? 'N/A',
                                    'Probability (%)' => $data->renterInfo->probability ?? 'N/A',
                                    'Reminder Note' => $data->renterInfo->reminder_note ?? 'N/A',
                                    ] as $label => $value)
                                    <p class="invoice-info-row">
                                        <span class="font-weight-bold">{{ $label }}</span>
                                        <span>{{ $value }}</span>
                                    </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                <div class="card card-people-list">
                    <div class="slim-card-title">Recently Viewed Property</div>
                    <div class="media-list">
                        @forelse ($recentviewed as $prop)
                        <div class="media">

                            @if ($prop->propertyinfo)
                            <img src="{{ $prop->propertyinfo->getFirstImageUrl() }}" alt="Property Image"
                                onerror="this.onerror=null; this.src='https://your-default-image-url.com/default.jpg';">
                            @else
                            <img src="https://your-default-image-url.com/default.jpg" alt="Default Image">
                            @endif
                            <div class="media-body">
                                @if ($prop->propertyinfo)
                                <a
                                    href="{{ route('admin-property-display', ['id' => $prop->propertyinfo->Id]) }}">
                                    {{ $prop->propertyinfo->PropertyName ?? 'Unnamed Property' }}
                                </a>
                                <p class="mt-1">
                                    {{ $prop->lastviewed ? $prop->lastviewed->format('Y-m-d') : 'Date Unavailable' }}
                                </p>
                                @else
                                <span>No property information available</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-center">No recently viewed properties available.</p>
                        @endforelse
                    </div>
                </div>
            </div>




            <div class="col-lg-12 mg-t-20 mg-lg-t-0">

                <ul class="nav nav-activity-profile nav-pills-a nav-pills mg-t-20" id="pills-tab" role="tablist">
                    <li class="nav-item tab-button" data-tab="favoritetab">
                        <a class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Favorite Listing</a>
                    </li>
                    <li class="nav-item tab-button" data-tab="inquirytab">
                        <a class="nav-link"><i class="icon ion-ios-redo tx-purple"></i>Inquiry History </a>
                    </li>
                </ul>

                <div id="favoritetab" class="tab-content" data-id="{{ $data->Id }}">
                    <div class="card card-latest-activity mg-t-20 active" role="tabpanel">
                        <div class="card-body">
                            <div class="table-responsive mt-4 ">
                                <table class="table table-hover mg-b-0" id="">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Property Name </th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Action</th>
                                            <th>Note</th>
                                            <th>Notify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($favoritePropertieslist as $property)
                                        <tr>
                                            <td class="p-3">{{ $loop->iteration }}</td>
                                            <td class="align-content-center py-1">
                                                <a href="{{ route('admin-property-display', ['id' => $property['id']]) }}" class="font-weight-bold"> {{ $property['propertyname'] }} </a>
                                            </td>
                                            <td class="align-content-center">{{ $property['city'] }}</td>
                                            <td class="align-content-center">{{ $property['state'] }}</td>
                                            <td class="align-content-center">
                                                <div class="table-actionss-icon table-actions-icons float-left">
                                                    <a href="{{ route('admin-edit-property', ['id' => $property['id']]) }}" class="edit-btn">
                                                        <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="">
                                                        <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-content-center">
                                                <div class="form-group col-md-12 d-flex mb-0">
                                                    <a type="javascript:void(0)"
                                                        href="{{ route('admin-get-messages', ['rid' => $data['Id'], 'pid' => $property['id']]) }}"
                                                        class="btn btn-primary float-right btn-sm text-white "
                                                        data-id="{{ $property['id'] }}"
                                                        data-renterid="{{ $data->Id }}"> Notes </a>
                                                </div>
                                            </td>
                                            <td class="align-content-center">
                                                <div class="form-group col-md-12 d-flex mb-0">
                                                    @php
                                                    $authId = Auth::guard('admin')->user()->id ?? null;
                                                    $notified = App\Models\Message::where(
                                                    'propertyId',
                                                    $property['id'] ?? null,
                                                    )
                                                    ->where('renterId', $data->Id ?? null)
                                                    ->where('adminId', $authId)
                                                    ->first();
                                                    @endphp
                                                    @if (isset($notified) && $notified->notify_manager)
                                                    <button class="btn btn-secondary disabled btn-sm"> Notified
                                                    </button>
                                                    @else
                                                    <button
                                                        class="btn btn-primary float-right btn-sm text-white"
                                                        data-id="{{ $property['id'] }}"
                                                        data-renterid="{{ $data->Id }}"
                                                        id="notify-manager" onclick="notifyManager(this)">
                                                        Notify
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="inquirytab" class="tab-content" data-id="{{ $data->Id }}">
                    <div class="card card-latest-activity mg-t-20 active" role="tabpanel">
                        <div class="card-body">
                            <div class="slim-card-title">Property Inquiry History</div>
                            <div class="table-responsive mt-4">
                                <table class="table table-hover mg-b-0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name of Property</th>
                                            <th>Inquiry Date</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($propertyInquiry) > 0)
                                        @foreach ($propertyInquiry as $inquiry)
                                        <tr>
                                            <td class="p-3">{{ $loop->iteration }}</td>
                                            <td class="align-content-center py-1">
                                                <a href="#" class="font-weight-bold">
                                                    {{ $inquiry->propertyinfo->PropertyName ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td class="align-content-center py-1">
                                                <a href="#" class="font-weight-bold">
                                                    {{ $inquiry->CreatedOn ? $inquiry->CreatedOn->format('Y-m-d') : 'Not Available' }}
                                                </a>
                                            </td>
                                            <td class="align-content-center py-1">
                                                <a href="#" class="font-weight-bold">
                                                    {{ $inquiry->respond_time ?? 'No Response Yet' }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4" class="text-center">No Records Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.set-remainder', function() {
            var id = $(this).data('id');
            $('#remainder-box-' + id).toggle();
        });

        $("#set-remainder-form").submit(function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            console.log('url', url);
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
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Set Remainder...`
                    )
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        $('.submit-spinner').html(`Set Remainder`);
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
                    $('.submit-spinner').html(`Set Remainder`);
                    $('.submit-spinner').prop('disabled', false);
                },
                complete: function() {
                    $('.submit-spinner').html(`Set Remainder`);
                    $('.submit-spinner').prop('disabled', false);
                },
            });

            $(this).addClass('was-validated');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        function openTab(tabName) {
            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });
            document.getElementById(tabName).classList.add('active');
            document.querySelector(`.tab-button[data-tab="${tabName}"]`).classList.add('active');
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                openTab(this.getAttribute('data-tab'));
            });
        });
        openTab('favoritetab');
    });

    function notifyManager(e) {
        const propertyId = e.getAttribute('data-id');
        const renterId = e.getAttribute('data-renterid');
        const url = "{{ route('notify-manager') }}";
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    propertyId: propertyId,
                    renterId: renterId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (response.success) {
                    console.log("lllll", response);
                    toastr.success(response.message);
                } else {
                    toastr.danger(response.message);
                }
            })
            .catch(error => {
                // console.error('Error:', error);
            });
    }
</script>
@endpush
@extends('admin.layouts.app')
@section('content')
@push('style')
<link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
<style>
    .card-profile {
        border-radius: 16px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }
    .card-profile .card-body {
        padding: 30px;
    }
    .card-profile img {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .card-profile-name {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }
    .invoice-info-row {
        display: flex;
        justify-content: flex-start;
        gap: 15px;
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f8f9fa;
        font-size: 0.95rem;
    }
    .invoice-info-row span:first-child {
        width: 140px;
        color: #6c757d;
        font-weight: 500;
    }
    .invoice-info-row span:last-child {
        color: #2d3748;
        font-weight: 600;
    }
    .tab-pane {
        display: none;
    }
    .tab-pane.active {
        display: block;
    }
    .view-profile-btns {
        font-size: 8px !important;
        padding: 10px 12px !important;
    }
</style>
@endpush
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin-activeRenter') }}">Renters</a></li>
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

                    <div class="card-footer py-2 px-2 bg-light-soft border-top-0 mx-auto">
                        <div class="btn-group-wrapper">
                            <a href="javascript:void(0)" onclick="claimRenter({{ $data->Id }})" class="btn btn-premium btn-premium-outline-primary view-profile-btns">
                                <i class="fa-solid fa-user-tag"></i> Claim Profile
                            </a>
                            <a href="{{ route('admin-edit-renter', ['id' => $data->Id]) }}" class="btn btn-premium btn-premium-outline-primary view-profile-btns">
                                <i class="fa-solid fa-file-signature"></i> Add Lease
                            </a>
                            <a href="{{ route('admin-edit-renter', ['id' => $data->Id]) }}" class="btn btn-premium btn-premium-outline-primary view-profile-btns">
                                <i class="fa-solid fa-toggle-off"></i> Change Inactive
                            </a>
                            <a href="javascript:void(0)" class="btn btn-premium btn-premium-outline-primary view-profile-btns" data-id="{{ $data->Id }}">
                                <i class="fa-solid fa-bell"></i> Set Reminder
                            </a>
                            <a href="{{ route('admin-edit-renter', ['id' => $data->Id]) }}" class="btn btn-premium btn-premium-outline-primary view-profile-btns">
                                <i class="fa-solid fa-user-edit"></i> Edit Profile
                            </a>
                            <a href="{{ route('admin-map-view', ['id' => $data->Id]) }}" class="btn btn-premium btn-premium-outline-primary view-profile-btns">
                                <i class="fa-solid fa-map-marked-alt"></i> View on Map
                            </a>
                            <a href="{{ route('admin-map-search', ['id' => $data->Id]) }}" class="btn btn-premium btn-premium-outline-primary view-profile-btns">
                                <i class="fa-solid fa-search-location"></i> Map Search
                            </a>
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

                @if($latestLeaseReport)
                <div class="card card-profile mg-t-20 border-info shadow-sm">
                    <div class="card-header bg-info-soft py-3 d-flex justify-content-between align-items-center">
                        <h6 class="slim-card-title tx-info mb-0"><i class="fa-solid fa-file-contract mr-2"></i> Latest Lease Report ({{ $latestLeaseReport->created_at->format('M d, Y') }})</h6>
                        <a href="{{ route('admin-view-lease-report', ['id' => $latestLeaseReport->id]) }}" class="btn btn-sm btn-outline-info">View Detailed Report</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="invoice-info-row"><span class="font-weight-bold">Community</span> <span>{{ $latestLeaseReport->namecommunityorlandlords }}</span></p>
                                <p class="invoice-info-row"><span class="font-weight-bold">Address</span> <span>{{ $latestLeaseReport->address }} {{ $latestLeaseReport->apt ? '#'.$latestLeaseReport->apt : '' }}</span></p>
                                <p class="invoice-info-row"><span class="font-weight-bold">Move-in Date</span> <span>{{ $latestLeaseReport->movedate }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="invoice-info-row"><span class="font-weight-bold">Rent Amount</span> <span>${{ $latestLeaseReport->rentamount }}</span></p>
                                <p class="invoice-info-row"><span class="font-weight-bold">Assisted By</span> <span>{{ $latestLeaseReport->assisted_by }}</span></p>
                                <p class="invoice-info-row"><span class="font-weight-bold">Status</span> 
                                    <span>
                                        @if($latestLeaseReport->status == 0) <span class="badge badge-warning">Pending Review</span>
                                        @elseif($latestLeaseReport->status == 1) <span class="badge badge-success">Approved</span>
                                        @else <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="card card-profile mg-t-20">

                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h6 class="slim-card-title">Detailed Information</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-md-6 border-right">
                                <div class="px-3 py-2">
                                    @php
                                        $mainDetails = [
                                            'Created On' => $data->formatted_created_on ?? 'N/A',
                                            'Status' => $data->Status == '1' ? 'Active' : ($data->Status == '2' ? 'Leased' : 'Inactive'),
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
                                        ];

                                        // Add Lease specifics if available
                                        if ($data->Status == '2') {
                                            $mainDetails['New Rental Address'] = $data->renterInfo->new_rental_adddress ?? 'N/A';
                                            $mainDetails['Unit'] = $data->renterInfo->unit ?? 'N/A';
                                            $mainDetails['Landlord'] = $data->renterInfo->landloard ?? 'N/A';
                                        }
                                    @endphp
                                    @foreach ($mainDetails as $label => $value)
                                    <div class="invoice-info-row">
                                        <span class="font-weight-bold">{{ $label }}</span>
                                        <span class="text-muted">{{ $value }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="px-3 py-2">
                                    @php
                                        $secondaryDetails = [
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
                                        ];

                                        if ($data->Status == '2') {
                                            $secondaryDetails['Rent Amount'] = '$' . ($data->renterInfo->rent_amount ?? 'N/A');
                                            $secondaryDetails['Lease End Date'] = $data->renterInfo->LeaseEndDate ?? 'N/A';
                                            $secondaryDetails['Ready to Invoice'] = $data->renterInfo->ready_to_invoice ? 'YES' : 'NO';
                                        }
                                    @endphp
                                    @foreach ($secondaryDetails as $label => $value)
                                    <div class="invoice-info-row">
                                        <span class="font-weight-bold">{{ $label }}</span>
                                        <span class="text-muted">@if($label == 'Additional Information') {!! nl2br(e($value)) !!} @else {{ $value }} @endif</span>
                                    </div>
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

                <nav class="mg-t-20">
                    <ul class="tabs">
                        <li class="tab-li">
                            <a href="#favoritetab" class="tab-li__link active">
                                <i class="fa-solid fa-heart mr-2"></i> Favorite Listing
                            </a>
                        </li>
                        <li class="tab-li">
                            <a href="#inquirytab" class="tab-li__link">
                                <i class="fa-solid fa-history mr-2"></i> Inquiry History
                            </a>
                        </li>
                    </ul>
                </nav>

                <div id="favoritetab" class="tab-pane active" data-tab-content>
                    <div class="card card-latest-activity mg-t-20 shadow-sm">
                        <div class="card-body">
                            <div class="table-wrapper mt-4">
                                <table class="table display responsive nowrap" id="favorite-listing" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Property Name</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Action</th>
                                            <th>Note</th>
                                            <th>Notify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="inquirytab" class="tab-pane" data-tab-content>
                    <div class="card card-latest-activity mg-t-20 shadow-sm">
                        <div class="card-body">
                            <div class="slim-card-title mb-4">Property Inquiry History</div>
                            <div class="table-wrapper mt-4">
                                <table class="table display responsive nowrap" id="inquiry-history" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name of Property</th>
                                            <th>Inquiry Date</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
        // Initialize Favorite Listing DataTable
        $('#favorite-listing').DataTable(DataTableHelpers.getConfig({
            url: "{{ route('admin-fav-listing', ['id' => $data->Id]) }}",
            type: 'GET'
        }, [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "propertyName", name: "propertyName" },
            { data: "city", name: "city" },
            { data: "state", name: "state" },
            { data: "actions", name: "actions", orderable: false, searchable: false },
            { data: "note", name: "note", orderable: false, searchable: false, className: "text-center" },
            { data: "notify", name: "notify", orderable: false, searchable: false, className: "text-center" }
        ]));

        // Initialize Inquiry History DataTable
        $('#inquiry-history').DataTable(DataTableHelpers.getConfig("{{ route('admin-inquiry-history', ['id' => $data->Id]) }}", [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "propertyName", name: "propertyName" },
            { data: "inquiryDate", name: "inquiryDate" },
            { data: "response", name: "response" }
        ]));

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
                        AdminToast.success("Reminder set successfully");
                        $('#remainder-box-' + {{ $data->Id }}).fadeOut();
                    } else {
                        AdminToast.error(response.message || "Failed to set reminder");
                    }
                },
                error: function(xhr) {
                    AdminToast.error("An error occurred. Please try again.");
                },
                complete: function() {
                    $('.submit-spinner').html(`Set Remainder`);
                    $('.submit-spinner').prop('disabled', false);
                },
            });

            $(this).addClass('was-validated');
        });
    });

    // Tab System JS
    $(document).ready(function() {
        function switchTab(target) {
            // Links
            $('.tabs a').removeClass('active');
            $('.tabs a[href="' + target + '"]').addClass('active');
            
            // Panes
            $('.tab-pane').removeClass('active');
            $(target).addClass('active');
            
            // Recalculate DataTables
            setTimeout(() => {
                if ($.fn.DataTable.isDataTable('#favorite-listing')) {
                    $('#favorite-listing').DataTable().columns.adjust().responsive.recalc();
                }
                if ($.fn.DataTable.isDataTable('#inquiry-history')) {
                    $('#inquiry-history').DataTable().columns.adjust().responsive.recalc();
                }
            }, 100);
        }

        $('.tabs a').on('click', function(e) {
            e.preventDefault();
            const target = $(this).attr('href');
            switchTab(target);
            history.pushState(null, null, target);
        });

        // Initial tab from hash or first tab
        const hash = window.location.hash || '#favoritetab';
        switchTab(hash);
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
                if (data.success) {
                    AdminToast.success(data.message);
                } else {
                    AdminToast.error(data.message);
                }
            })
            .catch(error => {
                // console.error('Error:', error);
            });
    }
    function claimRenter(id) {
        if(!confirm('Are you sure you want to claim this renter?')) return;
        
        fetch("{{ route('admin-claim-renter') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ renterId: id })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                AdminToast.success("Renter claimed successfully");
                location.reload();
            } else {
                AdminToast.error("Failed to claim renter");
            }
        })
        .catch(err => {
             console.error(err);
             AdminToast.error("Error occurred");
        });
    }
</script>
@endpush
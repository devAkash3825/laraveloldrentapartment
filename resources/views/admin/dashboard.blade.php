@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Dashboard')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
            </ol>
            <h6 class="slim-pagetitle">Dashboard</h6>
        </div>

        <div class="dash-headline-two">
            <div>
                <h4 class="tx-inverse mg-b-5">Welcome Back,
                    {{ strtoupper(@Auth::guard('admin')->user()->admin_login_id) }}!
                </h4>
                <p class="mg-b-0">Today is {{ \Carbon\Carbon::today()->format('F d, Y') }}</p>
            </div>
        </div>
        
        <div class="row row-xs mg-t-20">
            <!-- Total Renters -->
            <div class="col-sm-6 col-lg-3">
                <div class="card card-status">
                    <div class="media">
                        <i class="icon fa-solid fa-users tx-purple"></i>
                        <div class="media-body">
                            <h1>{{ $totalRenters }}</h1>
                            <p>Total Renters</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Active Renters -->
            <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
                <a href="{{ route('admin-activeRenter') }}" class="text-decoration-none">
                    <div class="card card-status">
                        <div class="media">
                            <i class="icon fa-solid fa-user-check tx-teal"></i>
                            <div class="media-body">
                                <h1>{{ $activeRenters }}</h1>
                                <p>Active Renters</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Total Properties -->
            <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                <div class="card card-status">
                    <div class="media">
                        <i class="icon fa-solid fa-building tx-primary"></i>
                        <div class="media-body">
                            <h1>{{ $totalproperty }}</h1>
                            <p>Total Properties</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Active Properties -->
            <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                <div class="card card-status">
                    <div class="media">
                        <i class="icon fa-solid fa-house-circle-check tx-pink"></i>
                        <div class="media-body">
                            <h1>{{ $activeProperty }}</h1>
                            <p>Active Properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-sm mg-t-20">
            <div class="col-lg-6">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="slim-card-title mb-0">Unassigned Renters</h6>
                        <a href="{{ route('admin-unassigned-renters') }}" class="tx-12">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                                <tr class="tx-10">
                                    <th class="wd-10p pd-y-5">S.No</th>
                                    <th class="pd-y-5">Renter Name</th>
                                    <th class="pd-y-5">Probability</th>
                                    <th class="pd-y-5 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listunassignedRenter as $renter)
                                <tr id="renter-row-{{ $renter['id'] }}">
                                    <td class="pd-l-20">{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin-view-profile', ['id' => $renter['id']]) }}" class="tx-inverse tx-medium d-block">
                                            {{ @$renter['Firstname'] }} {{ $renter['Lastname'] }}
                                        </a>
                                    </td>
                                    <td><span class="badge badge-warning">{{ @$renter['Probability'] ?? '-' }}%</span></td>
                                    <td class="text-end">
                                        @if (Auth::guard('admin')->user()->hasPermission('renter_claim'))
                                        <button class="btn btn-primary btn-xs submit-spinner-{{ $renter['id'] }}" onclick="claimRenter({{ $renter['id'] }})">
                                            Claim
                                        </button>
                                        @else
                                        <button class="btn btn-secondary btn-xs disabled">No Access</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center p-3">No unassigned renters found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="slim-card-title mb-0">My Recent Renters</h6>
                        <a href="{{ route('admin-unassigned-renters') }}" class="tx-12">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                                <tr class="tx-10">
                                    <th class="wd-10p pd-y-5">S.No</th>
                                    <th class="pd-y-5">Name</th>
                                    <th class="pd-y-5 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listassignedRenter as $renter)
                                <tr id="renter-row-{{ $renter->Id }}">
                                    <td class="pd-l-20">{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin-view-profile', ['id' => $renter->Id]) }}" class="tx-inverse tx-medium d-block">
                                            {{ $renter->renterinfo->Firstname }} {{ $renter->renterinfo->Lastname }}
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin-view-profile', ['id' => $renter->Id]) }}" class="btn btn-outline-primary btn-xs">
                                            View Profile
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center p-3">No assigned renters found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mg-t-20">
            <div class="col-lg-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="slim-card-title mb-0">Recent Active Properties</h6>
                        @if (Auth::guard('admin')->user()->hasPermission('property_addedit'))
                        <a href="{{ route('admin-addProperty') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus mg-r-5"></i> Add Property
                        </a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                                <tr class="tx-10">
                                    <th class="wd-5p pd-y-5 tx-center">S.No</th>
                                    <th class="pd-y-5">Property Name</th>
                                    <th class="pd-y-5">Location</th>
                                    <th class="pd-y-5">Status</th>
                                    <th class="pd-y-5 text-end">Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activeProperties as $item)
                                <tr id="property-row-{{ $item->Id }}">
                                    <td class="tx-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('admin-property-display', ['id' => $item->Id]) }}" class="tx-inverse tx-medium d-block">
                                            {{ $item->PropertyName }}
                                        </a>
                                    </td>
                                    <td>{{ $item->city->CityName }}, {{ $item->city->state->StateName }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="changeStatus({{ $item->Id }})">
                                            <span class="badge badge-success">Active</span>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        {{ $item->CreatedOn ? $item->CreatedOn->format('M d, Y') : '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-3">No recent properties found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('adminscripts')
<script>
    // Set routes for dashboard JavaScript
    const dashboardRoutes = {
        changePropertyStatus: "{{ route('admin-change-property-status') }}",
        claimRenter: "{{ route('admin-claim-renter') }}"
    };
</script>
<script src="{{ asset('common/js/dashboard.js') }}"></script>
@endpush
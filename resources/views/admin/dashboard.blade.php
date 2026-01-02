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
        <hr>

        <div class="card card-dash-one mg-t-20">
            <div class="row no-gutters">
                <div class="col-lg-12">
                    <a href="{{ route('admin-revert-contactus') }}">
                        <i class="icon ion-ios-analytics-outline"></i>
                        <div class="dash-content">
                            <label class="tx-primary">Pending Contact Us Messages </label>
                            <h2>0</h2>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <hr>

        <div class="report-summary-header">
            <div>
                <h4 class="tx-inverse mg-b-3">Renters Section</h4>
            </div>
            @if (Auth::guard('admin')->user()->hasPermission('user_addedit'))
            <div>
                <a href="{{ route('admin-client-adduser') }}" class="btn btn-primary"><i
                        class="icon ion-ios-clock-outline tx-22"></i> Add Renters
                </a>
            </div>
            @endif
        </div>

        <div class="row no-gutters dashboard-chart-one">
            <div class="col-md-4 col-lg">
                <div class="card card-total">
                    <div>
                        <h1>{{ $totalRenters }}</h1>
                        <p>Total Renters</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg">
                <a href="{{ route('admin-activeRenter') }}">
                    <div class="card card-total">
                        <div>
                            <h1>{{ $activeRenters }}</h1>
                            <p>Active Renters </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg">
                <a href="{{ route('admin-inactiveRenter') }}">
                    <div class="card card-total">
                        <div>
                            <h1>{{ $InactiveRenters }}</h1>
                            <p>Inactive Renters</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg">
                <a href="{{ route('admin-leasedRenter') }}">
                    <div class="card card-total">
                        <div>
                            <h1>{{ $leasedRenters }}</h1>
                            <p>Leased Renters</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row row-sm mg-t-20">
            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="card card-table">
                    <div class="card-header">
                        <h6 class="slim-card-title"> Unassigned Renters </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                                <tr class="tx-10">
                                    <th class="wd-10p pd-y-5">S.No</th>
                                    <th class="pd-y-5">Renter Name </th>
                                    <th class="pd-y-5">Probability (%) </th>
                                    <th class="pd-y-5">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listunassignedRenter as $renter)
                                <tr id="renter-row-{{ $renter['id'] }}">
                                    <td class="pd-l-20">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin-view-profile', ['id' => $renter['id']]) }}"
                                            class="tx-14 tx-medium d-block"> {{ @$renter['Firstname'] }}
                                            {{ $renter['Lastname'] }} </a>
                                    </td>
                                    <td class="tx-12">
                                        <a href="#"
                                            class="tx-inverse tx-14 tx-medium d-block">{{ @$renter['Probability'] ?? '-' }}
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        @if (Auth::guard('admin')->user()->hasPermission('renter_claim'))
                                        <a href="javascript:void(0)"
                                            class="btn btn-primary btn-sm submit-spinner-{{ $renter['id'] }}"
                                            onclick="claimRenter({{ $renter['id'] }})"> Claim </a>
                                        @else
                                        <a href="javascript:void(0)"
                                            class="btn btn-secondary disabled btn-sm"> No Acceess </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent">
                        <a href="{{ route('admin-unassigned-renters') }}"><i class="fa fa-angle-down mg-r-5"></i>View All Unassigned Renters </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="card card-table">
                    <div class="card-header">
                        <h6 class="slim-card-title">Recent Assigned Renters </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                                <tr class="tx-10">
                                    <th class="wd-10p pd-y-5">S.No</th>
                                    <th class="pd-y-5">First Name </th>
                                    <th class="pd-y-5">Last Name </th>
                                    <th class="pd-y-5">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listassignedRenter as $renter)
                                <tr id="renter-row-{{ $renter->Id }}">
                                    <td class="pd-l-20">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href=""
                                            class="tx-inverse tx-14 tx-medium d-block">{{ $renter->renterinfo->Firstname }}</a>
                                    </td>
                                    <td class="tx-12">
                                        <a href=""
                                            class="tx-inverse tx-14 tx-medium d-block">{{ $renter->renterinfo->Lastname }}</a>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin-view-profile', ['id' => $renter->Id]) }}"
                                            class="btn btn-primary btn-sm submit-spinner-{{ $renter->Id }}"> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer tx-12 pd-y-15 bg-transparent">
                        <a href="{{ route('admin-unassigned-renters') }}"><i class="fa fa-angle-down mg-r-5"></i>View
                            All Assigned Renters </a>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <br>

        <div class="report-summary-header">
            <div>
                <h4 class="tx-inverse mg-b-3">Property Section</h4>
            </div>
            @if (Auth::guard('admin')->user()->hasPermission('property_addedit'))
            <div>
                <a href="{{ route('admin-client-adduser') }}" class="btn btn-primary"><i
                        class="icon ion-ios-clock-outline tx-22"></i> Add Properties
                </a>
            </div>
            @endif
        </div>

        <div class="row no-gutters dashboard-chart-one">
            <div class="col-md-4 col-lg">
                <div class="card card-total">
                    <div>
                        <h1>{{ $totalproperty }}</h1>
                        <p> Total Properties </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg">
                <div class="card card-total">
                    <div>
                        <h1>{{ $activeProperty }}</h1>
                        <p> Active Properties </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg">
                <div class="card card-total">
                    <div>
                        <h1>{{ $inactiveProperty }}</h1>
                        <p> Inactive Properties </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-table mg-t-20 mg-sm-t-30">
            <div class="card-header">
                <h6 class="slim-card-title">Recent Active Properties</h6>
            </div>
            <div class="table-responsive">
                <table class="table mg-b-0 tx-13">
                    <thead>
                        <tr class="tx-10">
                            <th class="wd-10p pd-y-5 tx-center">S.No</th>
                            <th class="pd-y-5">Property Name</th>
                            <th class="pd-y-5 tx-right">City</th>
                            <th class="pd-y-5 tx-center">State</th>
                            <th class="pd-y-5">Status</th>
                            <th class="pd-y-5">Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeProperties as $item)
                        <tr id="property-row-{{ $item->Id }}">
                            <td class="tx-center">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <a href="{{ route('admin-property-display', ['id' => $item->Id]) }}"
                                    class="tx-inverse tx-medium d-block">{{ $item->PropertyName }}</a>
                            </td>
                            <td class="valign-middle tx-right">{{ $item->city->CityName }}</td>
                            <td class="valign-middle tx-center">{{ $item->city->state->StateName }}</td>
                            <td class="valign-middle tx-left">
                                <a href="javascript:void(0)" onclick="changeStatus({{ $item->Id }})"
                                    class="c-pill c-pill--success">
                                    Active </a>
                            </td>
                            <td class="valign-middle tx-left">
                                {{ $item->CreatedOn ? $item->CreatedOn->format('Y-m-d') : 'Not Available' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
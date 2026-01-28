@extends('admin.layouts.app')

@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin-lease-reports') }}">Lease Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Report</li>
            </ol>
            <h6 class="slim-pagetitle">Lease Report Details</h6>
        </div>

        <div class="row row-sm">
            <div class="col-lg-8">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">LEASE REPORT</h1>
                            <div class="billed-from">
                                <h6>Submitted By:</h6>
                                <p>{{ $report->renter->renterinfo->Firstname }} {{ $report->renter->renterinfo->Lastname }}<br>
                                Email: {{ $report->email }}<br>
                                Phone: {{ $report->phone }}</p>
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="section-label-sm">Community Information</label>
                                <div class="billed-to">
                                    <h6 class="tx-gray-800">{{ $report->namecommunityorlandlords }}</h6>
                                    <p>Address: {{ $report->address }} {{ $report->apt ? '(Apt: '.$report->apt.')' : '' }}<br>
                                    {{ $report->city }}, {{ $report->state }} {{ $report->zipcode }}<br>
                                    Landlord Phone: {{ $report->landlordtelephone }}</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="section-label-sm">Lease Information</label>
                                <p class="invoice-info-row">
                                    <span>Move-in Date</span>
                                    <span>{{ $report->movedate }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span>Rent Amount</span>
                                    <span>${{ $report->rentamount }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span>Lease Length</span>
                                    <span>{{ $report->lengthlease }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span>Assisted By</span>
                                    <span>{{ $report->assisted_by }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="mg-t-40 tx-center">
                            @if($report->status == 0)
                                <button class="btn btn-success btn-lg px-5 mg-r-10" onclick="approveReport({{ $report->id }})">Approve & Mark as Leased</button>
                                <button class="btn btn-danger btn-lg px-5" onclick="rejectReport({{ $report->id }})">Reject Report</button>
                            @else
                                <div class="alert {{ $report->status == 1 ? 'alert-success' : 'alert-danger' }} py-3">
                                    <h4 class="mg-b-0">Report is already {{ $report->status == 1 ? 'Approved' : 'Rejected' }}</h4>
                                </div>
                                <a href="{{ route('admin-view-profile', ['id' => $report->renter_id]) }}" class="btn btn-primary btn-lg px-5">View Renter Profile</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card card-people-list shadow-sm">
                    <div class="slim-card-title">Renter Snapshot</div>
                    <div class="media-list">
                        <div class="media">
                            <img src="{{ asset('img/temp_profile.png') }}" alt="">
                            <div class="media-body">
                                <a href="{{ route('admin-view-profile', ['id' => $report->renter_id]) }}" class="tx-16 tx-inverse tx-bold">
                                    {{ $report->renter->renterinfo->Firstname }} {{ $report->renter->renterinfo->Lastname }}
                                </a>
                                <p class="mg-b-0">Current Status: 
                                    @if($report->renter->Status == 1) <span class="badge badge-success">Active</span>
                                    @elseif($report->renter->Status == 2) <span class="badge badge-info">Leased</span>
                                    @else <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </p>
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
    function approveReport(id) {
        if(!confirm("Are you sure you want to approve this lease report? This will automatically update the renter's status to 'Leased' and update their profile with this information.")) return;
        
        $.ajax({
            url: "{{ route('admin-approve-lease-report') }}",
            type: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if(res.success) {
                    toastr.success(res.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(res.message);
                }
            }
        });
    }

    function rejectReport(id) {
        if(!confirm("Are you sure you want to reject this lease report?")) return;
        
        $.ajax({
            url: "{{ route('admin-reject-lease-report') }}",
            type: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if(res.success) {
                    toastr.success(res.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(res.message);
                }
            }
        });
    }
</script>
<style>
    .invoice-info-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }
    .invoice-info-row span:first-child {
        font-weight: bold;
        color: #555;
    }
</style>
@endpush

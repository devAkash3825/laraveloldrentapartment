@extends('admin.layouts.app')

@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Incoming Lease Reports</li>
            </ol>
            <h6 class="slim-pagetitle">Incoming Lease Reports</h6>
        </div>

        <div class="section-wrapper">
            <label class="section-title">Lease Reports Listing</label>
            <p class="mg-b-20 mg-sm-b-40">Review and process lease reports submitted by renters.</p>

            <div class="table-wrapper">
                <table id="leaseReportsTable" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-5p">S.No</th>
                            <th class="wd-15p">Renter Name</th>
                            <th class="wd-20p">Community/Landlord</th>
                            <th class="wd-15p">Move-in Date</th>
                            <th class="wd-10p">Rent</th>
                            <th class="wd-15p">Submitted On</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('adminscripts')
<script>
    $(document).ready(function() {
        $('#leaseReportsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin-lease-reports') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'renter_name', name: 'renter_name' },
                { data: 'namecommunityorlandlords', name: 'namecommunityorlandlords' },
                { data: 'movedate', name: 'movedate' },
                { data: 'rentamount', name: 'rentamount' },
                { data: 'created_at', name: 'created_at' },
                { data: 'status_label', name: 'status_label' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
    });
</script>
@endpush

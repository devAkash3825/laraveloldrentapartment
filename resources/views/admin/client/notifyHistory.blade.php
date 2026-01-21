@extends('admin.layouts.app')

@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Notify History</h6>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <ul class="nav nav-activity-profile mg-t-20">
                        <li class="nav-item"><a href="" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i>
                                Select All </a></li>
                        <li class="nav-item"><a href="" class="nav-link"><i class="icon ion-image tx-primary"></i>
                                Add History </a></li>
                    </ul>

                    <div class="section-wrapper mt-1">
                        <div class="table-wrapper">
                            <table id="notifyhistory" class="table display responsive">
                                <thead>
                                    <tr>
                                        <th class="px-3">No</th>
                                        <th>Select</th>
                                        <th>Property</th>
                                        <th>Manager</th>
                                        <th>Renter</th>
                                        <th>Send Time</th>
                                        <th>Response Time </th>
                                        <th>Agent</th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(function() {
                try {
                    $("#notifyhistory").DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('admin-notify-history') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex",
                            },
                            {
                                data: "selectall",
                                name: "selectall"
                            },
                            {
                                data: "propertyname",
                                name: "propertyname"
                            },
                            {
                                data: "owner",
                                name: "owner"
                            },
                            {
                                data: "rentername",
                                name: "rentername"
                            },
                            {
                                data: "sendtime",
                                name: "sendtime"
                            },
                            {
                                data: "responsetime",
                                name: "responsetime"
                            },
                            {
                                data: "agent",
                                name: "agent"
                            },
                            {
                                data: "action",
                                name: "action"
                            },
                        ],
                    });
                } catch (err) {
                    console.log("Err in datatables", err);
                }
            });
        });
    </script>
@endpush

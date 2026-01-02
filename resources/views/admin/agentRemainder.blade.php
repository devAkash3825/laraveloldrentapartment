@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
                <h6 class="slim-pagetitle">Agent Remainder</h6>
            </div>


            <div class="card bd-0">
                <div class="card-header bg-primary bd-0 d-flex align-items-center justify-content-between pd-y-5">
                    <h6 class="mg-b-0 tx-20 tx-white tx-normal p-1">Special</h6>
                </div>
                <div class="card-body bd bd-t-0 rounded-bottom-0" style="max-height:250px;overflow:auto;">
                    @foreach ($properties as $item)
                        <p class="mg-b-0 font-weight-bold">{{ @$item->propertyinfo->PropertyName }}</p>
                        <p class="mg-b-0">{{ $item->special }}</p>
                        <p><a href="">{{ $item->addeddate }}</a></p>
                        <hr>
                    @endforeach
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header d-flex align-items-center justify-content-between p-3 bd-b">
                    <h6 class="mg-b-0 tx-14 tx-inverse">Remainders </h6>
                </div>

                <div class="card-body">
                    <table id="agentRemainderTable" class="table display responsive">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Renter Name</th>
                                <th>Bedroom</th>
                                <th>Remainder Time</th>
                                <th>Remainder Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {  
            $(function() {
                try {
                    $("#agentRemainderTable").DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('admin-agent-remainder') }}",
                        columns:[
                            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
                            { data: "name", name: "name" },
                            { data: "bedroom", name: "bedroom" },
                            { data: "Reminder_date", name: "Reminder_date" },
                            { data: "reminder_note", name: "reminder_note" },
                            { data: "action", name: "action" },
                        ],
                    });
                } catch (err) {
                    console.log("Err in datatables", err);
                }
            });
        });
    </script>
@endpush

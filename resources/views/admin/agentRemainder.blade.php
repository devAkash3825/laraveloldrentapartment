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
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Reminder From</label>
                            <input type="date" id="reminderfrom" class="form-control" placeholder="Start Date">
                        </div>
                        <div class="col-md-3">
                            <label>Reminder To</label>
                            <input type="date" id="reminderto" class="form-control" placeholder="End Date">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button id="search-btn" class="btn btn-primary btn-block">Search</button>
                        </div>
                    </div>

                    <table id="agentRemainderTable" class="table display responsive">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Renter Name</th>
                                <th>Probability</th>
                                <th>Bedroom</th>
                                <th>Rent Range</th>
                                <th>Move Date</th>
                                <th>Area</th>
                                <th>Reminder Time</th>
                                <th>Note</th>
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
                var table = $("#agentRemainderTable").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin-agent-remainder') }}",
                        data: function (d) {
                            d.reminderfrom = $('#reminderfrom').val();
                            d.reminderto = $('#reminderto').val();
                        }
                    },
                    columns:[
                        { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
                        { data: "name", name: "name" },
                        { data: "probability", name: "probability" },
                        { data: "bedroom", name: "bedroom" },
                        { data: "rent_range", name: "rent_range" },
                        { data: "move_date", name: "move_date" },
                        { data: "area", name: "area" },
                        { data: "Reminder_date", name: "Reminder_date" },
                        { data: "reminder_note", name: "reminder_note" },
                        { data: "action", name: "action" },
                    ],
                });

                $('#search-btn').click(function(){
                    table.draw();
                });
            });
        });
    </script>
@endpush

@extends('admin.layouts.app')

@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">View Notify History</h6>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="manager-left">
                        <nav class="nav">
                            <a href="javascript:void(0)" class="nav-link ">
                                <span class="font-weight-bold">Renter</span>
                                <span>{{ @$rec->renterinfo->Firstname .''.$rec->renterinfo->Lastname }}</span>
                            </a>
                            <a href="javascript:void(0)" class="nav-link ">
                                <span class="font-weight-bold">Property</span>
                                <span>{{ @$rec->propertyinfo->PropertyName .''.$rec->renterinfo->Lastname }}</span>
                            </a>
                            <a href="javascript:void(0)" class="nav-link">
                                <span class="font-weight-bold">Send Time</span>
                                <span>{{ @$rec->send_time->format('Y-m-d H:i:s') }}</span>
                            </a>
                            <a href="javascript:void(0)" class="nav-link">
                                <span class="font-weight-bold">Receive Time</span>
                                <span>{{ @$rec->respond_time ? $row->respond_time->format('Y-m-d H:i:s') : '' }}</span>
                            </a>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                    <ul class="nav nav-activity-profile mg-t-20">
                        <li class="nav-item"><a href="" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i>
                                Select All </a></li>
                        <li class="nav-item"><a href="" class="nav-link"><i class="icon ion-image tx-primary"></i>
                                Add History </a></li>
                    </ul>

                    <div class="section-wrapper mt-1">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


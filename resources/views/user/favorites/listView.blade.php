@extends('user.layout.app')
@section('content')
@section('title', 'RentApartement | Favorite Properties ')
<style>
    .header-row th {
        border-bottom: 1px solid #eaeaea !important;
    }
</style>
<div id="breadcrumb_part"
    style="background: url(../images/breadcroumb_bg.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4> List View </h4>
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Thumbnail View </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="dashboard_content">
                    <div class="manage_dasboard">
                        <x-favorite-sidebar />
                        <div class="row mt-2">
                            <div class="col-xl-12 mt-3">
                                <div class="px-1">
                                    <table id="fav-listview" class="table align-middle mb-0 bg-white table-hover border">
                                        <thead>
                                            <tr class="header-row" style="border:1px solid #eaeaea !important;">
                                                <th class="wd-10p pd-y-5 tx-center"><input type="checkbox" id="selectAll"></th>
                                                <th style="align-content:center;">Property Name</th>
                                                <th style="align-content:center;">Quotes</th>
                                                <th style="align-content:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="border:1px solid #eaeaea !important;">
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
</section>
@endsection
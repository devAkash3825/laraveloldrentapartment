@extends('admin/layouts/app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Specials</li>
            </ol>
            <h6 class="slim-pagetitle"> Special </h6>
        </div>
        <div class="section-wrapper">
        <div class="table-wrapper">
            <table id="specialtable" class="table display responsive">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Property Name </th>
                        <th>Specials</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection
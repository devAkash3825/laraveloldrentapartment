@extends('admin/layouts/app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Show All</li>
            </ol>
            <h6 class="slim-pagetitle"> Show All  </h6>
        </div>
        <div class="section-wrapper">
        <div class="table-wrapper">
            <table id="showalltable" class="table display responsive">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name </th>
                        <th>Area to move</th>
                        <th>Probability</th>
                        <th>Probability</th>
                        <th>Last Move Date</th>
                        <th>Actions</th>
                        <th>Status</th>
                        <th>Reminder date</th>
                        <th>Admin</th>
                    </tr>
                </thead>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection
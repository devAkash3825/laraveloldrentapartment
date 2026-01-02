@extends('admin.layouts.app')
@section('content')
    <style>
        #search-box {
            position: relative;
            width: 100%;
            margin: 0;
        }

        #search-form {
            height: 40px;
            border: 1px solid #999;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            background-color: #fff;
            overflow: hidden;
        }

        #search-text {
            font-size: 14px;
            color: #ddd;
            border-width: 0;
            background: transparent;
        }

        #search-box input[type="text"] {
            width: 90%;
            padding: 11px 0 12px 1em;
            color: #333;
            outline: none;
        }

        #search-button {
            position: absolute;
            top: 0;
            right: 0;
            height: 42px;
            width: 80px;
            font-size: 14px;
            color: #fff;
            text-align: center;
            line-height: 42px;
            border-width: 0;
            background-color: #4d90fe;
            -webkit-border-radius: 0px 5px 5px 0px;
            -moz-border-radius: 0px 5px 5px 0px;
            border-radius: 0px 5px 5px 0px;
            cursor: pointer;
        }
    </style>
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Call History</h6>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">

                    <div class="section-wrapper mg-t-20">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-control-label">From:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input id="dateMask" type="date" name="fromsearch" class="form-control"
                                            placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label">To:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input id="dateMask" type="date" name="tosearch" class="form-control"
                                            placeholder="MM/DD/YYYY">
                                    </div>
                                </div>


                                <div class="col-lg-12 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Property Name: </label>
                                        <input class="form-control" type="text" name="propertyname"
                                            placeholder="Enter Property Name">
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-4">
                                    <div class="form-layout-footer" style="float: right;">
                                        <button class="btn btn-primary bd-0">Search</button>
                                        <button class="btn btn-secondary bd-0">Reset</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                   
                
                    <div class="section-wrapper mt-1">
                        <div class="table-wrapper">
                            <table id="callhistory" class="table display responsive">
                                <thead>
                                    <tr>
                                        <th>Select All</th>
                                        <th>Property Name</th>
                                        <th>Caller</th>
                                        <th>Date/Time called</th>
                                        <th>Recording</th>
                                        <th>Call Duration</th>
                                        <th>Direction</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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

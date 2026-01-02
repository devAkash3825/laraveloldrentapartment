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
                <h6 class="slim-pagetitle">Fees Management </h6>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="section-wrapper mg-t-20">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="form-control-label">Select State</label>
                                    <div class="input-group">
                                        <select class="form-control form-select form-control-a" id="state" name="state" required>
                                            <option value="">Select State</option>
                                            @foreach($state as $row)
                                            <option value="{{$row->Id}}">{{$row->StateName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

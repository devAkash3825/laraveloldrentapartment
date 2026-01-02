@extends('admin.layouts.app')

@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"> Home </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Source</li>
                </ol>
                <h6 class="slim-pagetitle">Add Source</h6>
            </div>



            <div class="section-wrapper">
                <form action="">
                    <div class="form-layout">
                        <div class="row mg-b-25">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">Source Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="sourcename" placeholder="Source Name">
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">Status: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="srch_bedroom">
                                        <option value="">Status</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="form-layout-footer">
                            <button class="btn btn-primary bd-0" id="source-submit">Submit Form</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

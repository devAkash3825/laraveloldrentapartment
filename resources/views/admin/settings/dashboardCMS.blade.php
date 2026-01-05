@extends('admin.layouts.app')
@section('title', 'Admin | Dashboard CMS')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard CMS</li>
            </ol>
            <h6 class="slim-pagetitle">Dashboard CMS Management</h6>
        </div>

        <div class="section-wrapper">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('admin-update-dashboard-cms') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h3 class="tx-inverse mg-b-20">Renter Dashboard Settings</h3>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Renter Welcome Title: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="renter_title" value="{{ $cms->renter_title ?? '' }}" placeholder="Enter Renter Welcome Title">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Renter Welcome Text:</label>
                            <textarea class="form-control summernote" name="renter_text">{{ $cms->renter_text ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Renter Banner Image:</label>
                            <input type="file" class="form-control" name="renter_image">
                            @if(isset($cms->renter_image))
                                <div class="mt-2">
                                    <img src="{{ $cms->renter_image }}" alt="Renter Banner" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="mg-y-20">

                <h3 class="tx-inverse mg-b-20">Manager Dashboard Settings</h3>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Manager Welcome Title: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="manager_title" value="{{ $cms->manager_title ?? '' }}" placeholder="Enter Manager Welcome Title">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Manager Welcome Text:</label>
                            <textarea class="form-control summernote" name="manager_text">{{ $cms->manager_text ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Manager Banner Image:</label>
                            <input type="file" class="form-control" name="manager_image">
                            @if(isset($cms->manager_image))
                                <div class="mt-2">
                                    <img src="{{ $cms->manager_image }}" alt="Manager Banner" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-layout-footer mg-t-30">
                    <button class="btn btn-primary" type="submit">Update Settings</button>
                    <a href="{{ route('admin-dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('adminscripts')
<script>
    $(function(){
        'use strict';
        // Summernote editor
        $('.summernote').summernote({
          height: 150,
          toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
        });
    });
</script>
@endpush

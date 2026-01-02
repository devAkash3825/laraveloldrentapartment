@extends('admin.layouts.app')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle"> Footer Management </h6>
            </div>
            <div class="section-wrapper">
                <div class="container">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="edit-description">Short Description <span class="text-danger">*</span></label>
                            <textarea id="edit-description" name="short_description" class="form-control">
                                {!! @$footerInfo->short_description !!}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address" value="{{ @$footerInfo->address }}">
                        </div>
                        <div class="form-group">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="email" value="{{ @$footerInfo->email }}">
                        </div>
                        <div class="form-group">
                            <label for="">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" value="{{ @$footerInfo->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="">Copyright <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="copyright" value="{{ @$footerInfo->copyright }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#edit-description').summernote({
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style', 'clear']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endpush
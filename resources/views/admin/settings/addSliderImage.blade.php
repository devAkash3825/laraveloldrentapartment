@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle"> Slider Management </h6>
            </div>
            <div class="section-wrapper">
                <div class="container">
                    <h2>Edit Slider Image</h2>

                    <form action="{{ route('admin-store-slider-image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <img src="" alt="" style="width: 100px;" class="my-2">
                            <small>Leave empty to keep the current image.</small>
                            @error('image')
                                <div class="text-danger">{{ @$message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alt_text" class="form-label">Alt Text</label>
                            <input type="text" class="form-control" name="alt_text" id="alt_text"
                                value="{{ @$sliderImage->alt_text }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label"> Is Active </label>
                            <select class="form-control" id="is_active" name="is_active" required="">
                                <option value="">Select Status </option>
                                <option value="0">In_Active</option>
                                <option value="1">Active</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

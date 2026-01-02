@extends('admin.layouts.app')
@section('content')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 58px;
        height: 32px;
        margin: 9px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s cubic-bezier(0, 1, 0.5, 1);
        border-radius: 4px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 24px;
        width: 24px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s cubic-bezier(0, 1, 0.5, 1);
        border-radius: 3px;
    }

    input:checked+.slider {
        background-color: #52c944;
    }

    input:focus+.slider {
        box-shadow: 0 0 4px #7efa70;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
</style>
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> Slider Management </h6>
        </div>
        <div class="d-flex justify-content-end">
            <p><a href="{{ route('admin-add-slider-image') }}" class="btn btn-primary btn-block"> <i class="fa-solid fa-plus"></i> Add Slider Image </a></p>
        </div>

        <div class="section-wrapper">
            <div class="container">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Image</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliderImages as $sliderImage)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $sliderImage->image_path }}" alt="{{ $sliderImage->alt_text }}"
                                    style="width:60px;height:60px;">
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="toggle-status" data-id="{{ $sliderImage->Id }}"
                                        {{ $sliderImage->is_active == '1' ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>

                            <td>
                                <div class="table-actions-icons float-left">
                                    <a href="http://127.0.0.1:8000/admin/administration/edit-admin/94"
                                        class="edit-btn">
                                        <i class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i>
                                    </a>
                                    <a href="http://127.0.0.1:8000/admin/administration/edit-admin/94"
                                        class="delete-icon">
                                        <i class="fa-solid fa-trash  border px-2 py-2 delete-icon"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
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
                                    <a href="{{ route('admin-edit-slider-image', $sliderImage->Id) }}"
                                        class="edit-btn">
                                        <i class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="delete-btn" data-id="{{ $sliderImage->Id }}">
                                        <i class="fa-solid fa-trash border px-2 py-2 delete-icon"></i>
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

@push('adminscripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toggle Status
        $('.toggle-status').change(function() {
            var status = $(this).prop('checked') ? 1 : 0;
            var sliderId = $(this).data('id');
            
            $.ajax({
                url: "{{ route('admin-slider-status', '') }}/" + sliderId,
                type: 'POST',
                data: {
                    is_active: status
                },
                success: function(response) {
                    if(response.success){
                        toastr.success(response.message);
                    } else {
                        toastr.error('Failed to update status.');
                    }
                },
                error: function() {
                    toastr.error('Something went wrong.');
                }
            });
        });

        // Delete Image
        $('.delete-btn').click(function() {
            var sliderId = $(this).data('id');
            if(confirm("Are you sure you want to delete this slider image?")) {
                $.ajax({
                    url: "{{ route('admin-delete-slider-image', '') }}/" + sliderId,
                    type: 'POST',
                    success: function(response) {
                        if(response.success){
                            toastr.success(response.message);
                            location.reload(); 
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong.');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
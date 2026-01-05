@extends('admin.layouts.app')
@section('content')
@php
$settings = DB::table('settings')->pluck('value', 'key');
@endphp
@push('style')
<link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .image-preview,
    #callback-preview {
        /* width: 250px; */
        height: 250px;
        border: 2px dashed #ddd;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
        background-color: #ffffff;
        color: #ecf0f1;
    }

    .image-preview,
    #callback-preview:hover {
        cursor: pointer;
    }

    .image-preview input,
    #callback-preview input {
        line-height: 200px;
        font-size: 200px;
        position: absolute;
        opacity: 0;
        z-index: 10;
        cursor: pointer;
    }

    .image-hover-label {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        justify-content: center;
        align-items: center;
        font-size: 16px;
        cursor: pointer;
        height: 100%;
    }

    .image-preview:hover .image-hover-label {
        display: flex;
    }

    #image-upload {
        display: none;
        /* Hide the file input */
    }

    #image-preview-display {
        height: 100%;
        width: 100%;
        object-fit: contain;
    }
</style>
<style>
    * {
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .settings-vertical-tabs-container {
        display: flex;
        width: 100%;
        margin: 20px auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .settings-vertical-tabs {
        width: 30%;
        background: #f4f4f4;
        padding: 10px;
        border-right: 1px solid #ddd;
    }

    .settings-vertical-tabs button {
        display: block;
        width: 100%;
        padding: 12px;
        margin: 5px 0;
        background: none;
        border: none;
        text-align: left;
        cursor: pointer;
        font-size: 12px;
    }

    .settings-vertical-tabs button.settings-active {
        background: #007BFF;
        color: white;
        font-weight: bold;
        font-size: 12px;
        border-radius: 4px;
    }

    .settings-vertical-tab-content {
        width: 70%;
        padding: 20px;
    }

    .settings-vertical-content {
        display: none;
    }

    .settings-vertical-content.settings-active {
        display: block;
    }
</style>
@endpush
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> Pages Management </h6>
        </div>
        
        <div class="card card-table">
          <div class="card-body">
            
            <nav>
                <ul class="tabs">
                    <li class="tab-li">
                        <a href="#aboutus_tab" class="tab-li__link active">About Us</a>
                    </li>
                    <li class="tab-li">
                        <a href="#contactus_tab" class="tab-li__link">Contact Us</a>
                    </li>
                    <li class="tab-li">
                        <a href="#equalhousing_tab" class="tab-li__link">Equal Housing</a>
                    </li>
                    <li class="tab-li">
                        <a href="#terms_tab" class="tab-li__link">Terms & Conditions</a>
                    </li>
                    <li class="tab-li">
                        <a href="#manager_terms_tab" class="tab-li__link">Manager Terms</a>
                    </li>
                </ul>
            </nav>

            <div class="mt-3">
                <div id="aboutus_tab" class="tab-pane active" data-tab-content>
                        <form action="{{ route('admin-update-about-us') }}" method="POST" enctype="multipart/form-data" id="updateaboutus">
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <div class="form-group">
                                        <label for="">Background Image <span class="text-danger"></span></label>
                                        <div id="about-image-preview" class="image-preview">
                                            <label for="about-image-upload" class="image-hover-label">Choose File</label>
                                            <input type="file" name="background" id="about-image-upload" style="display: none;" />
                                            <input type="hidden" name="old_background" value="{{ @$aboutus->image }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="form-group">
                                        <label for="">Title <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="title" value="{{ @$aboutus->title }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Heading <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="heading" value="{{ @$aboutus->heading }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for=""> Description <span class="text-danger"></span></label>
                                        <textarea id="aboutdescription" name="aboutdescription" class="form-control">{!! @$aboutus->description !!}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-4">
                                    <div class="form-layout-footer" style="float: right;">
                                        <button type="submit" class="btn btn-primary bd-0 submit-spinner">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
                
                <div id="contactus_tab" class="tab-pane" data-tab-content>
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <form action="{{ route('admin-update-contactusCMS') }}" method="POST"
                                        enctype="multipart/form-data" id="contactusCMS">
                                        <div class="row mt-3">
                                            <div class="col-6 mt-3">
                                                <div class="form-group">
                                                    <label for="">Phone <span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="phone"
                                                        value="{{ $contact?->phone }}">
                                                </div>
                                            </div>
                                            <div class="col-6 mt-3">
                                                <div class="form-group">
                                                    <label for="">Email <span class="text-danger"></span></label>
                                                    <input type="text" class="form-control" name="email"
                                                        value="{{ $contact?->email }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Address <span class="text-danger"></span></label>
                                                    <textarea name="address" class="form-control" rows="3">{!! $contact?->address !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Map Link <span
                                                            class="text-danger"></span></label>
                                                    <textarea name="map_link" class="form-control" rows="3">{!! $contact?->map_link !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <div class="form-layout-footer" style="float:right;">
                                                    <button type="submit" class="btn btn-primary bd-0 submit-spinner"> Update </button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="equalhousing_tab" class="tab-pane" data-tab-content>
                    <section id="equalhosuing" data-tab-content class="p-0">
                        <div class="container py-1">
                            <p class="mb-1 mt-1 float-right"> <a class="btn btn-primary" href="{{ route('admin-add-housing')}}"> Add Equal Housing </a></p>
                        </div>
                        <div class="settings-vertical-tabs-container">

                            <div class="settings-vertical-tabs">
                                @foreach($equalhousing as $index => $term)
                                <button class="settings-tab-link {{ $index == 0 ? 'settings-active' : '' }}"
                                    onclick="openSettingsTab(event, 'tab{{ $index }}', 'equalhosuing')">
                                    {{ $term->title }}
                                </button>

                                @endforeach
                            </div>

                            <div class="settings-vertical-tab-content">
                                @foreach($equalhousing as $index => $term)
                                <div id="tab{{ $index }}" class="settings-vertical-content {{ $index == 0 ? 'settings-active' : '' }}">
                                    <form class="equal-housing-form" data-id="{{ $term->id }}">
                                        <div class="form-row">
                                            <div class="form-group col-lg-12 col-md-12 col-12">
                                                <label class="font-weight-bold">Title</label>
                                                <input type="text" class="form-control" name="title" value="{{ $term->title }}">
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-12">
                                                <label class="font-weight-bold">Description <span class="text-danger"> * </span></label>
                                                <textarea class="form-control summernote" name="description">
                                                    {!! @$term->description !!}
                                                </textarea>
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-12 d-flex gap-2">
                                                <button type="submit" class="btn btn-primary update-btn submit-spinner">Update</button>
                                                <button type="button" class="btn btn-danger delete-cms-item" data-id="{{ $term->id }}" data-type="equal-housing">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>

                <div id="terms_tab" class="tab-pane" data-tab-content>
                     <section id="termsconditions" data-tab-content class="p-0">
                        <div class="container py-1">
                            <p class="mb-1 mt-1 float-right"> <a class="btn btn-primary" href="{{ route('admin-add-terms')}}"> Add Terms </a></p>
                        </div>
                        <div class="settings-vertical-tabs-container">
                            <div class="settings-vertical-tabs">
                                @foreach($terms as $index => $term)
                                <button class="settings-tab-link {{ $index == 0 ? 'settings-active' : '' }}"
                                    onclick="openSettingsTab(event, 'termstab{{ $index }}', 'termsconditions')">
                                    {{ $term->title }}
                                </button>

                                @endforeach
                            </div>

                            <div class="settings-vertical-tab-content">
                                @foreach($terms as $index => $term)
                                <div id="termstab{{ $index }}" class="settings-vertical-content {{ $index == 0 ? 'settings-active' : '' }}">
                                    <form class="termsandconditions" data-id="{{ $term->id }}">
                                        <div class="form-row">
                                            <div class="form-group col-lg-12 col-md-12 col-12">
                                                <label class="font-weight-bold">Title</label>
                                                <input type="text" class="form-control" name="title" value="{{ $term->title }}">
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-12">
                                                <label class="font-weight-bold">Description <span class="text-danger"> * </span></label>
                                                <textarea class="form-control summernote" name="description">
                                                    {!! @$term->description !!}
                                                </textarea>
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-12 d-flex gap-2">
                                                <button type="submit" class="btn btn-primary update-btn submit-spinner">Update</button>
                                                <button type="button" class="btn btn-danger delete-cms-item" data-id="{{ $term->id }}" data-type="terms">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>

                <div id="manager_terms_tab" class="tab-pane" data-tab-content>
                    <section id="managerterms" data-tab-content class="p-0">
                        <div class="container py-1">
                            <p class="mb-1 mt-1 float-right"> <a class="btn btn-primary" href="{{ route('admin-add-manager-terms')}}"> Add Manager Terms </a></p>
                        </div>
                        <div class="settings-vertical-tabs-container">
                            <div class="settings-vertical-tabs">
                                @foreach($managerterms as $index => $term)
                                <button class="settings-tab-link {{ $index == 0 ? 'settings-active' : '' }}"
                                    onclick="openSettingsTab(event, 'tabmanagerterms{{ $index }}', 'managerterms')">
                                    {{ $term->title }}
                                </button>

                                @endforeach
                            </div>

                            <div class="settings-vertical-tab-content">
                                @foreach($managerterms as $index => $term)
                                <div id="tabmanagerterms{{ $index }}" class="settings-vertical-content {{ $index == 0 ? 'settings-active' : '' }}">
                                    <form class="update-description-form" data-id="{{ $term->id }}">
                                        <div class="form-row">
                                            <div class="form-group col-lg-12 col-md-12 col-12">
                                                <label class="font-weight-bold">Title</label>
                                                <input type="text" class="form-control" name="title" value="{{ $term->title }}">
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-12">
                                                <label class="font-weight-bold">Description <span class="text-danger"> * </span></label>
                                                <textarea class="form-control summernote" name="description">
                                                    {!! @$term->description !!}
                                                </textarea>
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-12 d-flex gap-2">
                                                <button type="submit" class="btn btn-primary update-btn submit-spinner">Update</button>
                                                <button type="button" class="btn btn-danger delete-cms-item" data-id="{{ $term->id }}" data-type="manager-terms">Delete</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            
          </div><!-- card-body -->
        </div><!-- card -->
        
    </div>
</div>
@endsection
@push('adminscripts')
<script src="{{ asset('admin_asset/js/tabviewform.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    function openSettingsTab(event, tabId, section) {
        let sectionElement = document.getElementById(section);
        let contentElements = sectionElement.querySelectorAll(".settings-vertical-content");
        let tabButtons = sectionElement.querySelectorAll(".settings-tab-link");
        contentElements.forEach(content => content.classList.remove("settings-active"));
        tabButtons.forEach(tab => tab.classList.remove("settings-active"));
        document.getElementById(tabId).classList.add("settings-active");
        event.currentTarget.classList.add("settings-active");
    }

    $(document).ready(function() {
        var aboutusimage = "{{ asset(@$aboutus->image ?: 'img/no-img.jpg') }}";

        $('.summernote').summernote({
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style', 'clear']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#aboutdescription').summernote({
            tabsize: 2,
            height: 250
        });

        $('#about-image-preview').css({
            'background-image': `url(${aboutusimage})`,
            'background-size': 'cover',
            'background-position': 'center center',
            'background-repeat': 'no-repeat',
        });

        $('#about-image-upload').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#about-image-preview').css('background-image', `url(${e.target.result})`);
                };
                reader.readAsDataURL(file);
            }
        });

        $("#contactusCMS").submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var formData = $(this).serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submit-spinner').html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`).prop('disabled', true);
                },
                success: function(response) {
                    AdminToast.success(response.message || "Updated successfully");
                    $('.submit-spinner').html(`Update`).prop('disabled', false);
                },
                error: function(xhr) {
                    AdminToast.error("An error occurred. Please try again.");
                    $('.submit-spinner').html(`Update`).prop('disabled', false);
                },
            });
        });

        $("#updateaboutus").submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var formData = new FormData(this);

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submit-spinner').html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`).prop('disabled', true);
                },
                success: function(response) {
                    AdminToast.success(response.message || "Updated successfully");
                    $('.submit-spinner').html(`Update`).prop('disabled', false);
                },
                error: function(xhr) {
                    AdminToast.error("An error occurred. Please try again.");
                    $('.submit-spinner').html(`Update`).prop('disabled', false);
                },
            });
        });

        $('.update-description-form').on('submit', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            const formData = {
                _token: '{{ csrf_token() }}',
                id: id,
                title: $(this).find('input[name="title"]').val(),
                description: $(this).find('textarea[name="description"]').summernote('code')
            };

            $.ajax({
                url: `{{ route('admin-update-manager-terms')}}`,
                method: 'POST',
                data: formData,
                success: function(data) {
                    AdminToast.success(data.message || 'Updated successfully!');
                },
                error: function(xhr) {
                    AdminToast.error('An error occurred.');
                }
            });
        });

        $(document).on('submit', '.equal-housing-form', function(event) {
            // Corrected selector for equal housing submit
            event.preventDefault();
            const id = $(this).data('id');
            const formData = {
                _token: '{{ csrf_token() }}',
                id: id,
                title: $(this).find('input[name="title"]').val(),
                description: $(this).find('textarea[name="description"]').summernote('code')
            };

            $.ajax({
                url: `{{ route('admin-update-equal-housing')}}`,
                method: 'POST',
                data: formData,
                success: function(data) {
                    AdminToast.success(data.message || 'Updated successfully!');
                },
                error: function(xhr) {
                    AdminToast.error('An error occurred.');
                }
            });
        });

        $(document).on('submit', '.termsandconditions', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            const formData = {
                _token: '{{ csrf_token() }}',
                id: id,
                title: $(this).find('input[name="title"]').val(),
                description: $(this).find('textarea[name="description"]').summernote('code')
            };

            $.ajax({
                url: `{{ route('admin-update-terms')}}`,
                method: 'POST',
                data: formData,
                success: function(data) {
                    AdminToast.success(data.message || 'Updated successfully!');
                },
                error: function(xhr) {
                    AdminToast.error('An error occurred.');
                }
            });
        });

        $(document).on('click', '.delete-cms-item', function() {
            const id = $(this).data('id');
            const type = $(this).data('type');
            let url = '';
            
            if (type === 'equal-housing') url = "{{ route('admin-delete-equal-housing', ['id' => ':id']) }}";
            else if (type === 'terms') url = "{{ route('admin-delete-terms', ['id' => ':id']) }}";
            else if (type === 'manager-terms') url = "{{ route('admin-delete-manager-terms', ['id' => ':id']) }}";
            
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--primary-color)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                AdminToast.success(data.message);
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                AdminToast.error(data.message);
                            }
                        },
                        error: function() {
                            AdminToast.error('An error occurred.');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
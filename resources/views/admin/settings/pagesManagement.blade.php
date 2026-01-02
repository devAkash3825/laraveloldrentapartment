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
            <h6 class="slim-pagetitle"> Menu Management </h6>
        </div>
        <div class="section-wrapper">
            <nav>
                <ul class="tabs">
                    <!-- <li class="tab-li">
                        <a href="#aboutus" class="tab-li__link">About Us </a>
                    </li> -->
                    <li class="tab-li">
                        <a href="#contactus" class="tab-li__link">Contact Us </a>
                    </li>
                    <li class="tab-li">
                        <a href="#equalhosuing" class="tab-li__link">Equal Housing </a>
                    </li>
                    <li class="tab-li">
                        <a href="#termsconditions" class="tab-li__link">Privacy Policies </a>
                    </li>
                    <li class="tab-li">
                        <a href="#managerterms" class="tab-li__link">Manager Policies </a>
                    </li>
                </ul>
            </nav>

            <!-- <section id="aboutus" data-tab-content class="p-0">
                <form action="{{ route('admin-update-about-us') }}" method="POST" enctype="multipart/form-data" id="updateaboutus">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Site Logo <span class="text-danger"></span></label>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label" class="image-hover-label">Choose File</label>
                                    <input type="file" name="background" id="image-upload" style="display: none;" onchange="previewImage(event)" />
                                    <input type="hidden" name="old_background" value="{{ $settings['logo'] }}" />
                                    <img id="image-preview-display" src="{{ asset($settings['logo']) }}" alt="Preview" style="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label for="">Title <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="title" value="{{ @$aboutus->title }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Heading <span class="text-danger"></span></label>
                                <input type="text" class="form-control" name="heading" value="{{ @$aboutus->heading }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Status <span class="text-danger"></span></label>
                                <select name="site_timezone" class="form-control select2">
                                    <option value="">Select Status</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for=""> Description <span class="text-danger"></span></label>
                                <textarea id="aboutdescription" name="aboutdescription" class="form-control">
                                    {!! @$aboutus->description !!}
                                </textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-4">
                            <div class="form-layout-footer" style="float: right;">
                                <button type="submit" class="btn btn-primary bd-0 submit-spinner" id="update-titles">Update</button>
                            </div>
                        </div>
                    </div>
                </form>

            </section> -->

            <section id="contactus" data-tab-content class="p-0">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin-contact-update') }}" method="POST"
                                    enctype="multipart/form-data" id="contactusCMS">
                                    <div class="row mt-3">
                                        <div class="col-12 mt-3">
                                            <div class="form-group">
                                                <label for="">Phone <span class="text-danger"></span></label>
                                                <input type="text" class="form-control" name="phone"
                                                    value="{{ $contact?->phone }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Email <span class="text-danger"></span></label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ $contact?->email }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Address <span class="text-danger"></span></label>
                                                <textarea name="address" class="form-control">{!! $contact?->address !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Map Link <span
                                                        class="text-danger"></span></label>
                                                <textarea name="map_link" class="form-control">{!! $contact?->map_link !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <div class="form-layout-footer" style="float:right;">
                                                <button type="submit" class="btn btn-primary bd-0 submit-spinner"
                                                    id="update-titles"> Update </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="equalhosuing" data-tab-content class="p-0">
                <div class="container py-1">
                    <p class="mb-1 mt-1 float-right"> <a class="btn btn-primary" href="{{ route('admin-add-housing')}}"> Add Equal Housing </button></a>
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
                            <form class="equal-housing-form" data-tab="{{ $index }}" onsubmit="submitDescription(event)">
                                <div class="form-row">
                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <label for="title{{ $index }}" class="font-weight-bold">Title</label>
                                        <input type="text" class="form-control" id="title{{ $index }}" name="title" value="{{ $term->title }}">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <label for="equalhousing{{ $index }}" class="font-weight-bold">Description <span class="text-danger"> * </span></label>
                                        <textarea class="form-control" id="equalhousing{{ $index }}" name="equalhousing">
                                            {!! @$term->description !!}
                                        </textarea>
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="btn btn-primary update-btn submit-spinner" data-tab="{{ $index }}">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="termsconditions" data-tab-content class="p-0">
                <div class="container py-1">
                    <p class="mb-1 mt-1 float-right"> <a class="btn btn-primary" href="{{ route('admin-add-terms')}}"> Add Terms </button></a>
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
                            <form class="termsandconditions" data-tab="{{ $index }}" onsubmit="submitDescription(event)">
                                <div class="form-row">
                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <label for="title{{ $index }}" class="font-weight-bold">Title</label>
                                        <input type="text" class="form-control" id="termstitle{{ $index }}" name="title" value="{{ $term->title }}">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <label for="termscms{{ $index }}" class="font-weight-bold">Description <span class="text-danger"> * </span></label>
                                        <textarea class="form-control" id="termscms{{ $index }}" name="termscms">
                                            {!! @$term->description !!}
                                        </textarea>
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="btn btn-primary update-btn submit-spinner" data-tab="{{ $index }}">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="managerterms" data-tab-content class="p-0">
                <div class="container py-1">
                    <p class="mb-1 mt-1 float-right"> <a class="btn btn-primary" href="{{ route('admin-add-manager-terms')}}"> Add Manager Terms </button></a>
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
                            <form class="update-description-form" data-tab="{{ $index }}" onsubmit="submitDescription(event)">
                                <div class="form-row">
                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <label for="title{{ $index }}" class="font-weight-bold">Title</label>
                                        <input type="text" class="form-control" id="title{{ $index }}" name="title" value="{{ $term->title }}">
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <label for="managertermsdescription{{ $index }}" class="font-weight-bold">Description <span class="text-danger"> * </span></label>
                                        <textarea class="form-control" id="managertermsdescription{{ $index }}" name="managertermsdescription">
                                            {!! @$term->description !!}
                                        </textarea>
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="btn btn-primary update-btn submit-spinner" data-tab="{{ $index }}">Update</button>
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
</div>
@endsection
@push('adminscripts')
<script src="{{ asset('admin_asset/js/tabviewform.js') }}"></script>
<script src="{{ asset('admin_asset/js/jquery.uploadPreview.min.js') }}"></script>
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
        var aboutimage = null;
        var aboutusimage = "{{ asset(config('settings.logo', 'img/no-img.jpg')) }}";
        var logoimageurl = "{{ asset(config('settings.logo', 'img/no-img.jpg')) }}";
        var faviconimageurl = "{{ asset(config('settings.favicon', 'img/no-img.jpg')) }}";

        $('#aboutdescription').summernote({
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

        $('[id^=managertermsdescription]').each(function() {
            $(this).summernote({
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

        $('[id^=equalhousing]').each(function() {
            $(this).summernote({
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

        $('[id^=termscms]').each(function() {
            $(this).summernote({
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

        $('#image-upload').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // $('#image-preview-display').attr('src', '__');
                    $('#image-preview-display').css({
                        'visibility': 'hidden',
                    });
                    $('#image-preview').css({
                        'background-image': `url(${e.target.result})`,
                        'background-size': 'contain',
                        'background-position': 'center center',
                        'background-repeat': 'no-repeat',
                    });
                };
                console.log("sent file", file);
                reader.readAsDataURL(file);
            }
            aboutimage = event.target.files[0];
        });

        $('#image-favicon-preview').css({
            'background-image': `url(${faviconimageurl})`,
            'background-size': 'contain',
            'background-position': 'center center',
            'background-repeat': 'no-repeat',
        });

        $('#image-upload-favicon').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-favicon-preview').css('background-image', `url(${e.target.result})`);
                };
                reader.readAsDataURL(file);
            }
        });

        $("#contactusCMS").submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin-update-contactusCMS') }}";
            var formData = $(this).serialize();
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.read_btn').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submitting...`
                    )
                    $('.read_btn').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        toastr.success(response.message);
                        $("#submitcontactus")[0].reset();
                        $('.read_btn').html(`Submit`)
                        $('.read_btn').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error("An error occurred. Please try again.");
                    $('.read_btn').html(
                        `Submit`
                    )
                    $('.read_btn').prop('disabled', false);
                },
            });

            $(this).addClass('was-validated');
        });

        $("#updateaboutus").submit(function(e) {
            e.preventDefault();
            console.log("aboutimage:", aboutimage);

            var url = "{{ route('admin-update-about-us') }}";
            var formData = new FormData(this);


            if (aboutimage instanceof File) {
                formData.append('background', aboutimage);
            }

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
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    );
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        toastr.success(response.message);
                        $("#updateaboutus")[0].reset();
                        $('.submit-spinner').html(`Update`);
                        $('.submit-spinner').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error("An error occurred. Please try again.");
                    $('.submit-spinner').html(`Update`);
                    $('.submit-spinner').prop('disabled', false);
                },
            });

            $(this).addClass('was-validated');
        });

        $('.update-description-form').on('submit', function(event) {
            event.preventDefault();

            const tabIndex = $(this).data('tab');
            const formData = {
                _token: '{{ csrf_token() }}',
                title: $('#title' + tabIndex).val(),
                description: $('#managerterms' + tabIndex).val(),
                index: tabIndex
            };

            $.ajax({
                url: `{{ route('admin-update-manager-terms')}}`,
                method: 'POST',
                data: formData,
                success: function(data) {
                    if (data.success) {
                        $('#tab' + tabIndex + ' .form-group input[name="title"]').val(formData.title);
                        $('#tab' + tabIndex + ' .form-group textarea[name="managerterms"]').val(formData.description);
                        alert('Description updated successfully!');
                    } else {
                        alert('Error updating description. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        $('.equal-housing-form').on('submit', function(event) {
            event.preventDefault();
            const tabIndex = $(this).data('tab');
            const formData = {
                _token: '{{ csrf_token() }}',
                title: $('#title' + tabIndex).val(),
                description: $('#equalhousing' + tabIndex).val(),
                index: tabIndex
            };

            $.ajax({
                url: `{{ route('admin-update-equal-housing')}}`,
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    );
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        toastr.success(response.message);
                        $('.submit-spinner').html(`Update`);
                        $('.submit-spinner').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error("An error occurred. Please try again.");
                    $('.submit-spinner').html(`Update`);
                    $('.submit-spinner').prop('disabled', false);
                },
            });
        });

        $('.termsandconditions').on('submit', function(event) {
            event.preventDefault();
            const tabIndex = $(this).data('tab');
            const formData = {
                _token: '{{ csrf_token() }}',
                title: $('#termstitle' + tabIndex).val(),
                description: $('#termscms' + tabIndex).val(),
                index: tabIndex
            };

            $.ajax({
                url: `{{ route('admin-update-terms')}}`,
                method: 'POST',
                data: formData,
                success: function(data) {
                    if (data.success) {
                        $('#tab' + tabIndex + ' .form-group input[name="title"]').val(formData.title);
                        $('#tab' + tabIndex + ' .form-group textarea[name="termscms"]').val(formData.description);
                        alert('Description updated successfully!');
                    } else {
                        alert('Error updating description. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image-preview-display');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }


    });
</script>
@endpush
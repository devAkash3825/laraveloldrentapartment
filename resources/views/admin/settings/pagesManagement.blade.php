@extends('admin.layouts.app')
@section('content')
@push('style')
<link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block !important;
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

<div class="container">
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">CMS Management</li>
        </ol>
        <h6 class="slim-pagetitle">CMS Management</h6>
    </div>

    <div class="card card-table">
        <div class="card-body">

                <nav>
                    <ul class="tabs">
                        <li class="tab-li">
                            <a href="#equalhousing_tab" class="tab-li__link active">Equal Housing</a>
                        </li>
                        <li class="tab-li">
                            <a href="#terms_tab" class="tab-li__link">Terms & Conditions</a>
                        </li>
                        <li class="tab-li">
                            <a href="#manager_terms_tab" class="tab-li__link">Manager Terms</a>
                        </li>
                        <li class="tab-li">
                            <a href="#privacy_promise_tab" class="tab-li__link">Privacy Promise</a>
                        </li>
                    </ul>
                </nav>

                <div class="mt-3">
                    <div id="equalhousing_tab" class="tab-pane active" data-tab-content>
                        <section id="equalhosuing" class="p-0">
                            <div class="container py-3">
                                <div class="d-flex justify-content-end mb-3">
                                    <a class="btn btn-primary" href="{{ route('admin-add-housing')}}">Add Equal Housing</a>
                                </div>
                            </div>
                            @if(count($equalhousing) > 0)
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
                            @else
                            <div class="alert alert-info text-center" style="margin: 20px;">
                                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No Equal Housing entries found. Click "Add Equal Housing" button above to create one.</p>
                            </div>
                            @endif
                        </section>
                    </div>

                    <div id="terms_tab" class="tab-pane" data-tab-content>
                        <section id="termsconditions" class="p-0">
                            <div class="container py-3">
                                <div class="d-flex justify-content-end mb-3">
                                    <a class="btn btn-primary" href="{{ route('admin-add-terms')}}">Add Terms</a>
                                </div>
                            </div>
                            @if(count($terms) > 0)
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
                            @else
                            <div class="alert alert-info text-center" style="margin: 20px;">
                                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No Terms & Conditions found. Click "Add Terms" button above to create one.</p>
                            </div>
                            @endif
                        </section>
                    </div>

                    <div id="manager_terms_tab" class="tab-pane" data-tab-content>
                        <section id="managerterms" class="p-0">
                            <div class="container py-3">
                                <div class="d-flex justify-content-end mb-3">
                                    <a class="btn btn-primary" href="{{ route('admin-add-manager-terms')}}">Add Manager Terms</a>
                                </div>
                            </div>
                            @if(count($managerterms) > 0)
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
                            @else
                            <div class="alert alert-info text-center" style="margin: 20px;">
                                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No Manager Terms found. Click "Add Manager Terms" button above to create one.</p>
                            </div>
                            @endif
                        </section>
                    </div>

                    <div id="privacy_promise_tab" class="tab-pane" data-tab-content>
                        <section id="privacypromise" class="p-0">
                            <div class="container py-3">
                                <div class="d-flex justify-content-end mb-3">
                                    <a class="btn btn-primary" href="{{ route('admin-add-privacy-promise')}}">Add Privacy Promise</a>
                                </div>
                            </div>
                            @if(count($privacypromise) > 0)
                            <div class="settings-vertical-tabs-container">
                                <div class="settings-vertical-tabs">
                                    @foreach($privacypromise as $index => $term)
                                    <button class="settings-tab-link {{ $index == 0 ? 'settings-active' : '' }}"
                                        onclick="openSettingsTab(event, 'tabpp{{ $index }}', 'privacypromise')">
                                        {{ $term->title }}
                                    </button>
                                    @endforeach
                                </div>

                                <div class="settings-vertical-tab-content">
                                    @foreach($privacypromise as $index => $term)
                                    <div id="tabpp{{ $index }}" class="settings-vertical-content {{ $index == 0 ? 'settings-active' : '' }}">
                                        <form class="privacy-promise-form" data-id="{{ $term->id }}">
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
                                                    <button type="button" class="btn btn-danger delete-cms-item" data-id="{{ $term->id }}" data-type="privacy-promise">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info text-center" style="margin: 20px;">
                                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No Privacy Promise entries found. Click "Add Privacy Promise" button above to create one.</p>
                            </div>
                            @endif
                        </section>
                    </div>
                </div>

        </div><!-- card-body -->
    </div><!-- card -->
</div><!-- container -->
@endsection
@push('adminscripts')
<script src="{{ asset('admin_asset/js/tabviewform.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    // Main tab switching logic (for About Us, Contact Us, Equal Housing, etc.)
    $(document).on('click', '.tab-li__link', function (e) {
        e.preventDefault();

        // Remove active classes from all tabs and panes
        $('.tab-li__link').removeClass('active');
        $('.tab-pane').removeClass('active');

        // Activate clicked tab
        $(this).addClass('active');
        const target = $(this).attr('href');
        $(target).addClass('active');
    });

    // Vertical tabs switching logic (for inner CMS content)
    function openSettingsTab(event, tabId, section) {
        event.preventDefault();

        let sectionElement = document.getElementById(section);
        if (!sectionElement) return; // ✅ PREVENT JS CRASH

        let contentElements = sectionElement.querySelectorAll(".settings-vertical-content");
        let tabButtons = sectionElement.querySelectorAll(".settings-tab-link");
        contentElements.forEach(content => content.classList.remove("settings-active"));
        tabButtons.forEach(tab => tab.classList.remove("settings-active"));
        document.getElementById(tabId).classList.add("settings-active");
        event.currentTarget.classList.add("settings-active");
    }

    $(document).ready(function() {
        // Initialize Summernote for all CMS description fields
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

        // Manager Terms form handler
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

        $(document).on('submit', '.privacy-promise-form', function(event) {
            event.preventDefault();
            const id = $(this).data('id');
            const formData = {
                _token: '{{ csrf_token() }}',
                id: id,
                title: $(this).find('input[name="title"]').val(),
                description: $(this).find('textarea[name="description"]').summernote('code')
            };

            $.ajax({
                url: `{{ route('admin-update-privacy-promise')}}`,
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
            else if (type === 'privacy-promise') url = "{{ route('admin-delete-privacy-promise', ['id' => ':id']) }}";

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
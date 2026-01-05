@extends('user.layout.app')

@section('title', 'Favorite Properties | List View')

@section('content')
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Saved Properties</h1>
                <p class="text-white opacity-75 lead mb-0">Manage all your saved apartments in one place</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Collection</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section id="dashboard" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="dashboard_content">
                    <div class="mb-4">
                        <x-favorite-sidebar />
                    </div>
                    
                    <div class="my_listing list_padding bg-white rounded-1 shadow-sm p-4 border">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <h4 class="fw-bold mb-0 text-dark">My Collection</h4>
                            <button class="btn btn-danger btn-sm rounded-1 px-3" id="delete-selected" style="display:none;">
                                <i class="fa-solid fa-trash-can me-2"></i> Remove Selected
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="fav-listview" class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="30" class="border-0 rounded-start"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                        <th class="border-0 fw-bold text-uppercase small text-muted">Apartment Details</th>
                                        <th width="180" class="border-0 fw-bold text-uppercase small text-muted">Quick Inquiry</th>
                                        <th width="150" class="border-0 fw-bold text-uppercase small text-muted text-center rounded-end">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Check if DataTables is already initialized to avoid warning
    if ($.fn.DataTable.isDataTable('#fav-listview')) {
        $('#fav-listview').DataTable().destroy();
    }

    var table = $('#fav-listview').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('list-view') }}",
        columns: [
            { data: 'id', name: 'id', orderable: false, searchable: false,
                render: function(data) {
                    return '<input type="checkbox" class="form-check-input row-checkbox" value="' + data + '">';
                }
            },
            { data: 'propertyname', name: 'propertyname' },
            { data: 'quote', name: 'quote', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: 'Search by name...',
            lengthMenu: 'Show _MENU_',
            info: "Showing _START_ to _END_ of _TOTAL_ properties",
            paginate: {
                previous: '<i class="fa-solid fa-chevron-left"></i>',
                next: '<i class="fa-solid fa-chevron-right"></i>'
            },
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        },
        pageLength: 10,
        drawCallback: function() {
            // Re-initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Clean up any lingering tooltips from previous page
            $('.tooltip').remove();
        }
    });

    // Select All functionality
    $('#selectAll').on('click', function() {
        $('.row-checkbox').prop('checked', this.checked);
        toggleDeleteBtn();
    });

    $(document).on('change', '.row-checkbox', function() {
        var total = $('.row-checkbox').length;
        var checked = $('.row-checkbox:checked').length;
        $('#selectAll').prop('checked', total === checked && total > 0);
        toggleDeleteBtn();
    });

    function toggleDeleteBtn() {
        var count = $('.row-checkbox:checked').length;
        if (count > 0) {
            $('#delete-selected').html('<i class="fa-solid fa-trash-can me-2"></i> Remove Selected (' + count + ')').fadeIn();
        } else {
            $('#delete-selected').fadeOut();
        }
    }

    // Bulk Remove
    $('#delete-selected').on('click', function() {
        var ids = [];
        $('.row-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) return;

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to remove " + ids.length + " properties from your favorites?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('bulk-remove-favorites') }}",
                    method: "POST",
                    data: { ids: ids },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Removed!',
                                response.message,
                                'success'
                            )
                            table.ajax.reload(null, false);
                            $('#selectAll').prop('checked', false);
                            toggleDeleteBtn();
                        }
                    }
                });
            }
        });
    });

    // Single Remove from table
    $(document)
        .off('click', '.remove-single-fav') // Remove any old handlers
        .on('click', '.remove-single-fav', function() {
            var id = $(this).data('id');
            var $btn = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to remove this property from your favorites?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('add-to-favorite') }}",
                        method: "POST",
                        data: { propertyId: id },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Removed!',
                                    response.message,
                                    'success'
                                )
                                table.ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
});
</script>
<style>
    /* Premium List View Styles */
    .dashboard_content .table thead th {
        font-weight: 600;
        background-color: #f8f9fa;
        padding: 15px;
    }
    
    .dashboard_content .table tbody td {
        padding: 15px;
        vertical-align: middle;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        cursor: pointer;
    }
    
    .form-check-input:checked {
        background-color: var(--colorPrimary);
        border-color: var(--colorPrimary);
    }

    .fav-link-name {
        text-decoration: none !important;
        color: #1e293b;
        font-weight: 600;
        transition: color 0.2s;
    }
    
    .fav-link-name:hover {
        color: var(--colorPrimary);
    }

    .property-icon-wrapper {
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        border-radius: 4px; /* Square Premium */
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .fav-link-name {
        display: flex;
        align-items: center;
    }

    .fav-request-quote-btn {
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 4px; /* Square Premium */
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .fav-request-quote-btn:hover {
        background: #f8fafc;
        border-color: var(--colorPrimary);
        color: var(--colorPrimary);
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        border-radius: 4px; /* Square Premium */
        color: #64748b;
        background: #fff;
        transition: all 0.2s;
        text-decoration: none;
        margin-left: 5px;
    }

    .btn-icon:hover {
        background: var(--colorPrimary);
        border-color: var(--colorPrimary);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Keep Delete Red */
    .btn-delete:hover {
        background: #ef4444;
        border-color: #ef4444;
    }

    /* Clean up DataTables controls */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 4px;
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--colorPrimary);
        outline: none;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 4px !important;
        border: 1px solid #e2e8f0 !important;
        margin: 0 4px;
        padding: 6px 12px !important;
        background: #fff !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--colorPrimary) !important;
        color: #fff !important;
        border-color: var(--colorPrimary) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }
</style>
@endpush
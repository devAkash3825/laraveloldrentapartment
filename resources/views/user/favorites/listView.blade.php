@extends('user.layout.app')

@section('title', 'Favorite Properties | List View')

@push('style')
<style>
    :root {
        --table-border: #f1f5f9;
        --table-hover: #f8fafc;
        --text-main: #334155;
        --text-muted: #64748b;
    }

    .favorite-table-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        padding: 0; /* Remove internal container padding to allow table to reach edges if needed, or manage via cells */
        margin-top: 24px;
        border: 1px solid var(--table-border);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 30px;
        border-bottom: 1px solid var(--table-border);
        background: #fff;
    }

    .table-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

    #fav-listview {
        border-collapse: separate;
        border-spacing: 0;
        width: 100% !important;
        margin: 0 !important;
    }

    #fav-listview thead th {
        background: #fdfdfd;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.65rem;
        letter-spacing: 0.12em;
        padding: 16px 24px;
        border-bottom: 1px solid var(--table-border);
        border-top: none;
    }

    #fav-listview tbody tr {
        transition: all 0.2s ease;
    }

    #fav-listview tbody tr:hover {
        background-color: var(--table-hover);
    }

    #fav-listview tbody td {
        padding: 18px 24px;
        color: var(--text-main);
        font-size: 0.9rem;
        border-bottom: 1px solid var(--table-border);
        vertical-align: middle;
    }

    /* Custom Checkbox Styling - Removing default BG image and styling */
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0;
        cursor: pointer;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        transition: all 0.2s ease;
        background-image: none !important; /* Force remove default BG image */
        background-color: #fff;
        position: relative;
        appearance: none;
        -webkit-appearance: none;
    }

    .form-check-input:checked {
        background-color: var(--colorPrimary) !important;
        border-color: var(--colorPrimary) !important;
        background-image: none !important;
    }

    .form-check-input:checked::after {
        content: '';
        position: absolute;
        left: 6px;
        top: 2px;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        border-color: var(--colorPrimary);
    }

    .fav-link-name {
        color: #1e293b;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .property-icon-wrapper {
        width: 44px;
        height: 44px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }

    .fav-link-name:hover .property-icon-wrapper {
        background: #e2e8f0;
        color: #0f172a;
        transform: rotate(-5deg);
    }

    .property-name-text {
        font-size: 0.95rem;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .fav-request-quote-btn {
        background: #fff;
        color: var(--text-main);
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #e2e8f0;
    }

    .fav-request-quote-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #000;
    }

    .action-btns {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    /* DataTables wrapper padding */
    .dataTables_wrapper {
        padding: 0 20px 20px 20px;
    }

    .btn-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        text-decoration: none !important;
    }

    .btn-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .btn-view:hover { background: #3b82f6; color: #fff; border-color: #3b82f6; }
    .btn-map:hover { background: #10b981; color: #fff; border-color: #10b981; }
    .btn-chat:hover { background: #8b5cf6; color: #fff; border-color: #8b5cf6; }

    /* DataTables Custom Controls */
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 16px;
        font-size: 0.9rem;
        width: 250px;
        transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--colorPrimary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--text-muted);
        font-size: 0.85rem;
        padding-top: 20px;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding-top: 20px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        background: #fff !important;
        color: var(--text-main) !important;
        margin: 0 3px;
        padding: 6px 14px !important;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--colorPrimary) !important;
        color: #fff !important;
        border-color: var(--colorPrimary) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
        color: var(--text-main) !important;
    }

    .form-check-input:checked {
        background-color: var(--colorPrimary);
        border-color: var(--colorPrimary);
    }

    /* Remove DataTables sorting arrows from checkbox columns (the 'mountain' type icons) */
    table.dataTable thead th.sorting_disabled::before,
    table.dataTable thead th.sorting_disabled::after {
        display: none !important;
    }

    #fav-listview thead th:first-child {
        background-image: none !important;
        cursor: default;
    }

    /* Clean solid breadcrumb instead of mountain image */
    #breadcrumb_part {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        height: 180px !important;
        display: flex;
        align-items: center;
        border-bottom: 4px solid var(--colorPrimary);
    }

    .bread_overlay {
        background: none !important;
    }
</style>
@endpush

@section('content')
<div id="breadcrumb_part">
    <div class="bread_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center text-white">
                    <h1 class="fw-bold mb-2" style="font-size: 2.2rem; letter-spacing: -1px;">Saved Properties</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                            <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Collection</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="dashboard" class="py-5 bg-light" style="min-height: 80vh;">
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
                    
                    <div class="favorite-table-container">
                        <div class="table-header">
                            <div>
                                <h2 class="table-title">My Collection</h2>
                                <p class="text-muted small mb-0 mt-1">Manage all your saved apartments in one place</p>
                            </div>
                            <button class="btn btn-danger btn-sm rounded-pill px-4" id="delete-selected" style="display:none; height: 38px;">
                                <i class="bi bi-trash-fill me-2"></i> Remove Selected
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="fav-listview" class="table">
                                <thead>
                                    <tr>
                                        <th width="30"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                        <th>Apartment Details</th>
                                        <th width="180">Quick Inquiry</th>
                                        <th width="150" class="text-center">Manage</th>
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
                previous: '<i class="bi bi-chevron-left"></i>',
                next: '<i class="bi bi-chevron-right"></i>'
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
            $('#delete-selected').html('<i class="bi bi-trash-fill me-2"></i> Remove Selected (' + count + ')').fadeIn();
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

        if (confirm('Are you sure you want to remove ' + ids.length + ' properties from your favorites?')) {
            $.ajax({
                url: "{{ route('bulk-remove-favorites') }}",
                method: "POST",
                data: { ids: ids },
                success: function(response) {
                    if (response.success) {
                        toastr.info('<i class="bi bi-heart me-2"></i>' + response.message);
                        table.ajax.reload(null, false);
                        $('#selectAll').prop('checked', false);
                        toggleDeleteBtn();
                    }
                }
            });
        }
    });

    // Single Remove from table
    $(document)
        .off('click', '.remove-single-fav') // Remove any old handlers
        .on('click', '.remove-single-fav', function() {
            var id = $(this).data('id');
            var $btn = $(this);

            if (confirm('Remove this property from your favorites?')) {
                $.ajax({
                    url: "{{ route('add-to-favorite') }}",
                    method: "POST",
                    data: { propertyId: id },
                    success: function(response) {
                        if (response.success) {
                            toastr.info('<i class="bi bi-heart me-2"></i>' + response.message);
                            table.ajax.reload(null, false);
                        }
                    }
                });
            }
        });
});
</script>
@endpush
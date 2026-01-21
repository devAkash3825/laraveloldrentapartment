@extends('user.layout.app')

@section('title', 'Favorite Properties | List View')

@section('content')
<!-- Premium Header -->
<div class="header-premium-gradient">
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

<section id="dashboard" class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9 ps-lg-4">
                <div class="dashboard_content">
                    <div class="mb-5">
                        <x-favorite-sidebar />
                    </div>
                    
                    <div class="recent-table-container">
                        <div class="table-header-box d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="table-title">My Collection</h2>
                                <p class="text-muted small mb-0 mt-1">Manage your saved apartment listings</p>
                            </div>
                            <button class="btn btn-danger btn-sm rounded-3 px-3 py-2 fw-bold shadow-sm" id="delete-selected" style="display:none;">
                                <i class="fa-solid fa-trash-can me-2"></i> Remove Selected
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="fav-listview" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                        <th width="350">Apartment Details</th>
                                        <th width="150" class="text-center">Quick Inquiry</th>
                                        <th width="220" class="text-center">Manage</th>
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

<!-- Notes Modal -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-clipboard-list me-2"></i>Property Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="notes-container" class="p-4" style="height: 350px; overflow-y: auto; background: #f8f9fa;">
                    <!-- Notes will be loaded here -->
                    <div class="text-center text-muted mt-5">Loading notes...</div>
                </div>
                <div class="p-3 border-top bg-white">
                    <form id="add-note-form">
                        <input type="hidden" id="note-property-id">
                        <div class="input-group">
                            <input type="text" class="form-control" id="note-message" placeholder="Type a note here... (e.g. 'Unit 4B available?')" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fa-solid fa-paper-plane me-1"></i> Add Note
                            </button>
                        </div>
                        <small class="text-muted mt-1 d-block ">Tip: Your notes are visible to the Property Manager and Admin.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
        searching: false,
        lengthChange: false,
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
            processing: '<div class="d-flex flex-column align-items-center justify-content-center mt-4"><div class="spinner-border text-primary mb-2" role="status"></div><span class="text-muted fw-bold">Updating collection...</span></div>',
            emptyTable: '<div class="text-center p-5"><i class="fa-solid fa-heart-circle-xmark fa-3x mb-3 text-muted"></i><h5 class="fw-bold">No saved properties</h5><p class="text-muted mb-0">Browse our listings and save your favorite apartments.</p></div>'
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
    
    // Open Notes Modal
    $(document).on('click', '.btn-notes', function() {
         var id = $(this).data('id');
         $('#note-property-id').val(id);
         $('#notesModal').modal('show');
         loadNotes(id);
    });

    // Load Notes Function
    function loadNotes(propertyId) {
        $('#notes-container').html('<div class="text-center text-muted mt-5"><i class="fa-solid fa-spinner fa-spin fa-2x"></i><br>Loading conversation...</div>');
        
        $.ajax({
            url: "{{ route('get-notes-detail') }}",
            method: "POST",
            data: { 
                propertyId: propertyId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                var html = '';
                if(response.notedetails && response.notedetails.length > 0) {
                    html += '<ul class="list-unstyled">';
                    $.each(response.notedetails, function(index, note) {
                        // User Type Logic: Blue(Admin), Black(Manager), Red(Renter)
                        var userClass = note.color_class; // calculated in controller
                        var date = new Date(note.send_time).toLocaleString();
                        
                        html += '<li class="mb-3 bg-white p-3 rounded shadow-sm border-start border-4 ' + (userClass == "text-primary" ? "border-primary" : (userClass == "text-dark" ? "border-dark" : "border-danger")) + '">';
                        html += '<div class="d-flex justify-content-between mb-1">';
                        html += '<strong class="' + userClass + '"><i class="fa-solid fa-user-circle me-1"></i> ' + note.sender_name + '</strong>';
                        html += '<small class="text-muted">' + date + '</small>';
                        html += '</div>';
                        html += '<p class="mb-0 text-secondary">' + note.message + '</p>';
                        html += '</li>';
                    });
                    html += '</ul>';
                } else {
                    html = '<div class="text-center text-muted mt-5"><i class="fa-regular fa-comment-dots fa-3x mb-3 opacity-50"></i><br>No notes yet. Start the conversation!</div>';
                }
                $('#notes-container').html(html);
                var d = $('#notes-container');
                d.scrollTop(d.prop("scrollHeight"));
            },
            error: function() {
                $('#notes-container').html('<div class="text-center text-danger mt-5">Failed to load notes. Use functionality is currently in beta.</div>');
            }
        });
    }

    // Add Note Form Submit
    $('#add-note-form').on('submit', function(e) {
        e.preventDefault();
        var msg = $('#note-message').val();
        var pid = $('#note-property-id').val();
        
        if(!msg.trim()) return;

        $.ajax({
            url: "{{ route('add-notes') }}",
            method: "POST",
            data: {
                propertyId: pid,
                message: msg,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success) {
                    $('#note-message').val('');
                    loadNotes(pid); // Reload to show new note
                }
            },
            error: function() {
                Swal.fire('Error', 'Could not save note.', 'error');
            }
        });
    });
});

</script>
<style>
    :root {
        --table-border: #f1f5f9;
        --table-hover: #f8fafc;
        --text-main: #334155;
        --text-muted: #64748b;
    }

    .recent-table-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--table-border);
        overflow: hidden;
    }

    .table-header-box {
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

    .custom-table {
        margin-bottom: 0 !important;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
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

    .custom-table tbody td {
        padding: 18px 24px;
        color: var(--text-main);
        font-size: 0.9rem;
        border-bottom: 1px solid var(--table-border);
        vertical-align: middle;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .custom-table tbody tr:hover {
        background-color: var(--table-hover);
    }

    .prop-link {
        color: #1e293b;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .icon-box {
        width: 44px;
        height: 44px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .prop-link:hover {
        color: var(--colorPrimary);
    }

    .prop-link:hover .icon-box {
        background: var(--colorPrimary);
        color: #fff;
        transform: rotate(-5deg);
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

    .fav-request-quote-btn {
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .fav-request-quote-btn:hover {
        background: var(--table-hover);
        border-color: var(--colorPrimary);
        color: var(--colorPrimary);
        transform: translateY(-2px);
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        color: #64748b;
        background: #fff;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-decoration: none;
        margin: 0 3px;
    }

    .btn-icon:hover {
        background: var(--colorPrimary);
        border-color: var(--colorPrimary);
        color: #fff !important;
        transform: scale(1.1) translateY(-3px);
        box-shadow: 0 5px 15px rgba(var(--colorPrimaryRgb), 0.3);
    }

    .btn-delete:hover {
        background: #ef4444 !important;
        border-color: #ef4444 !important;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_info {
        padding: 24px 30px;
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.85rem;
        border-top: 1px solid var(--table-border);
    }

    .dataTables_wrapper .dataTables_paginate {
        padding: 15px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 10px !important;
        border: 1px solid #e2e8f0 !important;
        margin: 0 4px;
        padding: 8px 16px !important;
        background: #fff !important;
        font-weight: 700 !important;
        color: var(--text-main) !important;
        transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background: var(--table-hover) !important;
        border-color: #cbd5e1 !important;
        color: var(--colorPrimary) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--colorPrimary) !important;
        color: #fff !important;
        border-color: var(--colorPrimary) !important;
        box-shadow: 0 4px 12px rgba(var(--colorPrimaryRgb), 0.3);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5;
        background: #f8fafc !important;
    }

    .spinner-border-premium {
        width: 3rem;
        height: 3rem;
        border-width: 0.25em;
        color: var(--colorPrimary);
    }
</style>
@endpush
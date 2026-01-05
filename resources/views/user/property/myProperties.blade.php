@extends('user.layout.app')
@section('title', 'RentApartements | My Properties')

@push('style')
<style>
    /* Square Premium Button Override for this page specifically if needed */
    .btn-sm-premium {
        padding: 8px 16px; 
        font-size: 0.9rem;
        border-radius: 4px; /* Square Premium */
    }

    /* Custom Table Styles matching Favorites List View */
    .custom-premium-table thead th {
        font-weight: 600;
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        padding: 16px 24px;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-premium-table tbody td {
        padding: 16px 24px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .custom-premium-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn-edit:hover { background: #3b82f6; color: #fff; border-color: #3b82f6; }
    
    /* Pagination Styles */
    .custom-pagination-premium .page-link {
        border-radius: 4px; /* Square Premium */
        margin: 0 4px;
        border: 1px solid #e2e8f0;
        color: #334155;
        padding: 8px 16px;
        font-weight: 600;
    }

    .custom-pagination-premium .page-item.active .page-link {
        background-color: var(--colorPrimary);
        border-color: var(--colorPrimary);
        color: #fff;
    }

    .custom-pagination-premium .page-link:hover {
        background-color: #f1f5f9;
        color: var(--colorPrimary);
    }
    
    .custom-pagination-premium .page-item.active .page-link:hover {
        color: #fff;
        background-color: var(--colorPrimary);
    }
</style>
@endpush

@section('content')

<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">My Properties</h1>
                <p class="text-white opacity-75 lead mb-0">Manage and track your property listings</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">My Properties</li>
                    </ol>
                </nav>
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
                    <div class="favorite-table-container bg-white rounded-1 shadow-sm border overflow-hidden">
                        <div class="table-header d-flex justify-content-between align-items-center bg-white p-4 border-bottom">
                            <div>
                                <h2 class="table-title fw-bold text-dark fs-4 mb-1">Listed Properties</h2>
                                <p class="text-muted small mb-0">Review and manage your active property listings</p>
                            </div>
                            <a href="{{ route('add-property') }}" class="read_btn btn-sm-premium text-decoration-none">
                                <i class="fa-solid fa-circle-plus me-2"></i> Add New Property
                            </a>
                        </div>

                        <div class="table-responsive">
                            @if(count($paginatedRecords) > 0)
                            <table class="table custom-premium-table mb-0" id="my-properties-table">
                                <thead>
                                    <tr>
                                        <th width="80">S.No</th>
                                        <th width="120">Preview</th>
                                        <th>Property Details</th>
                                        <th width="120">Status</th>
                                        <th width="150" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginatedRecords as $row)
                                    <tr>
                                        <td class="align-middle fw-600 text-muted">#{{ $loop->iteration + ($paginatedRecords->currentPage() - 1) * $paginatedRecords->perPage() }}</td>
                                        <td class="align-middle">
                                            <div class="property-img-wrapper">
                                                @if (isset($row->gallerytype->gallerydetail[0]->ImageName))
                                                    <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $row->Id }}/Original/{{ $row->gallerytype->gallerydetail[0]->ImageName }}" 
                                                         alt="Property" class="rounded-1 shadow-sm border-0" style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('img/No_Image_Available.jpg') }}" alt="No Image" class="rounded-1 shadow-sm border-0" style="width: 80px; height: 60px; object-fit: cover;">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('property-display', ['id' => $row->Id]) }}" class="fw-bold text-dark text-decoration-none mb-1 fs-6 fav-link-name">{{ $row->PropertyName ?? 'N/A' }}</a>
                                                <span class="text-muted smaller" style="font-size: 0.8rem;"><i class="fa-solid fa-location-dot me-1 text-primary"></i> {{ $row->city->CityName ?? 'Unknown City' }}, {{ $row->city->state->StateShortName ?? 'ST' }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            @if ($row->Status == 1)
                                                <span class="badge rounded-1 bg-success-subtle text-success px-3 py-2 border border-success-subtle fw-bold">Active</span>
                                            @else
                                                <span class="badge rounded-1 bg-danger-subtle text-danger px-3 py-2 border border-danger-subtle fw-bold">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('property-display', ['id' => $row->Id]) }}" class="btn-icon btn-view fs-6" data-bs-toggle="tooltip" title="View Public Page">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('edit-properties', ['id' => $row->Id]) }}" class="btn-icon btn-edit fs-6" data-bs-toggle="tooltip" title="Edit Listing">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- Custom Pagination -->
                            @if ($paginatedRecords->lastPage() > 1)
                            <div class="p-4 d-flex justify-content-center bg-white border-top">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination custom-pagination-premium mb-0">
                                        <li class="page-item {{ $paginatedRecords->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $paginatedRecords->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a>
                                        </li>
                                        @for ($i = 1; $i <= $paginatedRecords->lastPage(); $i++)
                                            <li class="page-item {{ $paginatedRecords->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $paginatedRecords->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ $paginatedRecords->currentPage() == $paginatedRecords->lastPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $paginatedRecords->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            @endif

                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fa-solid fa-building-circle-exclamation text-muted display-1 opacity-25"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark">No properties found</h3>
                                    <p class="text-muted mb-4">You haven't listed any properties yet. Start your journey today.</p>
                                    <a href="{{ route('add-property') }}" class="read_btn rounded-1 px-4 text-decoration-none">
                                        <i class="fa-solid fa-circle-plus me-2"></i> List your first property
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush
@endsection

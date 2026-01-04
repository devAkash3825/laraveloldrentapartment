@extends('user.layout.app')
@section('title', 'RentApartements | My Properties')
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
                    <div class="favorite-table-container">
                        <div class="table-header d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="table-title">Listed Properties</h2>
                                <p class="text-muted small mb-0 mt-1">Review and manage your active property listings</p>
                            </div>
                            <a href="{{ route('add-property') }}" class="btn btn-primary btn-sm rounded-pill px-4" style="height: 38px; display: flex; align-items: center;">
                                <i class="bi bi-plus-circle me-2"></i> Add New Property
                            </a>
                        </div>

                        <div class="table-responsive">
                            @if(count($paginatedRecords) > 0)
                            <table class="table custom-premium-table" id="my-properties-table">
                                <thead>
                                    <tr>
                                        <th width="80">S.No</th>
                                        <th width="120">Preview</th>
                                        <th>Property Details</th>
                                        <th width="120">Status</th>
                                        <th width="150" class="text-center">Action</th>
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
                                                         alt="Property" class="rounded-3 shadow-sm border" style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('img/No_Image_Available.jpg') }}" alt="No Image" class="rounded-3 shadow-sm border" style="width: 80px; height: 60px; object-fit: cover;">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark">{{ $row->PropertyName ?? 'N/A' }}</span>
                                                <span class="text-muted smaller" style="font-size: 0.8rem;"><i class="bi bi-geo-alt me-1"></i> {{ $row->city->CityName ?? 'Unknown City' }}, {{ $row->city->state->StateShortName ?? 'ST' }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            @if ($row->Status == 1)
                                                <span class="badge rounded-pill bg-success-subtle text-success px-3 border border-success-subtle">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger-subtle text-danger px-3 border border-danger-subtle">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="action-btns">
                                                <a href="{{ route('property-display', ['id' => $row->Id]) }}" class="btn-icon btn-view" data-bs-toggle="tooltip" title="View Public Page">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('edit-properties', ['id' => $row->Id]) }}" class="btn-icon btn-edit" data-bs-toggle="tooltip" title="Edit Listing">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- Custom Pagination -->
                            @if ($paginatedRecords->lastPage() > 1)
                            <div class="mt-4 d-flex justify-content-center">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination custom-pagination-premium">
                                        <li class="page-item {{ $paginatedRecords->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $paginatedRecords->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                                        </li>
                                        @for ($i = 1; $i <= $paginatedRecords->lastPage(); $i++)
                                            <li class="page-item {{ $paginatedRecords->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $paginatedRecords->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ $paginatedRecords->currentPage() == $paginatedRecords->lastPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $paginatedRecords->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            @endif

                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-building-exclamation text-muted display-1"></i>
                                    </div>
                                    <h3>No properties found</h3>
                                    <p class="text-muted">You haven't listed any properties yet.</p>
                                    <a href="{{ route('add-property') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                                        <i class="bi bi-plus-circle me-1"></i> List your first property
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

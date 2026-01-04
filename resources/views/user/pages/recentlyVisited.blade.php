@extends('user.layout.app')

@section('title', 'RentApartments | Recently Visited')

@push('style')
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
        margin-top: 24px;
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

    .date-badge {
        background: #f0fdf4;
        color: #16a34a;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Custom Pagination Styling */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .pagination .page-item .page-link {
        border: 1px solid #e2e8f0;
        margin: 0 4px;
        border-radius: 10px;
        color: var(--text-main);
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--colorPrimary) !important;
        border-color: var(--colorPrimary) !important;
        color: #fff !important;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #f8fafc;
        color: #cbd5e1;
    }
</style>
@endpush

@section('content')
<div class="header-premium-gradient mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Recently Visited</h1>
                <p class="text-white opacity-75 lead mb-0">Your browsing history of perfect homes</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Browsing History</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section id="listing_grid" class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="dashboard_content">
                    <div class="recent-table-container">
                        <div class="table-header-box">
                            <h2 class="table-title">Browsing History</h2>
                            <p class="text-muted small mb-0 mt-1">Showing apartments you've recently viewed</p>
                        </div>

                        <div class="table-responsive">
                            @if(count($paginatedRecords) > 0)
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th width="80">#</th>
                                        <th>Property Details</th>
                                        <th width="200" class="text-center">Viewed On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginatedRecords as $row)
                                        <tr>
                                            <td>
                                                <span class="text-muted fw-bold">{{ str_pad($loop->iteration + ($paginatedRecords->currentPage() - 1) * $paginatedRecords->perPage(), 2, '0', STR_PAD_LEFT) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('property-display', ['id' => @$row->propertyinfo->Id]) }}" class="prop-link">
                                                    <div class="icon-box">
                                                        <i class="bi bi-clock-history"></i>
                                                    </div>
                                                    <div>
                                                        <div class="prop-name">{{ @$row->propertyinfo->PropertyName ?? 'N/A' }}</div>
                                                        <div class="text-muted smaller" style="font-size: 0.8rem;">
                                                            <i class="bi bi-geo-alt me-1"></i>{{ @$row->propertyinfo->Address }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <span class="date-badge">
                                                    <i class="bi bi-calendar-event"></i>
                                                    {{ @$row->lastviewed ? $row->lastviewed->format('M d, Y') : 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="p-5 text-center">
                                    @include('user.partials.no_record_found')
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($paginatedRecords->lastPage() > 1)
                        <div class="pagination-wrapper">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $paginatedRecords->currentPage() == 1 ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $paginatedRecords->currentPage() == 1 ? 'javascript:void(0);' : $paginatedRecords->url($paginatedRecords->currentPage() - 1) }}">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                    
                                    @for ($i = 1; $i <= $paginatedRecords->lastPage(); $i++)
                                        <li class="page-item {{ $paginatedRecords->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $paginatedRecords->url($i) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
                                        </li>
                                    @endfor

                                    <li class="page-item {{ $paginatedRecords->currentPage() == $paginatedRecords->lastPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $paginatedRecords->currentPage() == $paginatedRecords->lastPage() ? 'javascript:void(0);' : $paginatedRecords->url($paginatedRecords->currentPage() + 1) }}">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


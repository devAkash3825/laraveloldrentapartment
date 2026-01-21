@extends('user.layout.app')
@section('content')
@section('title', 'RentApartment | Message Center')

<style>
    .message-center-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        border: none;
    }
    .message-center-header {
        background: var(--colorPrimary);
        padding: 30px;
        color: #fff;
    }
    .message-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        cursor: pointer;
    }
    .message-item:hover {
        background-color: #f8fafc;
        border-left-color: #0a5d4d;
        transform: translateX(5px);
    }
    .message-avatar {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        object-fit: cover;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .property-tag {
        font-size: 0.8rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 10px;
        border-radius: 6px;
    }
    .bg-light-unread {
        background-color: #f0f7f6 !important;
    }

    /* Standardized Premium Table Styles */
    .recent-table-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .table-header-box {
        padding: 24px 30px;
        border-bottom: 1px solid #f1f5f9;
        background: #fff;
    }

    .table-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

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
        padding: 18px 24px;
        color: #334155;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-premium-table tbody tr:last-child td {
        border-bottom: none;
    }

    .custom-premium-table tbody tr:hover {
        background-color: #f8fafc;
    }
</style>

<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Message Center</h1>
                <p class="text-white opacity-75 lead mb-0">Manage your inquiries, referrals, and conversations</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Messages</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="recent-table-container">
                    <div class="table-header-box d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="table-title">Conversations</h2>
                            <p class="text-muted small mb-0 mt-1">Manage your inquiries, referrals, and conversations</p>
                        </div>
                        <span class="badge bg-primary-gradient px-3 py-2 rounded-pill shadow-sm">
                            {{ count($rec) }} Total
                        </span>
                    </div>

                    <div class="table-responsive">
                        @if (count($rec) > 0)
                            <table class="table custom-premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center">#</th>
                                        <th>{{ Auth::guard('renter')->user()->user_type == 'M' ? 'Renter' : 'Property' }}</th>
                                        <th>Last Message</th>
                                        <th width="150" class="text-center">Date</th>
                                        <th width="120" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rec as $row)
                                        @php
                                            $isManager = Auth::guard('renter')->user()->user_type == 'M';
                                            $chatUrl = $isManager 
                                                ? route('manager-message', ['p_id' => $row->propertyinfo->Id, 'r_id' => $row->loginrenter->Id])
                                                : route('send-messages', ['id' => $row->propertyinfo->Id]);
                                            
                                            $displayName = $isManager 
                                                ? ($row->loginrenter->renterinfo->Firstname . ' ' . $row->loginrenter->renterinfo->Lastname)
                                                : ($row->propertyinfo->PropertyName);
                                            
                                            $lastMsg = $row->conversation->sortByDesc('created_at')->first();
                                            $unreadCount = $row->unreadCount(Auth::guard('renter')->user()->Id, Auth::guard('renter')->user()->user_type);
                                        @endphp
                                        <tr class="{{ $unreadCount > 0 ? 'bg-light-unread' : '' }}">
                                            <td class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    @if($isManager && $row->loginrenter->profile_pic)
                                                        <img src="{{ asset('uploads/profile_pics/' . $row->loginrenter->profile_pic) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" alt="">
                                                    @else
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 40px; height: 40px;">
                                                            {{ substr($displayName, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    @if($unreadCount > 0)
                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.6rem;">
                                                            {{ $unreadCount }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $displayName }}</div>
                                                <div class="text-muted smaller" style="font-size: 0.8rem;">
                                                    <i class="fa-solid fa-building me-1"></i> {{ $row->propertyinfo->PropertyName }}
                                                    @if($row->notify_manager == 1)
                                                        <span class="ms-2 badge bg-info-subtle text-info border-0" style="font-size: 0.65rem;">Referral</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate {{ $unreadCount > 0 ? 'fw-bold text-dark' : 'text-muted' }}" style="max-width: 300px;">
                                                    {{ $lastMsg ? $lastMsg->message : 'No messages yet' }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted small">
                                                    {{ $row->updated_at ? $row->updated_at->diffForHumans() : 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ $chatUrl }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fa-solid fa-comment-dots text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                                <h5 class="text-muted fw-bold">No messages found</h5>
                                <p class="text-muted px-4 small">When you inquire about properties, they will appear here.</p>
                                <a href="{{ route('search-property') }}" class="btn btn-primary btn-sm rounded-pill mt-2">Browse Properties</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

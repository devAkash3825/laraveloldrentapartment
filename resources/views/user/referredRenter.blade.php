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
        background: linear-gradient(135deg, #0a5d4d 0%, #0d8a72 100%);
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
</style>

<div id="breadcrumb_part" class="py-5" style="background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="fw-bold mb-2">Message Center</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active">Messages</li>
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
                <div class="message-center-card">
                    <div class="message-center-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Conversations</h5>
                                <p class="mb-0 opacity-75 small">Manage your inquiries and referrals</p>
                            </div>
                            <span class="badge bg-white text-dark rounded-pill px-3">{{ count($rec) }} Total</span>
                        </div>
                    </div>

                    <div class="message-list p-0">
                        @if (count($rec) > 0)
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
                                
                                <a href="{{ $chatUrl }}" class="text-decoration-none text-dark">
                                    <div class="message-item p-4 border-bottom d-flex align-items-center gap-3 {{ $unreadCount > 0 ? 'bg-light-unread' : '' }}">
                                        <div class="flex-shrink-0 position-relative">
                                            @if($isManager && $row->loginrenter->profile_pic)
                                                <img src="{{ asset('uploads/profile_pics/' . $row->loginrenter->profile_pic) }}" class="message-avatar" alt="">
                                            @else
                                                <div class="message-avatar bg-light d-flex align-items-center justify-content-center text-primary fw-bold">
                                                    {{ substr($displayName, 0, 1) }}
                                                </div>
                                            @endif
                                            @if($unreadCount > 0)
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                                    {{ $unreadCount }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 {{ $unreadCount > 0 ? 'fw-bold text-primary' : 'fw-semibold' }}">{{ $displayName }}</h6>
                                                <small class="text-muted">
                                                    {{ $row->updated_at ? $row->updated_at->diffForHumans() : '' }}
                                                </small>
                                            </div>
                                            <div class="small {{ $unreadCount > 0 ? 'text-dark fw-bold' : 'text-muted' }} mb-1 text-truncate" style="max-width: 500px;">
                                                {{ $lastMsg ? $lastMsg->message : 'No messages yet' }}
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="property-tag">
                                                    <i class="bi bi-building me-1"></i> {{ $row->propertyinfo->PropertyName }}
                                                </span>
                                                @if($row->notify_manager == 1)
                                                    <span class="badge bg-info-subtle text-info status-badge">Referral</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            @if($unreadCount > 0)
                                                <span class="badge bg-primary rounded-pill px-2 py-1" style="font-size: 0.7rem;">New</span>
                                            @else
                                                <i class="bi bi-chevron-right text-muted"></i>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-chat-dots text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted">No messages found</h5>
                                <p class="text-muted px-4">When you inquire about properties or receive referrals, they will appear here.</p>
                                <a href="{{ route('search-property') }}" class="btn btn-primary-custom mt-2">Browse Properties</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@extends('admin/layouts/app')
@section('content')
<style>
    .message-item-link {
        display: block;
        padding: 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.2s;
        text-decoration: none !important;
        color: inherit;
    }
    .message-item-link:hover {
        background: #f8f9fa;
    }
    .message-item-link.unread {
        background: #f0f7f6;
        border-left: 4px solid #1b84e7;
    }
    .avatar-char {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
</style>

<div class="slim-mainpanel">
    <div class="container container-messages">
        <div class="messages-left">
            <div class="slim-pageheader">
                <h6 class="slim-pagetitle">Messages</h6>
            </div>

            <div class="messages-list ps ps--theme_default ps--active-y">
                @foreach($messages as $row)
                    @php
                        $lastMsg = $row->conversation->sortByDesc('created_at')->first();
                        $unreadCount = $row->unreadCount(Auth::guard('admin')->user()->id, 'A');
                        $renterName = ($row->loginrenter->renterinfo->Firstname ?? 'User') . ' ' . ($row->loginrenter->renterinfo->Lastname ?? '');
                    @endphp
                    <a href="{{ route('admin-get-messages', ['rid' => $row->renterId, 'pid' => $row->propertyId]) }}" 
                       class="message-item-link {{ $unreadCount > 0 ? 'unread' : '' }}">
                        <div class="media">
                            <div class="media-left">
                                @if($row->loginrenter->profile_pic)
                                    <img src="{{ asset('uploads/profile_pics/'.$row->loginrenter->profile_pic) }}" class="wd-45 rounded-circle" alt="">
                                @else
                                    <div class="avatar-char bg-primary">{{ substr($renterName, 0, 1) }}</div>
                                @endif
                                @if($unreadCount > 0)
                                    <span class="square-10 bg-danger" style="position: absolute; bottom: 0; right: 0; border: 2px solid white; border-radius: 50%;"></span>
                                @endif
                            </div>
                            <div class="media-body ml-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="{{ $unreadCount > 0 ? 'tx-bold tx-inverse' : 'tx-medium' }} mb-0">{{ $renterName }}</h6>
                                    <small class="tx-11 text-muted">{{ $row->updated_at ? $row->updated_at->diffForHumans() : '' }}</small>
                                </div>
                                <p class="tx-13 {{ $unreadCount > 0 ? 'tx-bold tx-inverse' : 'text-muted' }} mb-0 text-truncate" style="max-width: 180px;">
                                    {{ $lastMsg->message ?? 'No messages' }}
                                </p>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge badge-info py-0 px-2" style="font-size: 0.7rem;">{{ $row->propertyinfo->PropertyName ?? 'N/A' }}</span>
                                    @if($unreadCount > 0)
                                        <span class="badge badge-danger ml-auto">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
                
                @if($messages->isEmpty())
                    <div class="p-4 text-center">
                        <i class="icon ion-ios-chatboxes-outline tx-60 text-muted"></i>
                        <p>No conversations found.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="messages-right">
            <div class="p-5 text-center my-auto">
                <i class="icon ion-ios-chatboxes-outline tx-100 text-muted mb-4 d-block"></i>
                <h4 class="tx-gray-800">Your Conversations</h4>
                <p>Select a conversation from the left to start messaging.</p>
            </div>
        </div>
    </div>
</div>
@endsection

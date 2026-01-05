@extends('user.layout.app')
@section('content')
@section('title', 'Manager Messages')
<style>
    .avatar-replacement {
        width: 45px;
        height: 45px;
        font-size: 1.2rem;
    }
    .tf__chating_text p {
        border-radius: 15px;
        padding: 10px 15px !important;
        max-width: 100%;
        margin-bottom: 5px !important;
    }
    .tf__chating_text span {
        font-size: 0.75rem;
        color: #888;
    }
    .tf_chat_right .tf__chating_text p {
        border-bottom-right-radius: 0;
    }
    .tf_chat_left .tf__chating_text p {
        border-bottom-left-radius: 0;
        background: #f8f9fa !important;
    }
</style>
    <section id="dashboard" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <x-dashboard-sidebar />
                </div>
                <div class="col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab" tabindex="0">
                            <div class="tf___single_chat">
                                <div class="tf__single_chat_top">
                                    <div class="img">
                                        <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $getPropertyInfo['Id'] }}/Original/{{ $getPropertyInfo->gallerytype->gallerydetail[0]['ImageName'] }}"
                                            alt="property" class="img-fluid w-100">
                                    </div>
                                    <div class="text">
                                        <h4>{{ $getPropertyInfo->PropertyName }}</h4>
                                    </div>
                                </div>

                                <div class="tf__single_chat_body" id="chatBody">
                                    <div id="messageContainer">
                                        @foreach ($messages as $message)
                                            @foreach ($message->conversation as $conversation)
                                                @php
                                                    $isMe = $conversation->managerId == Auth::guard('renter')->user()->Id;
                                                    $role = 'Manager';
                                                    $roleColor = 'bg-info text-white';
                                                    $roleIcon = 'bi-building';
                                                    
                                                    if ($conversation->adminId) {
                                                        $role = 'Admin';
                                                        $roleColor = 'bg-warning text-dark';
                                                        $roleIcon = 'bi-shield-check';
                                                    } elseif ($conversation->renterId) {
                                                        $role = 'Renter';
                                                        $roleColor = 'bg-primary text-white';
                                                        $roleIcon = 'bi-person';
                                                    }
                                                @endphp

                                                @if ($isMe)
                                                    <div class="tf__chating tf_chat_right">
                                                        <div class="tf__chating_text">
                                                            <div class="d-flex justify-content-end align-items-center gap-2 mb-1">
                                                                <small class="fw-bold text-info">You (Manager)</small>
                                                            </div>
                                                            <p class="bg-info text-white shadow-sm" style="background-color: #0dcaf0 !important;">{{ $conversation->message }}</p>
                                                            <span>{{ $conversation->created_at->format('d M, h:i A') }}</span>
                                                        </div>
                                                        <div class="tf__chating_img">
                                                            @if(Auth::guard('renter')->user()->profile_pic)
                                                                <img src="{{ asset('uploads/profile_pics/' . Auth::guard('renter')->user()->profile_pic) }}" class="img-fluid rounded-circle">
                                                            @else
                                                                <div class="avatar-replacement bg-info text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                                                                    <i class="bi bi-building"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="tf__chating tf_chat_left">
                                                        <div class="tf__chating_img">
                                                            <div class="avatar-replacement {{ $roleColor }} rounded-circle d-flex align-items-center justify-content-center shadow-sm" title="{{ $role }}">
                                                                <i class="bi {{ $roleIcon }}"></i>
                                                            </div>
                                                        </div>
                                                        <div class="tf__chating_text">
                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                <small class="fw-bold">{{ $role }}</small>
                                                                <span class="badge {{ $roleColor }} border-0" style="font-size: 0.6rem;">{{ $role }}</span>
                                                            </div>
                                                            <p class="bg-white border shadow-sm text-dark">{{ $conversation->message }}</p>
                                                            <span>{{ $conversation->created_at->format('d M, h:i A') }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>

                                <form id="sendMessageForm" class="tf__single_chat_bottom">
                                    <div class="row p-4">
                                        <div class="col-md-10">
                                            <input type="text" id="messageInput" name="messageInput"
                                                placeholder="Type a message...">
                                            <input type="hidden" id="sendpropertyid" name="sendpropertyid"
                                                value="{{ $getPropertyInfo['Id'] }}">
                                            <input type="hidden" name="messageId" value="{{ $messages[0]->id }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit "class="send-message-btn">Send</button>
                                        </div>
                                    </div>
                                </form>
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
        $("#sendMessageForm").submit(function(e) {
            e.preventDefault();
            var message = $('#messageInput').val();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{ route('store-message') }}",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function() {
                    $(".send-message-btn").html(
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
                    );
                    $(".send-message-btn").prop("disabled", true);
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $("#messageContainer").append(`
                                <div class="tf__chating tf_chat_right">
                                    <div class="tf__chating_text">
                                        <div class="d-flex justify-content-end align-items-center gap-2 mb-1">
                                            <small class="fw-bold text-info">You (Manager)</small>
                                        </div>
                                        <p class="bg-info text-white shadow-sm" style="background-color: #0dcaf0 !important;">${message}</p>
                                        <span>Just Now</span>
                                    </div>
                                    <div class="tf__chating_img">
                                        @if(Auth::guard('renter')->user()->profile_pic)
                                            <img src="{{ asset('uploads/profile_pics/' . Auth::guard('renter')->user()->profile_pic) }}" class="img-fluid rounded-circle">
                                        @else
                                            <div class="avatar-replacement bg-info text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                                                <i class="bi bi-building"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                        `);
                        $("#messageInput").val("");
                        // Scroll to bottom
                        var chatBody = document.getElementById("chatBody");
                        chatBody.scrollTop = chatBody.scrollHeight;
                    } else {
                        toastr.error(response.message || "Failed to send message");
                    }
                },
                error: function(xhr) {
                    toastr.error("Failed to send message. Please try again.");
                },
                complete: function() {
                    $(".send-message-btn").html(`Send`);
                    $(".send-message-btn").prop("disabled", false);
                },
            });
        });

        // Auto-scroll to bottom on load
        $(document).ready(function() {
            var chatBody = document.getElementById("chatBody");
            if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;

            const userid = "{{ Auth::guard('renter')->user()->Id }}";
            const propertyId = "{{ $getPropertyInfo['Id'] }}";
            
            if (userid && window.Echo) {
                // Listen for Admin messages
                window.Echo.private(`message-from-admin.${userid}`)
                    .listen('.AdminMessageSent', (e) => {
                        if (e.propertyid == propertyId) {
                            appendReceivedMessage(e.notification.message, 'Admin', 'bg-warning text-dark', 'bi-shield-check');
                        }
                    });

                // Listen for Renter messages
                window.Echo.private(`message-from-renter.${userid}`)
                    .listen('.RenterMessageSent', (e) => {
                        if (e.propertyId == propertyId) {
                            appendReceivedMessage(e.notification.message, 'Renter', 'bg-primary text-white', 'bi-person');
                        }
                    });
            }

            function appendReceivedMessage(msg, role, colorClass, iconClass) {
                $("#messageContainer").append(`
                    <div class="tf__chating tf_chat_left">
                        <div class="tf__chating_img">
                            <div class="avatar-replacement ${colorClass} rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                                <i class="bi ${iconClass}"></i>
                            </div>
                        </div>
                        <div class="tf__chating_text">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <small class="fw-bold">${role}</small>
                                <span class="badge ${colorClass} border-0" style="font-size: 0.6rem;">${role}</span>
                            </div>
                            <p class="bg-white border shadow-sm text-dark">${msg}</p>
                            <span>Just Now</span>
                        </div>
                    </div>
                `);
                var chatBody = document.getElementById("chatBody");
                if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
            }
        });
    </script>
@endpush

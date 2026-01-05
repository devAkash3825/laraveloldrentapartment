@extends('admin.layouts.app')
@section('content')
    <style>
        /*=============== GOOGLE FONTS ===============*/
        @import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");

        :root {
            /* --accent-color: #a876aa; */
            --accent-color: #1b84e7;
            --background-color: #eeeeee;
        }

        .container p {
            text-align: center;
        }

        .header {
            display: flex;
            align-items: center;
            margin: 20px 0px 20px 0;
            color: var(--accent-color);
        }

        .header .avatar {
            align-self: center;
            width: 50px;
        }

        .chat .avatar {
            background-color: var(--accent-color);
            align-self: center;
            padding: 5px;
            width: 40px;
            border-radius: 50%;
        }

        .header h3 {
            margin-left: 20px;
            margin-right: auto;
        }

        .header i {
            margin: 0 10px;
        }

        .chat {
            background-color: #fff;
            height: 100%;
            overflow: auto;
            padding: 25px;
            max-height: 420px;
        }

        .message {
            font-size: 16px;
            line-height: 20px;
            width: fit-content;
            max-width: 450px;
            margin: 20px 10px;
            padding: 15px;
            border-radius: 15px;
        }

        .message.fromuser {
            background-color: var(--accent-color);
            color: #fff;
            border-top-right-radius: 0px;
            padding-left: 30px;
        }

        .message.response {
            background-color: #eee;
            border-top-left-radius: 0px;
            padding-right: 30px;
        }

        .chat-footer {
            display: flex;
            margin-top: 20px;
        }

        .chat-footer .btn {
            display: flex;
            background-color: var(--accent-color);
            color: #eee;
            font-family: inherit;
            border: 0;
            border-radius: 50px;
            padding: 14px 40px;
            margin: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: scale 0.2s ease;
            margin: auto;
        }

        .chat-footer .chat-input-field {
            display: flex;
            color: var(--accent-color);
            font-family: inherit;
            border: 0;
            border-radius: 50px;
            padding: 14px 40px;
            margin: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: scale 0.2s ease;
            width: 90%;
            margin: auto;
            background: #ffff;
        }

        .chat-footer .chat-input-field i {
            margin-left: auto;
        }

        .chat-footer .chat-input-field .btn {
            margin-left: auto;
        }

        .chat-footer .chat-input-field i {
            margin-left: auto;
        }

        .chat-footer .chat-input-field:focus {
            outline: none;
        }

        .chat-footer .chat-input-field:hover {
            scale: 1.01;
        }

        .chat-footer .chat-input-field:active {
            scale: 0.99;
        }

        .time {
            font-size: 11px;
            clear: right;
        }

        .display-flex {
            display: flex;
        }

        .display-flex-right {
            display: flex;
            justify-content: end;
        }

        /*=============== SCROLLBAR ===============*/

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #fff;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #eee;
            border-radius: 5px;
        }

        .header {
            background: #f3f3f3;
        }

        /*=============== MEDIA QUERY ===============*/

        @media screen and (max-width: 650px) {
            .container {
                max-height: 100%;
                height: 100%;
                width: 100%;
            }
        }
    </style>

    <div class="slim-mainpanel">
        <div class="container">
            <div class="header">
                <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $getPropertyInfo['Id'] }}/Original/{{ $getPropertyInfo->gallerytype->gallerydetail[0]['ImageName'] }}"
                    alt="" class="avatar">
                <h3>{{ $getPropertyInfo->PropertyName }}</h3>
                <i class="fa-solid fa-phone"></i>
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </div>
            <div id="chat" class="chat">
                @foreach ($messages as $message)
                    @foreach ($message->conversation as $conversation)
                        @php
                            $isMe = $conversation->adminId == Auth::guard('admin')->user()->id;
                            $role = 'Admin';
                            $roleColor = 'bg-warning text-dark';
                            $roleIcon = 'fa-shield-halved';
                            
                            if ($conversation->managerId) {
                                $role = 'Manager';
                                $roleColor = 'bg-info text-white';
                                $roleIcon = 'fa-building';
                            } elseif ($conversation->renterId) {
                                $role = 'Renter';
                                $roleColor = 'bg-primary text-white';
                                $roleIcon = 'fa-user';
                            }
                        @endphp
                        
                        @if ($isMe)
                            <div class="display-flex-right mt-3">
                                <div style="text-align: right;">
                                    <div class="d-flex justify-content-end align-items-center gap-2 mb-1">
                                        <small class="fw-bold">You (Admin)</small>
                                    </div>
                                    <div class="message fromuser" style="background-color: #1b84e7; border-radius: 15px 15px 0 15px; margin: 0;">{{ $conversation->message }}</div>
                                    <span class="time"> {{ $conversation->created_at->format('h:i A') }} </span>
                                </div>
                                <div class="avatar" style="background: #1b84e7; color: white; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
                                    <i class="fa fa-shield-halved"></i>
                                </div>
                            </div>
                        @else
                            <div class="display-flex mt-3">
                                <div class="avatar" style="background: {{ $conversation->managerId ? '#17a2b8' : '#007bff' }}; color: white; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                                    <i class="fa {{ $roleIcon }}"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <small class="fw-bold">{{ $role }}</small>
                                    </div>
                                    <div class="message response" style="background-color: #f1f1f1; border-radius: 15px 15px 15px 0; margin: 0;">{{ $conversation->message }}</div>
                                    <span class="time"> {{ $conversation->created_at->format('h:i A') }} </span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <form action="" id="sendmessageform">
                <div class="chat-footer">
                    <input type="hidden" name="renterId" id="renterId" value="{{ $renterId }}">
                    <input type="hidden" id="sendpropertyId" name="sendpropertyID" value="{{ $getPropertyInfo['Id'] }}"
                        placeholder="Enter Your Message ">
                    <input type="text" name="adminmessage" id="" class="chat-input-field"
                        placeholder="Type Message Here ......."> <button href="javascript:void(0)" class="btn"><i
                            class="fa-solid fa-paper-plane"></i> </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $("#sendmessageform").submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin-send-message') }}",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    if (response.status === "Message Sent") {
                        $("#chat").append(`
                        <div class="msg right-msg">
                            <div class="msg-item">
                                <span class="msg-time">Just Now</span>
                                <div class="msg-bubble">
                                    <div class="msg-text">
                                        <p> ${response.message}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                        $("#messageInput").val("");
                    }
                },
                error: function(xhr) {
                    $("#errorMessage")
                        .removeClass("d-none")
                        .text("Failed to send message. Please try again.");
                },
            });
        });

        const userid = {{ @Auth::guard('admin')->user()->id }}
        const propertyId = "{{ $getPropertyInfo->Id }}";
        if (userid && window.Echo) {
            document.addEventListener('DOMContentLoaded', function() {
                // Listen for Renter messages
                window.Echo.private(`message-from-renter.${userid}`)
                    .listen('.RenterMessageSent', (e) => {
                        if (e.propertyId == propertyId) {
                            appendReceivedMessage(e.notification.message, 'Renter', '#007bff', 'fa-user');
                        }
                    });

                // Listen for Manager messages
                window.Echo.private(`message-from-manager.${userid}`)
                    .listen('.ManagerMessageSent', (e) => {
                        if (e.propertyId == propertyId) {
                            appendReceivedMessage(e.message.message, 'Manager', '#17a2b8', 'fa-building');
                        }
                    });
            });
        }

        function appendReceivedMessage(msg, role, color, icon) {
            $("#chat").append(`
                <div class="display-flex mt-3">
                    <div class="avatar" style="background: ${color}; color: white; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <i class="fa ${icon}"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <small class="fw-bold">${role}</small>
                        </div>
                        <div class="message response" style="background-color: #f1f1f1; border-radius: 15px 15px 15px 0; margin: 0;">${msg}</div>
                        <span class="time">Just Now</span>
                    </div>
                </div>
            `);
            var chat = document.getElementById("chat");
            chat.scrollTop = chat.scrollHeight;
        }
    </script>
@endpush

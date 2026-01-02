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
                        @if ($conversation->adminId == Auth::guard('admin')->user()->Id)
                            <div class="display-flex">
                                <img src="https://cdn-icons-png.flaticon.com/512/2233/2233922.png" alt=""
                                    class="avatar">
                                <div class="message response">{{ $conversation->message }}</div>
                            </div>
                            <span class="time"> {{ $conversation->created_at->format('d M, h:i A') }} </span>
                        @else
                            <div class="mt-4">
                                <div class="display-flex-right">
                                    <div class="message fromuser">{{ $conversation->message }} </div>
                                    <img src="https://cdn-icons-png.flaticon.com/512/2233/2233922.png" alt=""
                                        class="avatar">
                                </div>
                                <span class="time" style="float: right;">
                                    {{ $conversation->created_at->format('d M, h:i A') }} </span>
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
        if (userid) {
            document.addEventListener('DOMContentLoaded', function() {
                if (window.Echo) {
                    window.Echo.private(`message-from-renter.${userid}`)
                        .listen('.RenterMessageSent', (e) => {
                            console.log("==>", e);
                            if (e.propertyId === propertyId) {
                                $("#chat").append(`
                                <div class="display-flex">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2233/2233922.png" alt="" class="avatar">
                                        <div class="message response">${e.notification.message}</div>
                                </div>
                                <span class="time">Just Now</span>
                            `);
                            }
                        });
                }
            });
        }
    </script>
@endpush

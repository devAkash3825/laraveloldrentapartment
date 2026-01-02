@extends('user.layout.app')
@section('content')
    <section id="dashboard">
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
                                    <div id="rentermessage_window">
                                        @foreach ($messages as $message)
                                            @foreach ($message->conversation as $conversation)
                                                @if ($conversation->renterId == Auth::guard('renter')->user()->Id)
                                                    <div class="tf__chating tf_chat_right">
                                                        <div class="tf__chating_text">
                                                            <p>{{ $conversation->message }}</p>
                                                            <span>{{ $conversation->created_at->format('d M, h:i A') }}</span>
                                                        </div>
                                                        <div class="tf__chating_img">
                                                                <img src="https://cdn-icons-png.flaticon.com/512/2233/2233922.png" alt="logo" class="img-fluid">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="tf__chating tf_chat_left">
                                                        <div class="tf__chating_img">
                                                            <img src="https://cdn-icons-png.flaticon.com/512/2233/2233922.png" alt="person" class="img-fluid w-100">
                                                        </div>
                                                        <div class="tf__chating_text">
                                                            <p>{{ $conversation->message }}</p>
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
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="send-message-btn send-btn">Send</button>
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
            var rentermessage = $('#messageInput').val();
            console.log(rentermessage);
            let formData = $(this).serialize();
            $.ajax({
                url: "{{ route('store-message') }}",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function() {
                    $(".send-btn").html(
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
                    );
                    $(".send-btn").prop("disabled", true);
                },
                success: function(response) {
                    console.log("response",response);
                    if (response[0] == 'message') {
                        $(".send-btn").html(`Submit`);
                        $("#rentermessage_window").append(`
                                <div class="tf__chating tf_chat_right">
                                    <div class="tf__chating_text">
                                        <p>${rentermessage}</p>
                                        <span>Just Now</span>
                                    </div>
                                    <div class="tf__chating_img">
                                        <img src="https://cdn-icons-png.flaticon.com/512/2233/2233922.png" alt="user" class="img-fluid w-100">
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
                complete: function() {
                    $(".send-btn").html(`Submit`);
                    $(".send-btn").prop("disabled", false);
                },
            });
        });

        if (userid) {
            const propertyId = "{{ $getPropertyInfo['Id'] }}";
            document.addEventListener('DOMContentLoaded', function() {
                if (window.Echo) {
                    window.Echo.private(`message-from-admin.${userid}`)
                        .listen('.AdminMessageSent', (e) => {
                            if (e.propertyid === propertyId) {
                                console.log("checking e", e);
                                $("#rentermessage_window").append(`
                                <div class="tf__chating tf_chat_left">
                                    <div class="tf__chating_img">
                                            <img src="${e.notification.renterimageURL}" alt="person" class="img-fluid w-100">
                                    </div>
                                    <div class="tf__chating_text">
                                        <p>${e.notification.message}</p>
                                        <span> Just Now </span>
                                    </div>
                                </div>
                        `);
                            }
                        });
                }
            });
        }
    </script>
@endpush

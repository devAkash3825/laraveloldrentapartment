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
                                    <div id="messageContainer">
                                        @foreach ($messages as $message)
                                            @foreach ($message->conversation as $conversation)
                                                @if ($conversation->managerId == Auth::guard('renter')->user()->Id)
                                                    <div class="tf__chating tf_chat_right">
                                                        <div class="tf__chating_text">
                                                            <p>{{ $conversation->message }}</p>
                                                            <span>{{ $conversation->created_at->format('d M, h:i A') }}</span>
                                                        </div>
                                                        <div class="tf__chating_img">
                                                            @php
                                                                $user = \App\Models\Login::find($conversation->managerId);
                                                            @endphp

                                                            @if ($user)
                                                                <img src="{{ $user->profile_pic_url }}" alt="logo" class="img-fluid">
                                                            @else
                                                                <p>User not found</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="tf__chating tf_chat_left">
                                                        <div class="tf__chating_img">
                                                            <img src="" alt="person" class="img-fluid w-100">
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

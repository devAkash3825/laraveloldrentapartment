@extends('admin/layouts/app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container container-messages">
            <div class="messages-left">
                <div class="slim-pageheader">
                    <h6 class="slim-pagetitle">Messages</h6>
                    <a href="" class="messages-compose"><i class="icon ion-compose"></i></a>
                </div>

                <div class="messages-list ps ps--theme_default ps--active-y"
                    data-ps-id="808d39a3-3a48-d2ca-978a-fdd8721d21ca">
                    <a href="" class="media">
                        <div class="media-left">
                            <img src="../img/img2.jpg" alt="">
                            <span class="square-10 bg-success"></span>
                        </div>
                        <div class="media-body">
                            <div>
                                <h6>Socrates Itumay</h6>
                                <p>The new common language will be more simple and regular...</p>
                            </div>
                            <div>
                                <span>Dec 14</span>
                            </div>
                        </div>
                    </a>
                    <a href="" class="media unread">
                        <div class="media-left">
                            <img src="../img/img4.jpg" alt="">
                            <span class="square-10 bg-success"></span>
                        </div>
                        <div class="media-body">
                            <div>
                                <h6>Joyce Chua</h6>
                                <p>To an English person, it will seem like simplified english...</p>
                            </div>
                            <div>
                                <span>Dec 14</span>
                                <span>1</span>
                            </div>
                        </div>
                    </a>
                    <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: -400px;">
                        <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__scrollbar-y-rail" style="top: 400px; height: 332px; right: 0px;">
                        <div class="ps__scrollbar-y" tabindex="0" style="top: 181px; height: 150px;"></div>
                    </div>
                </div>
            </div>

            <div class="messages-right">
                <div class="message-header">
                    <a href="" class="message-back"><i class="fa fa-angle-left"></i></a>
                    <div class="media">
                        <img src="../img/img4.jpg" alt="">
                        <div class="media-body">
                            <h6>Joyce Chua</h6>
                            <p>Last seen: 2 hours ago</p>
                        </div><!-- media-body -->
                    </div><!-- media -->
                    <div class="message-option">
                        <div class="d-none d-sm-flex">
                            <a href=""><i class="icon ion-ios-telephone-outline"></i></a>
                            <a href=""><i class="icon ion-ios-videocam-outline"></i></a>
                            <a href=""><i class="icon ion-ios-gear-outline"></i></a>
                            <a href=""><i class="icon ion-ios-information-outline"></i></a>
                        </div>
                        <div class="d-sm-none">
                            <a href=""><i class="icon ion-more"></i></a>
                        </div>
                    </div>
                </div>
                <div class="message-body ps ps--theme_default ps--active-y"
                    data-ps-id="2926be57-b840-a622-3d32-e7357f6e8a93">
                    <div class="media-list">
                        <div class="media">
                            <img src="../img/img1.jpg" alt="">
                            <div class="media-body">
                                <div class="msg">
                                    <p>Hi, there?</p>
                                </div>
                                <div class="msg">
                                    <p>Are you ready for our party tonight?</p>
                                </div>
                            </div><!-- media-body -->
                        </div><!-- media -->
                        <div class="media">
                            <div class="media-body reverse">
                                <div class="msg">
                                    <p>So this is where you plan to do it?</p>
                                </div>
                            </div><!-- media-body -->
                            <img src="../img/img4.jpg" class="wd-50 rounded-circle" alt="">
                        </div><!-- media -->
                        <div class="media">
                            <img src="../img/img1.jpg" alt="">
                            <div class="media-body">
                                <div class="msg">
                                    <p>As good a place as any.</p>
                                </div>
                            </div><!-- media-body -->
                        </div><!-- media -->
                    </div>
                    <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: -100px;">
                        <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__scrollbar-y-rail" style="top: 100px; height: 292px; right: 0px;">
                        <div class="ps__scrollbar-y" tabindex="0" style="top: 54px; height: 159px;"></div>
                    </div>
                </div>
                <div class="message-footer">
                    <div class="row row-sm">
                        <div class="col-9 col-sm-8 col-xl-9">
                            <input type="text" class="form-control" placeholder="Type something here...">
                        </div>
                        <div class="col-3 col-sm-4 col-xl-3 tx-right">
                            <div class="d-none d-sm-block">
                                <a href=""><i class="icon ion-happy-outline"></i></a>
                                <a href=""><i class="icon ion-ios-game-controller-b-outline"></i></a>
                                <a href=""><i class="icon ion-ios-camera-outline"></i></a>
                                <a href=""><i class="icon ion-ios-mic-outline"></i></a>
                            </div>
                            <div class="d-sm-none">
                                <a href=""><i class="icon ion-more"></i></a>
                            </div>
                        </div><!-- col-4 -->
                    </div><!-- row -->
                </div>
            </div>
        </div>
    </div>
@endsection

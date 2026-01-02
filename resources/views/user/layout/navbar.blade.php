@php
@$amenities = App\Models\CommunityAmenities::all();
@$apartmentfeatures = App\Models\ApartmentFeature::all();
@$pets = App\Models\Pets::all();
@$userid = Auth::guard('renter')->user();
@$notifications = App\Models\Notification::where('to_id', $userid->Id)
->where('to_user_type', $userid->user_type)
->orderBy('id', 'desc')
->get();
@$notificationsnotseencount = App\Models\Notification::where('to_id', $userid->Id)
->where('to_user_type', $userid->user_type)
->where('seen', 0)
->count();
$settings = DB::table('settings')->pluck('value', 'key');
@endphp
<section id="wsus__topbar">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-xl-6 col-md-7 d-none d-md-block">
                <ul class="wsus__topbar_left">
                    <li><a href="mailto:{{ config('settings.site_email') }}"><i class="fal fa-envelope"></i>
                            {{ @$settings['site_email'] }}</a></li>
                    <li><a href="callto:{{ config('settings.site_phone') }}"><i
                                class="fal fa-phone-alt"></i>{{ @$settings['site_phone'] }}</a></li>
                </ul>
            </div>
            <div class="col-xl-6 col-md-5">
                <ul class="wsus__topbar_left float-right gap-2">
                    @guest('renter')
                    <li>
                        <a href="{{ route('login') }}" class="btn topbar-btn btn-sm px-4"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                    <li>
                        <a href="{{ route('user-register') }}" class="btn topbar-btn btn-sm px-4"><i class="bi bi-person-add"></i> Register </a>
                    </li>
                    @endguest
                    <li>
                        <a href="{{ route('advance-search') }}" class="btn topbar-btn btn-sm px-4 ml-5"><i class="bi bi-search"></i> Advance Search</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<nav class="navbar navbar-expand-lg main_menu">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset(config('settings.logo', 'images/default-logo.png')) }}" alt="DB.Card" class="logo-img">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="far fa-bars" aria-hidden="true"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @foreach (Menu::getByName('Main Menu') as $menu)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($menu['link']) ? 'active' : '' }}" aria-current="page"
                        href="{{ route($menu['link']) }}">
                        {{ $menu['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="navbar-right-section">
                @if (Auth::guard('renter')->check())
                <div class="notification-container">
                    <div class="notifications dropdown" onclick="toggleNotifications()">
                        <span class="count" id="notifications-count">{{ $notificationsnotseencount }}</span>
                        <i class="bi bi-bell f-sz15"></i>
                    </div>
                    <div class="dropdown-menu" id="notification-dropdown">
                        <div class="dropdown-body">
                            <div class="dropdown-menu-header">
                                <h6 class="dropdown-menu-title">Notifications</h6>
                                <div>
                                    <a href="javascript:void(0)" class="notification-anchor" id="markedAllAsRead"
                                        data-user-id="{{ $userid->Id }}"
                                        onclick="markAllNotificationsAsSeen(this)">Mark All as Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list" id="notification-list">
                                @if (count($notifications) > 0)
                                @foreach ($notifications as $row)
                                <a href="javascript:void(0)"
                                    class="dropdown-link {{ $row->seen == 1 ? 'seen' : 'unread' }}">
                                    <div class="media d-flex">
                                        <img src="{{ asset('uploads/profile_pics/manager_29253_1729580644.png') }}"
                                            alt="">
                                        <div class="media-body">
                                            <p>{!! $row->message !!} </p>
                                            <span
                                                class="d-flex justify-content-between notification-li-bottom">
                                                <span>{{ $row->CreatedOn->format('h:i A') }}</span>
                                                @if ($row->seen != '1')
                                                <i class="bi bi-eye-fill eye-icon" id="eye-icon"
                                                    data-user-id="{{ $row->Id }}"
                                                    onclick="markVisibleNotificationsAsSeen(this)"></i>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                @else
                                <a href="" class="dropdown-link {{ @$row->seen == 1 ? read : '' }}"
                                    style="width:100%;" id="notificationsyet">
                                    <div class="media d-flex justify-content-center">
                                        <div class="media-body">
                                            <p class=""> No Notifications Yet</p>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                @if (count($notifications) > 3)
                                <div class="dropdown-list-footer">
                                    <a href="page-notifications.html"><i class="fa fa-angle-down"></i> Show All
                                        Notifications</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="profile">
                        @if (Auth::guard('renter')->user()->profile_pic != '')
                        <div class="user">
                            <h6>{{Auth::guard('renter')->user()->UserName}}</h6>
                            <p>@probablykat66</p>
                        </div>
                        @endif
                        <div class="img-box">
                            @if (Auth::guard('renter')->user()->profile_pic != '')
                            <img src="{{ asset('uploads/profile_pics/' . Auth::guard('renter')->user()->profile_pic) }}" alt="img" class="img-fluid">
                            @else
                            <img src="{{ asset('img/avatar-of-aavtarimg.jpg') }}" alt="logo" class="img-fluid">
                            @endif
                        </div>
                    </div>
                    <div class="profile-menu">
                        <ul>
                            <li class=""><a href="{{ route('user-profile') }}" class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                    </svg>
                                    Dashboard
                                </a></li>
                            <li class=""><a href="{{ route('change-password') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    </svg>
                                    Change Password
                                </a></li>
                        
                            <li class=""><a href="{{ route('logout') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                        <path d="M15 12h-12l3 -3" />
                                        <path d="M6 15l-3 -3" />
                                    </svg>
                                    Sign Out
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</nav>

<script>
    let profile = document.querySelector('.profile');
    let menu = document.querySelector('.profile-menu');

    profile.onclick = function() {
        menu.classList.toggle('active');
    }
    let hasUserInteracted = false;

    document.addEventListener('DOMContentLoaded', function() {
        let profile = document.querySelector('.profile');
        let menu = document.querySelector('.profile-menu');
        let notificationDropdown = document.getElementById('notification-dropdown');

        profile.onclick = function() {
            menu.classList.toggle('active');
            if (menu.classList.contains('active')) {
                notificationDropdown.classList.remove('show');
            }
        };
    });

    function toggleNotifications() {
        const dropdown = document.getElementById('notification-dropdown');
        dropdown.classList.toggle('show');
        
        if (dropdown.classList.contains('show')) {
            const menu = document.querySelector('.profile-menu');
            menu.classList.remove('active');
        }
    }


    // const userid = {
    //     {
    //         @Auth::guard('renter')->user()->Id;
    //     }
    // }
    // if (userid) {
    //     document.addEventListener('DOMContentLoaded', function() {
    //         if (window.Echo) {
    //             window.Echo.private(`adminNotification.${userid}`)
    //                 .listen('.NotificationEvent', (e) => {
    //                     const counterElement = document.getElementById('notifications-count');
    //                     const notificationList = document.getElementById('notification-list');
    //                     const newNotification = document.createElement('a');
    //                     let currentCount = parseInt(counterElement.textContent) || 0;
    //                     let url = "{{ route('referred-renter') }}";
    //                     counterElement.textContent = currentCount + 1;
    //                     newNotification.href = e.notification.url || 'javascript:void(0)';
    //                     newNotification.className = 'dropdown-link';
    //                     newNotification.innerHTML = `
    //                         <a href="${url}">
    //                             <div class="media d-flex">
    //                                 <img src="{{ asset('admin_asset/upload_pics') }}/${e.notification.image}" alt="">
    //                                 <div class="media-body">
    //                                     <p>${e.notification.message}</p>
    //                                     <span>Just Now</span>
    //                                 </div>
    //                             </div>
    //                         </a>`;
    //                     notificationList.prepend(newNotification);
    //                     $('#notificationsyet').hide();
    //                     hasUserInteracted = true;
    //                     var button = document.getElementsByTagName("button")[0];
    //                     if (button) {
    //                         button.addEventListener("click", ding);
    //                     } else {
    //                         console.error("Button not found!");
    //                     }
    //                 });
    //         }
    //     });
    // }

    function markVisibleNotificationsAsSeen(e) {
        const notificationid = e.dataset.userId;
        $.ajax({
            url: "{{ route('markedasseen') }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                notificationId: notificationid,
            },
            success: function(response) {
                if (response.message) {
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                if (response.message) {
                    toastr.error(response.error);
                }
            },
        });
    }

    function markAllNotificationsAsSeen(e) {
        const userId = e.dataset.userId;
        $.ajax({
            url: "{{ route('markedallasread') }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response.message) {
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                if (response.message) {
                    toastr.error(response.error);
                }
            },
        });
    }

    function ding() {
        var sound = new Audio("sound/notificationsound.mp3");
        sound.play();
    }
</script>

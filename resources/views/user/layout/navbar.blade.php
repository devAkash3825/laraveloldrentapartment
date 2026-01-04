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

<!-- Topbar -->
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
                <ul class="wsus__topbar_left justify-content-end">
                    @guest('renter')
                    <li>
                        <a href="{{ route('login') }}" class="topbar-btn" title="Login">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user-register') }}" class="topbar-btn" title="Register">
                            <i class="bi bi-person-add"></i>
                        </a>
                    </li>
                    @endguest
                    <li>
                        <a href="{{ route('advance-search') }}" class="topbar-btn search-btn" title="Advance Search">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg main_menu">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset(config('settings.logo', 'images/default-logo.png')) }}" alt="Logo" class="logo-img">
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

            @if (Auth::guard('renter')->check())
            <div class="navbar-right-section">
                <!-- Notification Dropdown -->
                <div class="notification-wrapper">
                    <button class="icon-button" id="notification-button" onclick="toggleNotifications()">
                        <i class="bi bi-bell"></i>
                        @if($notificationsnotseencount > 0)
                        <span class="badge-count">{{ $notificationsnotseencount }}</span>
                        @endif
                    </button>
                    <div class="dropdown-panel notification-dropdown" id="notification-dropdown">
                        <div class="dropdown-header">
                            <h6 class="dropdown-title">Notifications</h6>
                            <a href="javascript:void(0)" class="mark-read-link" data-user-id="{{ $userid->Id }}"
                                onclick="markAllNotificationsAsSeen(this)">Mark all read</a>
                        </div>
                        <div class="dropdown-body" id="notification-list">
                            @if (count($notifications) > 0)
                                @foreach ($notifications as $row)
                                <a href="javascript:void(0)" class="notification-item {{ $row->seen == 1 ? 'read' : 'unread' }}">
                                    <div class="notification-avatar">
                                        <img src="{{ asset('uploads/profile_pics/manager_29253_1729580644.png') }}" alt="Avatar">
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">{!! $row->message !!}</p>
                                        <div class="notification-meta">
                                            <span class="notification-time">{{ $row->CreatedOn->format('h:i A') }}</span>
                                            @if ($row->seen != '1')
                                            <button class="mark-read-btn" data-user-id="{{ $row->Id }}"
                                                onclick="markVisibleNotificationsAsSeen(this)">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-bell-slash"></i>
                                    <p>No notifications yet</p>
                                </div>
                            @endif
                        </div>
                        @if (count($notifications) > 5)
                        <div class="dropdown-footer">
                            <a href="#">View all notifications</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="profile-wrapper">
                    <button class="profile-button" id="profile-button">
                        <div class="profile-avatar">
                            @if (Auth::guard('renter')->user()->profile_pic != '')
                            <img src="{{ asset('uploads/profile_pics/' . Auth::guard('renter')->user()->profile_pic) }}" alt="Profile">
                            @else
                            <img src="{{ asset('img/avatar-of-aavtarimg.jpg') }}" alt="Default Avatar">
                            @endif
                        </div>
                        <div class="profile-info d-none d-lg-block">
                            <h6 class="profile-name">{{ Auth::guard('renter')->user()->UserName }}</h6>
                            <p class="profile-email">{{ Auth::guard('renter')->user()->Email }}</p>
                        </div>
                        <i class="bi bi-chevron-down profile-chevron"></i>
                    </button>
                    <div class="dropdown-panel profile-dropdown" id="profile-dropdown">
                        <div class="profile-dropdown-header">
                            <div class="profile-dropdown-avatar">
                                @if (Auth::guard('renter')->user()->profile_pic != '')
                                <img src="{{ asset('uploads/profile_pics/' . Auth::guard('renter')->user()->profile_pic) }}" alt="Profile">
                                @else
                                <img src="{{ asset('img/avatar-of-aavtarimg.jpg') }}" alt="Default Avatar">
                                @endif
                            </div>
                            <div class="profile-dropdown-info">
                                <h6>{{ Auth::guard('renter')->user()->UserName }}</h6>
                                <p>{{ Auth::guard('renter')->user()->Email }}</p>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-body">
                            <a href="{{ route('user-profile') }}" class="dropdown-item">
                                <i class="bi bi-person-circle"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('change-password') }}" class="dropdown-item">
                                <i class="bi bi-shield-lock"></i>
                                <span>Change Password</span>
                            </a>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item logout-item">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</nav>

<style>
    #wsus__topbar {
        padding: 5px 0;
        background: var(--colorPrimary);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        height: auto !important;
        min-height: 42px;
        display: flex;
        align-items: center;
    }

    .wsus__topbar_left {
        margin: 0 !important;
        padding: 0 !important;
        list-style: none;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .wsus__topbar_left li a {
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .wsus__topbar_left li a:hover {
        color: white;
    }

    .wsus__topbar_left li a i {
        margin-right: 6px;
        color: white;
        font-size: 0.85rem;
    }

    /* Topbar Buttons - Refined Premium Design */
    .topbar-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white !important;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(8px);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        position: relative;
    }
    
    .topbar-btn i {
        font-size: 1rem;
        transition: transform 0.3s;
        color: white !important;
        margin: 0 !important;
    }
    
    .topbar-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white !important;
        transform: translateY(-1px) scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .topbar-btn:hover i {
        transform: scale(1.1);
    }
    
    .search-btn {
        background: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
    }
    
    .search-btn i {
        color: white !important;
    }

    .search-btn:hover {
        filter: brightness(1.1) saturate(1.1);
        box-shadow: 0 6px 15px rgba(var(--colorPrimaryRgb), 0.35);
    }

    /* Global Main Button */
    .main-btn {
        background: var(--colorPrimary);
        background: linear-gradient(135deg, var(--colorPrimary) 0%, rgba(var(--colorPrimaryRgb), 0.8) 100%);
        color: white !important;
        padding: 10px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.92rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        box-shadow: 0 4px 15px rgba(var(--colorPrimaryRgb), 0.25);
        text-decoration: none;
    }

    .main-btn:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 8px 25px rgba(var(--colorPrimaryRgb), 0.4);
        color: white !important;
        filter: brightness(1.1);
    }
    
    .main-btn:active {
        transform: translateY(-1px);
    }

    /* Navbar Right Section */
    .navbar-right-section {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Icon Button (Notification) */
    .icon-button {
        position: relative;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffffff;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .icon-button:hover {
        background: #ffffff;
        transform: translateY(-2px) scale(1.05);
        border-color: var(--colorPrimary);
        box-shadow: 0 8px 20px rgba(var(--colorPrimaryRgb), 0.15);
    }

    .icon-button i {
        font-size: 1.25rem;
        color: #475569;
        transition: color 0.3s;
    }

    .icon-button:hover i {
        color: var(--colorPrimary);
    }

    .badge-count {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #ef4444;
        color: white;
        border-radius: 12px;
        padding: 2px 6px;
        font-size: 0.7rem;
        font-weight: 800;
        min-width: 20px;
        text-align: center;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    }

    /* Profile Button */
    .profile-button {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 16px 6px 6px;
        border-radius: 50px;
        background: #ffffff;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1.5px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .profile-button:hover {
        background: #ffffff;
        transform: translateY(-2px);
        border-color: var(--colorPrimary);
        box-shadow: 0 8px 20px rgba(var(--colorPrimaryRgb), 0.15);
    }

    .profile-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        text-align: left;
        max-width: 150px;
    }

    .profile-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-email {
        font-size: 0.75rem;
        color: #64748b;
        margin: 0;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-chevron {
        font-size: 0.875rem;
        color: #64748b;
        transition: transform 0.2s;
    }

    .profile-button.active .profile-chevron {
        transform: rotate(180deg);
    }

    /* Dropdown Panel */
    .dropdown-panel {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        border: 1px solid #e2e8f0;
    }

    .dropdown-panel.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Notification Dropdown */
    .notification-wrapper {
        position: relative;
    }

    .notification-dropdown {
        width: 380px;
        max-width: calc(100vw - 32px);
    }

    .dropdown-header {
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
    }

    .dropdown-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .mark-read-link {
        font-size: 0.8rem;
        color: var(--colorPrimary, #6366f1);
        text-decoration: none;
        font-weight: 600;
    }

    .mark-read-link:hover {
        text-decoration: underline;
    }

    .dropdown-body {
        max-height: 400px;
        overflow-y: auto;
    }

    .dropdown-body::-webkit-scrollbar {
        width: 6px;
    }

    .dropdown-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Notification Item */
    .notification-item {
        display: flex;
        gap: 12px;
        padding: 14px 20px;
        text-decoration: none;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }

    .notification-item:hover {
        background: #f8fafc;
    }

    .notification-item.unread {
        background: #f0f9ff;
        border-left: 3px solid var(--colorPrimary, #6366f1);
    }

    .notification-item.unread:hover {
        background: #e0f2fe;
    }

    .notification-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .notification-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-text {
        font-size: 0.875rem;
        color: #334155;
        margin: 0 0 6px 0;
        line-height: 1.4;
    }

    .notification-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-time {
        font-size: 0.75rem;
        color: #64748b;
    }

    .mark-read-btn {
        background: none;
        border: none;
        color: var(--colorPrimary, #6366f1);
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .mark-read-btn:hover {
        background: rgba(99, 102, 241, 0.1);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    .empty-state p {
        color: #64748b;
        margin: 0;
        font-size: 0.9rem;
    }

    /* Profile Dropdown */
    .profile-wrapper {
        position: relative;
    }

    .profile-dropdown {
        width: 280px;
    }

    .profile-dropdown-header {
        padding: 20px;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .profile-dropdown-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
    }

    .profile-dropdown-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-dropdown-info h6 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }

    .profile-dropdown-info p {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
    }

    .dropdown-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        text-decoration: none;
        color: #475569;
        transition: all 0.2s;
    }

    .dropdown-item:hover {
        background: #f8fafc;
        color: var(--colorPrimary, #6366f1);
    }

    .dropdown-item i {
        font-size: 1.15rem;
        width: 20px;
        text-align: center;
    }

    .dropdown-item span {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .logout-item {
        color: #ef4444;
    }

    .logout-item:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .dropdown-footer {
        padding: 12px 20px;
        text-align: center;
        border-top: 1px solid #e2e8f0;
    }

    .dropdown-footer a {
        font-size: 0.875rem;
        color: var(--colorPrimary, #6366f1);
        text-decoration: none;
        font-weight: 600;
    }

    .dropdown-footer a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .profile-info {
            display: none !important;
        }
        
        .profile-button {
            padding: 6px;
        }
        
        .notification-dropdown {
            width: 320px;
        }
        
        .profile-dropdown {
            width: 260px;
        }
    }

    @media (max-width: 576px) {
        .notification-dropdown,
        .profile-dropdown {
            width: calc(100vw - 32px);
            right: -100px;
        }
    }
</style>

<script>
    // Toggle Notifications
    function toggleNotifications() {
        const dropdown = document.getElementById('notification-dropdown');
        const profileDropdown = document.getElementById('profile-dropdown');
        const profileButton = document.getElementById('profile-button');
        
        dropdown.classList.toggle('show');
        profileDropdown.classList.remove('show');
        profileButton.classList.remove('active');
    }

    // Toggle Profile
    document.getElementById('profile-button')?.addEventListener('click', function() {
        const dropdown = document.getElementById('profile-dropdown');
        const notificationDropdown = document.getElementById('notification-dropdown');
        
        dropdown.classList.toggle('show');
        this.classList.toggle('active');
        notificationDropdown.classList.remove('show');
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const notificationWrapper = document.querySelector('.notification-wrapper');
        const profileWrapper = document.querySelector('.profile-wrapper');
        
        if (!notificationWrapper?.contains(event.target)) {
            document.getElementById('notification-dropdown')?.classList.remove('show');
        }
        
        if (!profileWrapper?.contains(event.target)) {
            document.getElementById('profile-dropdown')?.classList.remove('show');
            document.getElementById('profile-button')?.classList.remove('active');
        }
    });

    // Mark single notification as seen
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
                    e.closest('.notification-item').classList.remove('unread');
                    e.closest('.notification-item').classList.add('read');
                    e.remove();
                    
                    // Update badge count
                    const badge = document.querySelector('.badge-count');
                    if (badge) {
                        const currentCount = parseInt(badge.textContent);
                        if (currentCount > 1) {
                            badge.textContent = currentCount - 1;
                        } else {
                            badge.remove();
                        }
                    }
                }
            },
            error: function(xhr) {
                toastr.error("An error occurred");
            },
        });
    }

    // Mark all notifications as read
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
                    
                    // Update all notification items
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        item.classList.add('read');
                        item.querySelector('.mark-read-btn')?.remove();
                    });
                    
                    // Remove badge
                    document.querySelector('.badge-count')?.remove();
                }
            },
            error: function(xhr) {
                toastr.error("An error occurred");
            },
        });
    }
</script>

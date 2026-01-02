<div class="slim-header">
    <div class="container">
        <div class="slim-header-left">
            <div class="logo-img-n-text">
                <img src="{{ asset('img/logovitalg.png') }}" alt="" width="60" height="60">
            </div>
            <form action="{{ route('admin-client-search') }}" method="get" class="search-box ml-4"
                id="client-search-form">
                <input type="text" class="form-control" name="search" placeholder="Client Search" id="search">
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
            <form action="{{ route('admin-property-search') }}" method="get">
                <div class="search-box ml-2">
                    <input type="text" class="form-control" name="propertysearch" placeholder="Property Search">
                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="slim-header-right">
            {{-- <div class="dropdown dropdown-b">
                <a href="" class="header-notification" data-toggle="dropdown">
                    <i class="fa-regular fa-bell ml-3"></i>
                    <span class="counter">0</span>
                </a>
                <div class="dropdown-menu">
                    <div class="dropdown-menu-header">
                        <h6 class="dropdown-menu-title">Notifications</h6>
                        <div>
                            <a href="">Mark All as Read</a>
                            <a href="">Settings</a>
                        </div>
                    </div>
                    <div class="dropdown-list">
                        <a href="" class="dropdown-link">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body">
                                    <p><strong>Mellisa Brown</strong> appreciated your work <strong>The Social
                                            Network</strong></p>
                                    <span>October 02, 2017 12:44am</span>
                                </div>
                            </div>
                        </a>
                        <a href="" class="dropdown-link read">
                            <div class="media">
                                <img src="" alt="">
                                <div class="media-body">
                                    <p>20+ new items added are for sale in your <strong>Sale Group</strong></p>
                                    <span>October 01, 2017 10:20pm</span>
                                </div>
                            </div><!-- media -->
                        </a>

                        <div class="dropdown-list-footer">
                            <a href=""><i class="fa fa-angle-down"></i> Show All Notifications</a>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="dropdown dropdown-c">
                <a href="#" class="logged-user" data-toggle="dropdown">
                    @if (Auth::guard('admin')->user()->admin_headshot != 'default.png')
                    <img src="{{ asset('uploads/profile_pics/' . Auth::guard('admin')->user()->admin_headshot) }}"
                        alt="">
                    @else
                    <img src="{{ asset('img/temp_profile.png') }}" alt="">
                    @endif
                    <span>Welcome {{ strtoupper(@Auth::guard('admin')->user()->admin_login_id) }} !</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <nav class="nav">
                        <a href="{{ route('admin-manage-profile') }}" class="nav-link"><i class="fa-solid fa-user"></i>
                            <span class="ml-2"> Manage Your Profile </span> </a>
                        <a href="{{ route('admin-change-password') }}" class="nav-link"><i class="fa-solid fa-key"></i>
                            <span class="ml-2"> Change Password </span></a>
                        <a href="{{ route('admin.logout') }}" class="nav-link"> <i class="fa fa-sign-out"></i> 
                            <span class="ml-2"> Logout</span> </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="slim-navbar">
    <div class="container">
        <ul class="nav">
            <li class="nav-item {{ isActiveRoutes(['admin-dashboard']) }}">
                <a class="nav-link nav-routes" href="{{ route('admin-dashboard') }}">
                    <i class="fa-solid fa-house mr-1"></i>
                    <span>Home</span>
                </a>
            </li>

            <li
                class="nav-item with-sub {{ isActiveRoutes([
                    'admin-client-adduser',
                    'admin-leasedRenter',
                    'admin-search-renter',
                    'admin-call-history',
                    'admin-activeRenter',
                    'admin-inactiveRenter',
                    'admin-create-renter',
                    'admin-search-renter',
                    'admin-notify-history',
                    'admin-edit-renter',
                    'admin-view-profile',
                    'admin-unassigned-renters',
                    'admin-client-search',
                    'admin-agent-remainder',
                ]) }}
            ">
                <a class="nav-link nav-routes" href="javascript:void(0)">
                    <i class="fa-solid fa-users mr-1 mb-1"></i>
                    <span>Clients</span>
                </a>
                <div class="sub-item">
                    <ul>
                    @if (Auth::guard('admin')->user()->hasPermission('user_addedit'))
                        <li><a href="{{ route('admin-client-adduser') }}">Add New Renter</a></li>
                    @endif
                        <li><a href="{{ route('admin-activeRenter') }}"> Active Renters </a></li>
                        <li><a href="{{ route('admin-inactiveRenter') }}"> InActive Renter </a></li>
                        <li><a href="{{ route('admin-leasedRenter') }}"> Leased Renter </a></li>
                        <li><a href="{{ route('admin-unassigned-renters') }}"> Unassigned Renter </a></li>
                        <li><a href="{{ route('admin-search-renter') }}">Search Renter</a></li>
                        <li><a href="{{ route('admin-call-history') }}">Call History</a></li>
                        <li><a href="{{ route('admin-agent-remainder') }}">Agent Remainder Log</a></li>
                    </ul>
                </div>
            </li>


            <li
                class="nav-item with-sub {{ isActiveRoutes([
                    'admin-property-listproperty',
                    'admin-addProperty',
                    'admin-edit-property',
                    'admin-search-property',
                    'admin-property-display',
                    'admin-property-display',
                    'admin-school-management',
                    'admin-manage-states',
                    'admin-manage-city',
                    'admin-property-search',
                    'admin-property-searching',
                    'admin-edit-states',
                    'admin-add-states',
                    'admin-add-city',
                    'admin-view-city','admin-edit-city','admin-school-add',
                ]) }}">
                <a class="nav-link nav-routes" href="javascript:void(0)">
                    <i class="fa-solid fa-building"></i>
                    <span>Properties</span>
                </a>
                <div class="sub-item">
                    <ul>
                            <li><a href="{{ route('admin-property-listproperty') }}">List of Properties</a></li>
                        @if (Auth::guard('admin')->user()->hasPermission('property_addedit'))
                            <li><a href="{{ route('admin-addProperty') }}"> Add Property </a></li>
                        @endif
                            <li><a href="{{ route('admin-search-property') }}">Search Property</a></li>
                            <li><a href="{{ route('admin-manage-states') }}">State Management</a></li>
                            <li><a href="{{ route('admin-manage-city') }}">City Management</a></li>
                        @if (Auth::guard('admin')->user()->hasPermission('access_school_management'))
                            <li><a href="{{ route('admin-school-management') }}">School Management</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li
                class="nav-item with-sub {{ isActiveRoutes([
                    'admin-add-manager',
                    'admin-search-manager',
                    'admin-list-manager',
                    'admin-login-log',
                    'admin-add-company',
                    'admin-manage-company',
                    'admin-edit-manager',
                ]) }}
                ">
                <a class="nav-link nav-routes" href="javascript:void(0)" data-toggle="dropdown">
                    <i class="fa-regular fa-folder-open"></i>
                    <span>Resources</span>
                </a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{{ route('admin-add-manager') }}">Add Manager</a></li>
                        <li><a href="{{ route('admin-search-manager') }}">Search Manager</a></li>
                        <li><a href="{{ route('admin-list-manager') }}">List Manager</a></li>
                    </ul>
                </div>
            </li>

            <li
                class="nav-item with-sub {{ isActiveRoutes([
                    'admin-my-office-report',
                    'admin-manage-my-agents',
                    'admin-add-admin-users',
                    'admin-add-source',
                    'admin-manage-source',
                    'admin-edit-admin-users',
                ]) }}">
                <a class="nav-link nav-routes" href="#" data-toggle="dropdown">
                    <i class="fa-solid fa-bars-progress"></i>
                    <span>Administration</span>
                </a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{{ route('admin-my-office-report') }}"> My Office Report </a></li>
                        <li><a href="{{ route('admin-manage-my-agents') }}"> Manage My Agent </a></li>
                        <li><a href="{{ route('admin-manage-source') }}">Manage Source</a></li>
                    </ul>
                </div>
            </li>

            @if (Auth::guard('admin')->user()->hasPermission('content_addedit'))
            <li
                class="nav-item with-sub {{ isActiveRoutes([
                    'section-management',
                    'admin-general-settings',
                    'admin-slider-management',
                    'admin-footer-management',
                    'admin-menu-management',
                    'pages-management',
                    'admin-add-housing',
                    'admin-add-terms',
                    'admin-add-manager-terms',
                    'admin-add-slider-image',
                ]) }}">
                <a class="nav-link nav-routes" href="#" data-toggle="dropdown">
                    <i class="fa-solid fa-gear"></i>
                    <span> Settings </span>
                </a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{{ route('section-management') }}"> Sections Management </a></li>
                        <li><a href="{{ route('pages-management') }}"> Pages Management </a></li>
                        <li><a href="{{ route('admin-slider-management') }}"> Slider Management </a></li>
                        <li><a href="{{ route('admin-footer-management') }}"> Footer Management</a></li>
                        <li><a href="{{ route('admin-menu-management') }}"> Menu Management </a></li>
                        <li><a href="{{ route('admin-general-settings') }}"> Settings Management </a></li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>
<script>
    function markVisibleNotificationsAsSeen() {
        const notificationDropdown = document.getElementById('notification-dropdown');
        const unseenNotifications = Array.from(notificationDropdown.querySelectorAll('.dropdown-link.unseen'));
        const unseenIds = unseenNotifications.map(notification => notification.dataset.id);

        if (unseenIds.length > 0) {
            fetch('', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        ids: unseenIds
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        unseenNotifications.forEach(notification => {
                            notification.classList.remove('unseen');
                            notification.classList.add('read');
                        });

                        const counterElement = document.getElementById('notifications-count');
                        counterElement.textContent = data.unseenCount;
                    }
                });
        }
    }

    function markAllNotificationsAsSeen() {
        fetch('', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notifications = document.querySelectorAll('.dropdown-link');
                    notifications.forEach(notification => {
                        notification.classList.remove('unseen');
                        notification.classList.add('read');
                    });

                    const counterElement = document.getElementById('notifications-count');
                    counterElement.textContent = '0';
                }
            });
    }
</script>
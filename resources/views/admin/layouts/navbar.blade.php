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
            <div class="dropdown dropdown-b">
                <a href="" class="header-notification" data-toggle="dropdown">
                    <i class="fa-regular fa-bell ml-3"></i>
                    @if($unreadCount > 0)
                        <span class="counter" id="notifications-count">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu">
                    <div class="dropdown-menu-header">
                        <h6 class="dropdown-menu-title">Notifications</h6>
                        <div>
                            <a href="javascript:void(0)" onclick="markAllNotificationsAsSeen()">Mark All as Read</a>
                        </div>
                    </div>
                    <div class="dropdown-list" id="notification-dropdown-list">
                        @forelse($notifications as $notif)
                        <a href="{{ $notif->notification_link ?? 'javascript:void(0)' }}" 
                           class="dropdown-link {{ $notif->seen ? 'read' : 'unseen' }}" 
                           data-id="{{ $notif->id }}"
                           onclick="markThisAsSeen(this)">
                            <div class="media">
                                <img src="{{ asset('img/temp_profile.png') }}" alt="">
                                <div class="media-body">
                                    <p>{!! $notif->message !!}</p>
                                    <span>{{ $notif->CreatedOn ? $notif->CreatedOn->diffForHumans() : '' }}</span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-3 text-center text-muted">No notifications</div>
                        @endforelse

                        <div class="dropdown-list-footer">
                            <a href=""><i class="fa fa-angle-down"></i> Show All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
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
                    'admin-search-renters',
                    'admin-searched-renter-result',
                    'admin-call-history',
                    'admin-activeRenter',
                    'admin-inactiveRenter',
                    'admin-create-renter',
                    'admin-notify-history',
                    'admin-edit-renter',
                    'admin-view-profile',
                    'admin-unassigned-renters',
                    'admin-client-search',
                    'admin-agent-remainder',
                    'admin-client-infoUpdate',
                    'admin-renter-reports',
                    'admin-listing-fav',
                    'admin-listing-fav-reports',
                    'admin-switch-map-view',
                    'admin-map-search',
                ]) }}
            ">
                <a class="nav-link nav-routes" href="javascript:void(0)">
                    <i class="fa-solid fa-users mr-1 mb-1"></i>
                    <span>Clients</span>
                </a>
                <div class="sub-item">
                    <ul>
                    @if (Auth::guard('admin')->user()->hasPermission('user_addedit'))
                        <li class="{{ isActiveRoutes(['admin-client-adduser']) }}"><a href="{{ route('admin-client-adduser') }}">Add New Renter</a></li>
                    @endif
                        <li class="{{ isActiveRoutes(['admin-activeRenter']) }}"><a href="{{ route('admin-activeRenter') }}"> Active Renters </a></li>
                        <li class="{{ isActiveRoutes(['admin-inactiveRenter']) }}"><a href="{{ route('admin-inactiveRenter') }}"> InActive Renter </a></li>
                        <li class="{{ isActiveRoutes(['admin-leasedRenter']) }}"><a href="{{ route('admin-leasedRenter') }}"> Leased Renter </a></li>
                        <li class="{{ isActiveRoutes(['admin-lease-reports']) }}"><a href="{{ route('admin-lease-reports') }}"> Lease Reports <span class="badge badge-info ml-1">New</span> </a></li>
                        <li class="{{ isActiveRoutes(['admin-unassigned-renters']) }}"><a href="{{ route('admin-unassigned-renters') }}"> Unassigned Renter </a></li>
                        <li class="{{ isActiveRoutes(['admin-search-renter']) }}"><a href="{{ route('admin-search-renter') }}">Search Renter</a></li>
                        <li class="{{ isActiveRoutes(['admin-call-history']) }}"><a href="{{ route('admin-call-history') }}">Call History</a></li>
                        <li class="{{ isActiveRoutes(['admin-agent-remainder']) }}"><a href="{{ route('admin-agent-remainder') }}">Agent Remainder Log</a></li>
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
                    'admin-renter-property-display',
                    'admin-school-management',
                    'admin-manage-states',
                    'admin-manage-city',
                    'admin-property-search',
                    'admin-property-searching',
                    'admin-edit-states',
                    'admin-add-states',
                    'admin-add-city',
                    'admin-view-city',
                    'admin-edit-city',
                    'admin-school-add',
                    'admin-fee-management',
                    'admin-pets-management',
                ]) }}">
                <a class="nav-link nav-routes" href="javascript:void(0)">
                    <i class="fa-solid fa-building"></i>
                    <span>Properties</span>
                </a>
                <div class="sub-item">
                    <ul>
                            <li class="{{ isActiveRoutes(['admin-property-listproperty']) }}"><a href="{{ route('admin-property-listproperty') }}">List of Properties</a></li>
                        @if (Auth::guard('admin')->user()->hasPermission('property_addedit'))
                            <li class="{{ isActiveRoutes(['admin-addProperty']) }}"><a href="{{ route('admin-addProperty') }}"> Add Property </a></li>
                        @endif
                            <li class="{{ isActiveRoutes(['admin-search-property']) }}"><a href="{{ route('admin-search-property') }}">Search Property</a></li>
                            <li class="{{ isActiveRoutes(['admin-manage-states']) }}"><a href="{{ route('admin-manage-states') }}">State Management</a></li>
                            <li class="{{ isActiveRoutes(['admin-manage-city']) }}"><a href="{{ route('admin-manage-city') }}">City Management</a></li>
                        @if (Auth::guard('admin')->user()->hasPermission('access_school_management'))
                            <li class="{{ isActiveRoutes(['admin-school-management']) }}"><a href="{{ route('admin-school-management') }}">School Management</a></li>
                        @endif
                        <li class="{{ isActiveRoutes(['admin-pets-management']) }}"><a href="{{ route('admin-pets-management') }}">Pets Management</a></li>
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
                        <li class="{{ isActiveRoutes(['admin-add-manager']) }}"><a href="{{ route('admin-add-manager') }}">Add Manager</a></li>
                        <li class="{{ isActiveRoutes(['admin-search-manager']) }}"><a href="{{ route('admin-search-manager') }}">Search Manager</a></li>
                        <li class="{{ isActiveRoutes(['admin-list-manager']) }}"><a href="{{ route('admin-list-manager') }}">List Manager</a></li>
                        <li class="{{ isActiveRoutes(['admin-add-company']) }}"><a href="{{ route('admin-add-company') }}">Add Company</a></li>
                        <li class="{{ isActiveRoutes(['admin-manage-company']) }}"><a href="{{ route('admin-manage-company') }}">Manage Company</a></li>
                        <li class="{{ isActiveRoutes(['admin-revert-contactus']) }}"><a href="{{ route('admin-revert-contactus') }}">Contact Us Requests</a></li>
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
                        <li class="{{ isActiveRoutes(['admin-my-office-report']) }}"><a href="{{ route('admin-my-office-report') }}"> My Office Report </a></li>
                        <li class="{{ isActiveRoutes(['admin-manage-my-agents']) }}"><a href="{{ route('admin-manage-my-agents') }}"> Manage My Agent </a></li>
                        <li class="{{ isActiveRoutes(['admin-manage-source']) }}"><a href="{{ route('admin-manage-source') }}">Manage Source</a></li>
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
                        <li class="{{ isActiveRoutes(['section-management']) }}"><a href="{{ route('section-management') }}"> Sections Management </a></li>
                        <li class="{{ isActiveRoutes(['pages-management']) }}"><a href="{{ route('pages-management') }}"> Pages Management </a></li>
                        <li class="{{ isActiveRoutes(['admin-slider-management']) }}"><a href="{{ route('admin-slider-management') }}"> Slider Management </a></li>
                        <li class="{{ isActiveRoutes(['admin-footer-management']) }}"><a href="{{ route('admin-footer-management') }}"> Footer Management</a></li>
                        <li class="{{ isActiveRoutes(['admin-menu-management']) }}"><a href="{{ route('admin-menu-management') }}"> Menu Management </a></li>
                        <li class="{{ isActiveRoutes(['admin-general-settings']) }}"><a href="{{ route('admin-general-settings') }}"> Settings Management </a></li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>
<script>
    function markThisAsSeen(e) {
        const notificationid = e.dataset.id;
        if (e.classList.contains('unseen')) {
            fetch("{{ route('admin-mark-as-seen') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: notificationid }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    e.classList.remove('unseen');
                    e.classList.add('read');
                    const counter = document.getElementById('notifications-count');
                    if (counter) {
                        let count = parseInt(counter.textContent);
                        if (count > 1) {
                            counter.textContent = count - 1;
                        } else {
                            counter.remove();
                        }
                    }
                }
            });
        }
    }

    function markAllNotificationsAsSeen() {
        fetch("{{ route('admin-mark-all-as-read') }}", {
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
                    if (counterElement) counterElement.remove();
                    toastr.success(data.message);
                }
            });
    }
</script>
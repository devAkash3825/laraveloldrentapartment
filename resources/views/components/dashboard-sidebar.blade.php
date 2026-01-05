<div class="dashboard_sidebar premium-sidebar">
    <span class="close_icon"><i class="fa-solid fa-xmark"></i></span>

    <div class="dash_logo_wrapper">
        <a href="javascript:void(0)" class="dash_logo">
            @if (Auth::guard('renter')->user()->profile_pic != '')
                <img src="{{ asset('uploads/profile_pics/' . Auth::guard('renter')->user()->profile_pic) }}" alt="img"
                    class="img-fluid profile-img-main">
            @else
                <img src="{{ asset('img/avatar-of-aavtarimg.jpg') }}" alt="logo" class="img-fluid profile-img-main">
            @endif
        </a>
        <h5 class="mt-3 text-center profile-name">
             @if (Auth::guard('renter')->user()->user_type == 'M')
                {{ Auth::guard('renter')->user()->UserName }}
             @else
                {{ Auth::guard('renter')->user()->renterinfo->Firstname ?? '' }} {{ Auth::guard('renter')->user()->renterinfo->Lastname ?? '' }}
             @endif
        </h5>
        <p class="text-center badge rounded-pill bg-primary-gradient px-3">
            {{ Auth::guard('renter')->user()->user_type == 'M' ? 'Manager' : 'Renter' }}
        </p>
    </div>

    <ul class="dashboard_link">
        <li><a class="{{ isActiveRoute('user-profile') }}" href="{{ route('user-profile') }}">
            <i class="fa-solid fa-user-gear"></i> My Profile</a>
        </li>
        @if (Auth::guard('renter')->check())
            @if (Auth::guard('renter')->user()->user_type == 'M')
                <li><a class="{{ isActiveRoute('my-properties') }} || {{ isActiveRoute('edit-properties') }} "
                        href="{{ route('my-properties') }}"><i class="fa-solid fa-house-chimney"></i> My Properties </a>
                </li>

                <li><a class="{{ isActiveRoute('add-property') }} " href="{{ route('add-property') }}">
                        <i class="fa-solid fa-circle-plus"></i> Add Property </a>
                </li>

                <li>
                    <a class="{{ isActiveRoute('referred-renter') }}" href="{{ route('referred-renter') }}">
                        <i class="fa-solid fa-users-rectangle"></i> Referred Renters
                    </a>
                </li>
            @endif
        @endif
        <li><a class="{{ isActiveRoute('messages-tab') }}" href="{{ route('messages-tab') }}">
            <i class="fa-solid fa-envelope-open-text"></i> Messages</a>
        </li>
        <li> <a class="nav-link {{ isActiveRoute('list-view') || isActiveRoute('thumbnail-view') || isActiveRoute('map-view') || isActiveRoute('street-view') ? 'active' : '' }}"
                href="{{ route('list-view') }}"><i class="fa-solid fa-heart-pulse"></i> My Favorites</a>
        </li>
        <li> <a class="{{ isActiveRoute('recently-visited') }}" href="{{ route('recently-visited') }}">
            <i class="fa-solid fa-clock-rotate-left"></i> Recently Visited </a>
        </li>
        <li class="mt-4">
            <a href="{{ route('logout') }}" class="text-danger">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </li>
    </ul>
</div>

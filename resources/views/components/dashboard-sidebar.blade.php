<div class="dashboard_sidebar">
    <span class="close_icon"><i class="far fa-times" aria-hidden="true"></i></span>

    <a href="javascript:void(0)" class="dash_logo">
        @if (Auth::guard('renter')->user()->profile_pic != '')
            <img src="{{ asset('uploads/profile_pics/' . Auth::guard('renter')->user()->profile_pic) }}" alt="img"
                class="imf-fluid w-100" style="height:200px !important;">
        @else
            <img src="{{ asset('img/avatar-of-aavtarimg.jpg') }}" alt="logo" class="img-fluid">
        @endif
    </a>
    <ul class="dashboard_link">
        <li><a class="{{ isActiveRoute('user-profile') }}" href="{{ route('user-profile') }}"><i class="far fa-user"
                    aria-hidden="true"></i> My Profile</a></li>
        @if (Auth::guard('renter')->check())
            @if (Auth::guard('renter')->user()->user_type == 'M')
                <li><a class="{{ isActiveRoute('my-properties') }} || {{ isActiveRoute('edit-properties') }} "
                        href="{{ route('my-properties') }}"><i class="fas fa-list-ul" aria-hidden="true"></i> My
                        Properties </a>
                </li>

                <li><a class="{{ isActiveRoute('add-property') }} " href="{{ route('add-property') }}">
                        <i class="fal fa-plus-circle" aria-hidden="true"></i> Add Property </a>
                </li>

                <li>
                    <a class="{{ isActiveRoute('referred-renter') }}" href="{{ route('referred-renter') }}">
                        <i class="bi bi-person-plus-fill"></i> Referred Renters
                    </a>
                </li>
            
            @endif
        @endif
        <li><a class="{{ isActiveRoute('messages-tab') }}" href="{{ route('messages-tab') }}"><i class="far fa-envelope" aria-hidden="true"></i> Messages</a></li>
        <li> <a class="nav-link {{ isActiveRoute('list-view') || isActiveRoute('thumbnail-view') || isActiveRoute('map-view') || isActiveRoute('street-view') ? 'active' : '' }}"
                href="{{ route('list-view') }}"><i class="far fa-heart" aria-hidden="true"></i> My Favorites</a></li>
        <li> <a class="{{ isActiveRoute('recently-visited') }}" href="{{ route('recently-visited') }}"><i
                    class="far fa-history" aria-hidden="true"></i> Recently Visited </a></li>
    </ul>
</div>

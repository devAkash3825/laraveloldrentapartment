<!-- 
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">
        <nav id="navbar" class="navbar">
            <div class="logo">
                <h1 class="text-light"><a href="{{url('/') }}">
                        <img src="{{asset('img/logovitalg.png')}}" alt="" srcset="" style="width:65px;"></a>
                </h1>
            </div>
            <ul>
                <li>
                    <a class="{{ isActiveRoute('home') }}" href="{{url('/') }}">Home</a>
                </li>
                <li>
                    <a class="{{ isActiveRoute('myfavorites') }}" href="{{ route('myfavorites')}}">Favorite</a>
                </li>
                <li>
                    <a class="{{ isActiveRoute('add-property')}} || {{ isActiveRoute('my-properties') }}"
                        href="{{route('my-properties')}}">Property</a>
                </li>
                <li>
                    @if(@Auth::guard('renter')->user()->user_type == 'C')
                    <a class="{{ isActiveRoute('customer-feedback')}}" href="{{ route('customer-feedback')}}">Customer
                        Service</a>
                    @endif
                </li>
                <li>
                    <a class="{{ isActiveRoute('about') }}" href="{{route('about')}}">About</a>
                </li>
            </ul>
        </nav>



        <div class="d-flex gap-3">
            @guest('renter')
            <nav id="navbar" class="navbar">
                <ul>
                    <div class="d-flex">
                        <li><a class="getstarted" href="{{route('show.login')}}">{{ __('Login') }}</a></li>
                        <li><a class="getstarted" href="{{route('show.login')}}">{{ __('Register') }}</a></li>
                    </div>

                </ul>
            </nav>
            <button style="background-color:var(--btn-color1);height:35px;padding:6px 11px;margin-top:7px;"
                class="btn text-white btn-sm search-btn navbar-toggle-box navbar-toggle-box-collapse"
                data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
                <span><i class="fa-solid fa-magnifying-glass" style="color:#ffffff;"></i></span>
            </button>
            @else
            <button style="background-color:var(--btn-color1);height:35px;padding:6px 11px;margin-top: 3px;"
                class="btn text-white btn-sm search-btn navbar-toggle-box navbar-toggle-box-collapse"
                data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
                <span><i class="fa-solid fa-magnifying-glass" style="color:#ffffff;"></i></span>
            </button>

            <div class="action align-items-center d-flex position-relative" onclick="menuToggle();">
                <div class="profile">
                    <img src="{{asset('img/avatar-of-aavtarimg.jpg')}}">
                </div>
                <div class="menu">
                    <ul>
                        <li>
                            <a href="#">{{ strtoupper(@Auth::guard('renter')->user()->UserName) }}</a>
                        </li>
                        <li>
                            <a href="">Change Password</a>
                        </li>

                        <li>
                            <a href="{{route('logout')}}">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
            @endguest
        </div>
        <i class="bi bi-list mobile-nav-toggle"></i>
    </div>
    // function menuToggle() {
//     const toggleMenu = document.querySelector(".menu");
//     toggleMenu.classList.toggle("active");
// }
</header> -->

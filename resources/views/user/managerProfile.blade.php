@extends('user.layout.app')
@section('content')
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Manager Profile</h1>
                <p class="text-white opacity-75 lead mb-0">Learn more about our real estate professionals</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Professional Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
    <section id="wsus__agent_profile">
        <div class="container">
            <div class="profile-section">
                <div id="card">
                    <img id="avatar" src="https://www.shutterstock.com/image-vector/handsome-businessman-avatar-profile-character-260nw-1216439494.jpg"
                        alt="avatar" />
                    <div id="info">
                        <p id="name">{{ $managerProfile->UserName }}</p>
                        <p id="activity">{{ $managerProfile->about_me }}</p>
                        <div class="wsus__profile_text mt-1">
                            <a href="mailto:example@gmail.com"><i class="fal fa-envelope-open" aria-hidden="true"></i>
                                {{ $managerProfile->Email }} </a>
                            <a href="callt0:+695877744455222"><i class="fas fa-phone-alt" aria-hidden="true"></i>
                                {{ $managerProfile->Email }}</a>
                        </div>
                        <div id="stats">
                            <p class="stats-text">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path
                                        d="M320.7 352c8.1-89.7 83.5-160 175.3-160c8.9 0 17.6 .7 26.1 1.9L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1l32 0 0 69.7c-.1 .9-.1 1.8-.1 2.8l0 112c0 22.1 17.9 40 40 40l16 0c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2l31.9 0 24 0c22.1 0 40-17.9 40-40l0-24 0-64c0-17.7 14.3-32 32-32l64 0 .7 0zM496 512a144 144 0 1 0 0-288 144 144 0 1 0 0 288zm0-96a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm0-144c8.8 0 16 7.2 16 16l0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80c0-8.8 7.2-16 16-16z" />
                                </svg>
                                <span>5k</span>
                                InActive Properties
                            </p>
                            <p class="stats-text">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path
                                        d="M320.7 352c8.1-89.7 83.5-160 175.3-160c8.9 0 17.6 .7 26.1 1.9L309.5 7c-6-5-14-7-21-7s-15 1-22 8L10 231.5c-7 7-10 15-10 24c0 18 14 32.1 32 32.1l32 0 0 69.7c-.1 .9-.1 1.8-.1 2.8l0 112c0 22.1 17.9 40 40 40l16 0c1.2 0 2.4-.1 3.6-.2c1.5 .1 3 .2 4.5 .2l31.9 0 24 0c22.1 0 40-17.9 40-40l0-24 0-64c0-17.7 14.3-32 32-32l64 0 .7 0zM640 368a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L480 385.4l60.7-60.7c6.2-6.2 16.4-6.2 22.6 0z" />
                                </svg>
                                <span>147</span>
                                Active Properties
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- @foreach ($userProperties as $item)
                    <div class="col-xl-3 col-sm-6 col-lg-4">
                        <a href="#" class="wsus__single_location">
                            <div class="img">
                                <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $item->Id }}/Original/{{ $item->gallerytype->gallerydetail[0]->ImageName ?? 'default.jpg' }}"
                                    alt="location" class="img-fluid w-100">
                            </div>
                            <div class="wsus__location_text">
                                <p> {{ $item->PropertyName }}</p>
                                <span>{{ $item->city->CityName }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach --}}



                @if (isset($userProperties) && is_countable($userProperties) && count($userProperties) > 0)
                    @foreach ($userProperties as $row)
                        <div class="col-lg-3 col-md-6 col-sm-12 grid-item">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('property-display', ['id' => $row['Id']]) }}">
                                        @php
                                            $imageName = $row->gallerytype->gallerydetail[0]->ImageName ?? null;
                                        @endphp

                                        @if ($imageName)
                                            <img class="grid-property-img"
                                                src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $row['Id'] }}/Original/{{ $imageName }}"
                                                alt="Property Image">
                                        @else
                                            <img class="img-fluid" src="{{ asset('img/no-img.jpg') }}" alt="Default Image">
                                        @endif
                                    </a>
                                </div>
                                <div class="px-1 py-4 pb-0">
                                    <a class="d-block h5 mb-2" href="{{ route('property-display', ['id' => $row['Id']]) }}"
                                        style="overflow: hidden;text-wrap:nowrap;">{{ @$row->PropertyName }}
                                    </a>
                                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $row->Zip }},
                                        {{ @$row->city->CityName }} {{ @$row->city->state->StateName }}
                                        {{ @$row['area'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <section class="not-found-section">
                        <div class="empty-state">
                            <div class="empty-state__content">
                                <div class="empty-state__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision"
                                        text-rendering="geometricPrecision" image-rendering="optimizeQuality"
                                        fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 481.322">
                                        <path fill="#363C56"
                                            d="M512 129.801V12.236c0-3.1-1.164-5.903-3.097-8.075l-.534-.589A12.176 12.176 0 00499.71 0H238.048a12.154 12.154 0 00-8.65 3.572v.055c-1.985 1.936-3.275 4.598-3.531 7.52v147.46l150.97 119.817v77.524h49.649a6.97 6.97 0 016.966 6.97v112.796h78.541V129.801H512z" />
                                        <path fill="#D35F65"
                                            d="M496.692 475.714V15.26H241.075v155.414l135.762 107.75v197.29z" />
                                        <path fill="#363C56" fill-rule="nonzero"
                                            d="M351.265 258.128h37.951c1.605 0 3.12.67 4.212 1.762a5.926 5.926 0 011.762 4.208v47.025a5.99 5.99 0 01-1.755 4.212l-.592.507a5.948 5.948 0 01-3.627 1.245h-12.379v-38.663l-25.572-20.296zM278.691 69.265h40.658c1.615 0 3.117.671 4.208 1.762a5.927 5.927 0 011.763 4.208v47.025a5.98 5.98 0 01-1.756 4.216 5.978 5.978 0 01-4.215 1.755h-40.658a5.982 5.982 0 01-4.212-1.762 5.93 5.93 0 01-1.762-4.209V75.235c0-1.645.688-3.147 1.756-4.215l.571-.489a5.937 5.937 0 013.647-1.266zm139.734 0h40.658c1.615 0 3.124.674 4.212 1.762a5.93 5.93 0 011.762 4.208v47.025a5.98 5.98 0 01-1.756 4.216l-.571.489a5.937 5.937 0 01-3.647 1.266h-40.658a5.978 5.978 0 01-4.215-1.755 5.983 5.983 0 01-1.755-4.216V75.235c0-1.645.688-3.147 1.755-4.215l.534-.462a5.922 5.922 0 013.681-1.293zm-69.867 0h40.658c1.605 0 3.12.671 4.212 1.762a5.93 5.93 0 011.762 4.208v47.025a5.983 5.983 0 01-1.755 4.216l-.558.479a5.947 5.947 0 01-3.661 1.276h-40.658a5.978 5.978 0 01-4.215-1.755l-.462-.534a5.922 5.922 0 01-1.293-3.682V75.235c0-1.625.674-3.12 1.762-4.208a5.955 5.955 0 014.208-1.762zm-69.867 94.433h40.658c1.635 0 3.137.674 4.215 1.752l.479.561a5.894 5.894 0 011.277 3.654v47.028a5.956 5.956 0 01-1.756 4.212l-.533.462a5.92 5.92 0 01-3.682 1.294h-12.773l-33.859-26.873v-26.123a5.96 5.96 0 011.762-4.208 5.914 5.914 0 014.212-1.759zm139.734 0h40.658c1.642 0 3.141.674 4.218 1.752l.48.561a5.9 5.9 0 011.276 3.654v47.028c0 1.626-.678 3.1-1.735 4.178l-.031.028a5.918 5.918 0 01-4.208 1.762h-40.658a5.965 5.965 0 01-4.208-1.762 5.911 5.911 0 01-1.762-4.206v-47.028c0-1.625.674-3.12 1.762-4.208a5.917 5.917 0 014.208-1.759zm-69.867 0h40.658c1.642 0 3.141.674 4.219 1.752l.479.561a5.9 5.9 0 011.276 3.654v47.028c0 1.626-.678 3.1-1.735 4.178l-.031.028a5.918 5.918 0 01-4.208 1.762h-40.658a5.955 5.955 0 01-4.208-1.762 5.907 5.907 0 01-1.762-4.206v-47.028c0-1.625.674-3.12 1.762-4.208a5.917 5.917 0 014.208-1.759zm69.867 94.43h40.658c1.615 0 3.124.674 4.212 1.762a5.926 5.926 0 011.762 4.208v47.025a5.986 5.986 0 01-1.756 4.212l-.588.503a5.93 5.93 0 01-3.63 1.249h-40.658a5.99 5.99 0 01-5.97-5.964v-47.025c0-1.646.688-3.148 1.755-4.215l.534-.462a5.922 5.922 0 013.681-1.293z" />
                                        <path fill="#F8DF9E"
                                            d="M357.338 262.949h31.878c.626 0 1.153.527 1.153 1.149v47.025c0 .616-.527 1.143-1.153 1.143h-12.379v-33.842l-19.499-15.475zM278.691 74.086h40.658c.623 0 1.15.527 1.15 1.149v47.025c0 .623-.527 1.15-1.15 1.15h-40.658a1.166 1.166 0 01-1.153-1.15V75.235c0-.622.527-1.149 1.153-1.149zm139.734 0h40.658c.626 0 1.153.527 1.153 1.149v47.025c0 .623-.527 1.15-1.153 1.15h-40.658a1.165 1.165 0 01-1.149-1.15V75.235c0-.622.526-1.149 1.149-1.149zm-69.867 0h40.658c.626 0 1.153.527 1.153 1.149v47.025c0 .623-.527 1.15-1.153 1.15h-40.658a1.166 1.166 0 01-1.149-1.15V75.235c0-.622.527-1.149 1.149-1.149zm-69.867 94.433h40.658c.623 0 1.15.523 1.15 1.146v47.028c0 .62-.527 1.147-1.15 1.147H300.5l-22.962-18.227v-29.948c0-.623.527-1.146 1.153-1.146zm139.734 0h40.658c.626 0 1.153.523 1.153 1.146v47.028c0 .62-.527 1.147-1.153 1.147h-40.658a1.164 1.164 0 01-1.149-1.147v-47.028c0-.623.526-1.146 1.149-1.146zm-69.867 0h40.658c.626 0 1.153.523 1.153 1.146v47.028c0 .62-.527 1.147-1.153 1.147h-40.658a1.165 1.165 0 01-1.149-1.147v-47.028c0-.623.527-1.146 1.149-1.146zm69.867 94.43h40.658c.626 0 1.153.527 1.153 1.149v47.025c0 .616-.527 1.143-1.153 1.143h-40.658a1.164 1.164 0 01-1.149-1.143v-47.025c0-.622.526-1.149 1.149-1.149z" />
                                        <path fill="#C73F43" d="M496.691 39.383V15.261H241.077v24.122z" />
                                        <path fill="#F8EFE0"
                                            d="M32.265 481.293V332.268c-6.558 2.521-12.696 2.576-17.797.838-3.979-1.345-7.341-3.753-9.808-6.864C2.194 323.13.623 319.349.146 315.17c-.725-6.474 1.206-13.786 6.729-20.654.281-.335.587-.67.951-.951L171.621 170.79c-.998.747 59.142 40.724 163.963 122.214.251.197.477.39.7.645 7.428 7.986 9.275 16.843 7.483 24.322a22.674 22.674 0 01-5.101 9.757 22.099 22.099 0 01-9.079 6.136c-5.607 2.018-12.274 1.963-19.029-1.232v148.307h-15.695l-246.902.383-15.696-.029z" />
                                        <path fill="#313A58"
                                            d="M32.265 481.292V332.267c-6.558 2.521-12.695 2.578-17.796.84-3.98-1.345-7.342-3.755-9.808-6.866-2.467-3.111-4.037-6.894-4.513-11.07-.729-6.474 1.205-13.788 6.725-20.655.281-.336.59-.672.953-.953l159.913-124.852a5.853 5.853 0 017.567-.309l160.278 124.601c.252.197.477.392.701.644 7.427 7.987 9.276 16.843 7.483 24.326a22.685 22.685 0 01-5.101 9.754 22.082 22.082 0 01-9.08 6.137c-5.606 2.018-12.275 1.962-19.03-1.233V480.94h-15.694V325.737c0-2.831-109.943-89.738-122.078-99.183-12.864 9.781-124.826 95.988-124.826 99.631v155.136l-15.694-.029z" />
                                        <path fill="#313A58" fill-rule="nonzero"
                                            d="M172.201 305.622c16.806 0 32.083 6.873 43.141 17.932 11.058 11.058 17.932 26.331 17.932 43.138v64.752H111.13v-64.752c0-16.807 6.874-32.08 17.932-43.138 11.059-11.059 26.333-17.932 43.139-17.932zm-60.554 139.206h121.111v9.779H111.647v-9.779z" />
                                        <path fill="#ABB9BC"
                                            d="M177.09 315.599c25.962 2.483 46.443 24.511 46.443 51.093v.137H177.09v-51.23zm46.443 61.008v45.095H177.09v-45.095h46.443zm-56.222 45.095h-46.44v-45.095h46.44v45.095zm-46.44-54.873v-.137c0-26.582 20.478-48.61 46.44-51.093v51.23h-46.44z" />
                                        <path fill="#313A58" fill-rule="nonzero"
                                            d="M120.871 366.829h46.44V314.89h9.779v51.939h46.443v9.778H177.09v45.181h-9.779v-45.181h-46.44z" />
                                        <path fill="#D93133"
                                            d="M32.265 332.267c-6.558 2.521-12.695 2.578-17.796.84-3.98-1.345-7.342-3.755-9.808-6.866-2.467-3.111-4.037-6.894-4.513-11.07-.729-6.474 1.205-13.788 6.725-20.655.281-.336.59-.672.953-.953l159.913-124.852a5.853 5.853 0 017.567-.309l160.278 124.601c.252.197.477.392.701.644 7.427 7.987 9.276 16.843 7.483 24.326a22.685 22.685 0 01-5.101 9.754 22.082 22.082 0 01-9.08 6.137c-5.606 2.018-12.275 1.962-19.03-1.233l-15.694-6.894c0-2.831-109.943-89.738-122.078-99.183-12.864 9.781-124.826 95.988-124.826 99.631l-15.694 6.082z" />
                                    </svg>
                                </div>
                                <div class="empty-state__message">No records has been added yet.</div>
                            </div>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </section>
@endsection

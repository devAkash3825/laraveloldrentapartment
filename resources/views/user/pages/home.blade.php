@extends('user.layout.app')
@section('title', 'RentApartements | Home ')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
@endpush
@section('content')
<div class="container-fluid slider-header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 px-5">
            <h1 class="display-5 animated fadeIn mb-4 py-2">
                Find A <span class="text-lg color-text1" style="font-size:3.8rem;">Perfect Home</span> To Live With
                Your Family
            </h1>

            @guest('renter')
            <a href="{{ route('show-login') }}" class="main-btn">Get Started</a>
            @endguest
        </div>
        <div class="col-md-6 animated fadeIn">
            <div class="owl-carousel header-carousel">
                @foreach ($sliderImages as $sliderImage)
                <div class="owl-carousel-item">
                    <img src="{{ $sliderImage->image_path }}" alt="{{ $sliderImage->alt_text }}"
                        style="object-fit:cover;height:450px;" />
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<section id="wsus__features">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 m-auto">
                <div class="wsus__heading_area">
                    <h2>{{ $sectionTitle?->our_feature_title }}</h2>
                    <p>{{ $sectionTitle?->our_feature_sub_title }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($ourFeatures as $feature)
            <div class="col-xl-4 col-md-6">
                <div class="wsus__feature_single ">
                    <div class="icon">
                        <i class="{{ $feature->icon }}"></i>
                    </div>
                    <h5>{{ $feature->title }}</h5>
                    <p>{{ $feature->short_description }}</p>
                    <span>{{ ++$loop->index }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="wsus__counter"
    style="background: url({{ asset(@$counter->background) }});background-position: center;
        background-size: cover;
        background-repeat: no-repeat;">
    <div class="wsus__counter_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <i class="fa-solid fa-people-group"></i>
                        <span class="counter">{{ $totalAdmins }}</span>
                        <p>Our Team</p>
                    </div>
                </div>
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <i class="fa-brands fa-renren"></i>
                        <span class="counter">{{ $totalRenters }}</span>
                        <p>Total Renters</p>
                    </div>
                </div>
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <i class="fa-solid fa-people-roof"></i>
                        <span class="counter">{{ $totalManagers }}</span>
                        <p>Total Managers</p>
                    </div>
                </div>
                <div class="col-xl-3 col-6 col-md-3">
                    <div class="wsus__counter_single">
                        <i class="fa-solid fa-house-user"></i>
                        <span class="counter">{{ $totalProperties }}</span>
                        <p>Total Properties</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="wsus__properties">
    <div class="container">

        <div class="row">
            <div class="col-xl-5 m-auto">
                <div class="wsus__heading_area">
                    <h2>{{ $sectionTitle?->our_featured_listing_title }}</h2>
                    <p>{{ $sectionTitle?->our_featured_listing_sub_title }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach ($featuredProperties as $item)
            <div class="col-xl-3 col-md-4 col-sm-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="property-item rounded overflow-hidden">
                    <div class="position-relative overflow-hidden">
                        <a href="{{ route('property-display', ['id' => $item['Id']]) }}">
                            @php
                            $imageName = $item->gallerytype->gallerydetail[0]->ImageName ?? null;
                            @endphp

                            @if ($imageName)
                            <img class="grid-property-img"
                                src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $item['Id'] }}/Original/{{ $imageName }}"
                                alt="Property Image">
                            @else
                            <img class="grid-property-img" src="{{ asset('img/no-img.jpg') }}"
                                alt="Default Image">
                            @endif
                        </a>
                    </div>
                    <div class="px-1 py-4 pb-2 px-3">
                        <a class="d-block h5 mb-2 list-property-name"
                            href="{{ route('property-display', ['id' => $item['Id']]) }}">{{ $item->PropertyName }}</a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{ route('list-properties') }}" class="main-btn py-2 px-4 float-center"> Browse More </a>
            </div>
        </div>

    </div>
</section>

@endsection
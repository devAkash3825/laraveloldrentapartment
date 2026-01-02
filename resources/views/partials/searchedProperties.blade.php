@extends('user.layout.app')
@section('title', 'RentApartements | Search Properties ')
@section('content')
    <div id="breadcrumb_part"
        style="background: url(../images/breadcroumb_bg.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>Search Property </h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home')}}"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> listing </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section id="listing_grid" class="grid_view">
        <div class="container">
            <div class="row">
                @if(isset($advancesearch) && is_countable($advancesearch) && count($advancesearch) > 0)
                <div class="col-lg-12 col-md-4 p-3">
                    <div class="row">
                        @foreach ($advancesearch as $property)
                            <div class="col-lg-3 col-md-6 grid-item">
                                <div class="property-item rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href="{{ route('property-display', ['id' => $property->Id]) }}">
                                            @php
                                                $imageName = $property->gallerytype->gallerydetail[0]->ImageName ?? null;
                                            @endphp
                                            
                                            @if ($imageName)
                                                <img class="grid-property-img" src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $property->Id }}/Original/{{ $imageName }}" alt="Property Image">
                                            @else
                                                <img src="{{ asset('img/No_Image_Available.jpg') }}" alt="" height="100" width="200">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="px-1 py-4 pb-0">
                                        <a class="d-block h5 mb-2"
                                            href="{{ route('property-display', ['id' => $property->Id]) }}"
                                            style="overflow: hidden;text-wrap:nowrap;">{{ $property->address }}
                                        </a>
                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 Street,
                                            
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <p>No properties found.</p>
                @endif
            </div>
            <div id="pagination">
                @include('partials.pagination_links', ['paginator' => $advancesearch])
            </div>
        </div>
    </section>
@endsection

@extends('user.layout.app')
@section('title', 'RentApartements | Search Properties ')
@section('content')
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Search Results</h1>
                <p class="text-white opacity-75 lead mb-0">Explore properties matching your criteria</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Search</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


    <section id="listing_grid" class="grid_view">
        <div class="container">
            <div>
                @if (isset($advancesearch) && is_countable($advancesearch) && count($advancesearch) > 0)
                    <div class="row g-4">
                        @foreach ($advancesearch as $property)
                            <div class="col-lg-3 col-md-6 col-sm-12 grid-item">
                                <div class="property-item rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href="{{ route('property-display', ['id' => $property->Id]) }}">
                                            @php
                                                $imageName = $property->gallerytype->gallerydetail[0]->ImageName ?? null;
                                            @endphp

                                            @if ($imageName)
                                                <img class="grid-property-img"
                                                    src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $property->Id }}/Original/{{ $imageName }}" alt="Property Image">
                                            @else
                                                <img src="{{ asset('img/No_Image_Available.jpg') }}" alt="" height="100" width="200">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="px-1 py-4 pb-0">
                                        <a class="d-block h5 mb-2 list-property-name"
                                            href="{{ route('property-display', ['id' => $property->Id]) }}" style="overflow: hidden;text-wrap:nowrap;">{{ @$property->PropertyName }}
                                        </a>
                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ @$property->Zip}},{{ @$property->Address}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No properties found.</p>
                @endif
            </div>
            <div id="pagination">
                @include('partials.redirect_pagination', ['paginator' => $advancesearch])
            </div>
        </div>
    </section>
@endsection

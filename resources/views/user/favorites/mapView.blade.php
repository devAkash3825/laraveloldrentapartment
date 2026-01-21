@extends('user.layout.app')
@section('title', 'RentApartements | Map View ')
@section('content')
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Interactive Map</h1>
                <p class="text-white opacity-75 lead mb-0">Explore your favorite properties geographically</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Map View</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
    <section id="panels">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <x-dashboard-sidebar />
                </div>
                <div class="col-lg-9 ps-lg-4">
                    <div class="mb-4">
                        <x-favorite-sidebar />
                    </div>
                    @if (count($mapdata) > 0)
                        <span id="map" style="height:500px;float:left;" class="mt-3"></span>
                        <div class="col-md-6 p-0">
                            <input type="hidden" id="lat" value="">
                            <input type="hidden" id="long" value="">
                            <input type="hidden" id="fieldname" value="">
                            <input type="hidden" id="fieldaddress" value="">
                        </div>
                    @else
                        <div class="col-12 mt-4">
                            <div class="card border-0 shadow-sm p-5 text-center">
                                <div class="mb-4">
                                    <i class="fa-solid fa-map-location-dot fa-4x text-light" style="opacity: 0.5;"></i>
                                </div>
                                <h4 class="fw-bold mb-2">No properties on map</h4>
                                <p class="text-muted mb-4 lead">You haven't added any properties to your favorites to display here.</p>
                                <div>
                                    <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                                        <i class="fa-solid fa-magnifying-glass me-2"></i> Find Apartments
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @php
        $favoriteProperties = [
            ['lat' => 40.712776, 'lon' => -74.005974, 'name' => 'Property 1', 'address' => 'Address 1'],
            ['lat' => 34.052235, 'lon' => -118.243683, 'name' => 'Property 2', 'address' => 'Address 2'],
        ];
    @endphp
@endsection


@push('scripts')
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
    </script>
    <script type="text/javascript">
        const favoriteProperties = @json($mapdata);
        window.initMap = function() {
            var mapOptions = {
                zoom: 10,
                center: new google.maps.LatLng(favoriteProperties[0].latitude, favoriteProperties[0].longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            favoriteProperties.forEach(property => {
                const svgMarker = {
                    path: "M-1.547 12l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM0 0q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                    fillColor: "blue",
                    fillOpacity: 0.6,
                    strokeWeight: 0,
                    rotation: 0,
                    scale: 2,
                    anchor: new google.maps.Point(0, 20),
                };

                var position = new google.maps.LatLng(property.latitude, property.longitude);
                var marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: property.PropertyName,
                    animation: google.maps.Animation.DROP
                });

                const imageUrl = property.gallerytype && property.gallerytype.gallerydetail && property
                    .gallerytype.gallerydetail[0] ?
                    `https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_${property.Id}/Original/${property.gallerytype.gallerydetail[0].ImageName}` :
                    'https://via.placeholder.com/150';

                var infoWindow = new google.maps.InfoWindow({
                    content: `<div class="container">
                                 <div class="row">
                                    <div class="col-md-4">
                                        <img src="${imageUrl}" style="width:100%; height:auto;">
                                    </div>
                                    <div class="col-md-8">
                                        <h4>${property.PropertyName}</h4>   
                                        <p>${property.Address}</p>
                                        <span>${property.city.state.StateName}, ${property.city.CityName}</span>
                                    </div>
                                 </div>
                              </div>`
                });

                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            });
        }
    </script>
@endpush

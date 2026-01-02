@extends('admin/layouts/app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">View Profile of Brandon Hegland </h6>
            </div>

            <div class="row row-sm">
                <div class="col-lg-2">
                    <div class="manager-left mg-t-20 mg-sm-t-30">
                        <nav class="nav">
                            <a href="{{ route('admin-switch-map-view', ['id' => $userid]) }}" class="nav-link active">
                                <span>Switch To Map View</span>
                            </a>
                            <a href="{{ route('admin-map-search', ['id' => $userid]) }}" class="nav-link">
                                <span>Map Search</span>
                            </a>
                        </nav>

                    </div>
                </div>
                <div class="col-lg-9 offset-md-1">
                    <div class="card card-dash-chart-one mg-t-20 mg-sm-t-30">
                        <div class="row no-gutters">
                            <div class="col-lg-12">
                                <div class="right-panel">
                                    <div id="map-location" class="ht-250 ht-sm-350 ht-md-450 bg-gray-300"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
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

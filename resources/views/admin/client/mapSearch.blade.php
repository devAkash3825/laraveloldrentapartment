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
                        <a href="{{route('admin-switch-map-view',['id'=>$userid])}}" class="nav-link">
                            <span>Switch To Map View</span>
                        </a>
                        <a href="{{route('admin-map-search',['id'=>$userid])}}" class="nav-link active">
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
<script>
function initMap() {
    var marker;
    var map;
    var lat = "39.5486";
    var lon = "-104.874";
    var name = "One City Block";
    var myLatlng = new google.maps.LatLng(lat, lon);
    var marker = null;
    var geocoder = new google.maps.Geocoder();
    var myOptions = {
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var panoramaOptions;
    var map = new google.maps.Map(document.getElementById("map-location"), myOptions);
    var panorama;
    var address = "444 E. 19th Avenue";
    if (geocoder) {
        geocoder.geocode({
            address: address
        }, function(results, status) {
            var latlon;
            latlon = myLatlng
            map.setCenter(latlon);
            marker = new google.maps.Marker({
                map: map,
                title: name,
                position: latlon,
                animation: google.maps.Animation.DROP
            });
            var streetViewService = new google.maps.StreetViewService();
            streetViewService.getPanoramaByLocation(latlon, 50, function(data, status) {
                if (status == google.maps.StreetViewStatus.OK) {
                    panoramaOptions = {
                        position: data.location.latLng,
                        pov: {
                            heading: 34,
                            pitch: 10,
                            zoom: 1
                        }
                    };
                    panorama = new google.maps.StreetViewPanorama(document.getElementById(
                        "street_view1"), panoramaOptions);
                    map.setStreetView(panorama)
                } else {
                    google.maps.event.trigger(map, "resize");
                    document.getElementById("street_view1").innerHTML =
                        "<div class='google_map_back_street_view'><p>Street level photos are not available for this point.</p><p><b >Note:</b> Street views may be available in the area outside of the area shown on the map.</p></div>";
                }
            })
        })
    }
}
window.initMap = initMap;
</script>
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
</script>
@endsection
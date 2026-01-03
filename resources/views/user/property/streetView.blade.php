@extends('user/layout/app')

@section('content')
    <style>
        #streetviewfull {
            width: 100%;
            height: 450px;
            float: left;
        }
    </style>

    <div id="breadcrumb_part"
        style="background-image:url('https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails[0]['id'] }}/Original/{{ $propertyDetails[0]['listingImages']['ImageName'] }}')">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>{{ $propertyDetails[0]['propertyname'] }}</h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> listing details </li>
                            </ol>
                        </nav>
                    </div>
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
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Street View Container -->
                            <div id="streetviewfull"></div>
                        </div>
                        <div class="col-md-6 p-0">
                            <!-- Hidden Fields for Property Data -->
                            <input type="hidden" id="lat" value="{{ $propertyDetails[0]['lat'] }}">
                            <input type="hidden" id="long" value="{{ $propertyDetails[0]['lon'] }}">
                            <input type="hidden" id="fieldname" value="{{ $propertyDetails[0]['propertyname'] }}">
                            <input type="hidden" id="fieldaddress" value="{{ $propertyDetails[0]['address'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Maps Script -->
    <script type="text/javascript">
        function initMap() {
            // Retrieve latitude and longitude elements
            var latElement = document.getElementById('lat');
            var lonElement = document.getElementById('long');

            // Parse the latitude and longitude values
            var lat = parseFloat(latElement.value);
            var lon = parseFloat(lonElement.value);

            // Create a LatLng object for the coordinates
            var myLatlng = new google.maps.LatLng(lat, lon);
            var panoramaOptions;
            var streetViewService = new google.maps.StreetViewService();

            // Get Street View panorama by location
            streetViewService.getPanoramaByLocation(myLatlng, 50, function(data, status) {
                if (status === google.maps.StreetViewStatus.OK) {
                    // Set panorama options
                    panoramaOptions = {
                        position: data.location.latLng,
                        pov: {
                            heading: 0, // Default heading direction
                            pitch: 0,   // Default pitch level (flat)
                            zoom: 1     // Default zoom level
                        },
                        addressControl: false, // Disable address control if needed
                        linksControl: false,   // Disable navigation links
                        panControl: false,     // Disable pan control
                        enableCloseButton: false // Disable the close button
                    };

                    // Display panorama view on the page
                    new google.maps.StreetViewPanorama(document.getElementById("streetviewfull"), panoramaOptions);
                } else {
                    // Handle cases where Street View is not available
                    document.getElementById("streetviewfull").innerHTML =
                        "<div class='google_map_back_street_view'><p>Street level photos are not available for this point.</p><p><b>Note:</b> Street views may be available in the area outside of the area shown on the map.</p></div>";
                }
            });
        }

        // Initialize the map
        window.initMap = initMap;
    </script>

    <!-- Load the Google Maps JavaScript API -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.google_maps_api_key', env('GOOGLE_MAPS_API_KEY')) }}&callback=initMap" async defer></script>

@endsection

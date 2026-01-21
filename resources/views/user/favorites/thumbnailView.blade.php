@extends('user.layout.app')
@section('title', 'RentApartement | Thumbnail View')
@section('content')
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">My Favorites</h1>
                <p class="text-white opacity-75 lead mb-0">Browse through your saved property collections</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Thumbnail View</li>
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
                    <div class="row">

                            @if (count($data) > 0)
                                <div class="row">
                                    @foreach ($data as $row)
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 border-0 shadow-sm premium-property-card overflow-hidden">
                                                <div class="position-relative">
                                                    @php
                                                        $firstImage = count(@$row['image']) > 0 ? $row['image'][0]->ImageName : 'default.jpg';
                                                        $imageUrl = "https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_".$row['id']."/Original/".$firstImage;
                                                    @endphp
                                                    <img src="{{ $imageUrl }}" alt="{{ $row['propertyname'] }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                                    <div class="position-absolute top-0 end-0 p-3">
                                                        <span class="badge bg-primary-gradient px-3 py-2 rounded-pill shadow-sm">
                                                            ID: #{{ $row['id'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="card-body p-4 d-flex flex-column">
                                                    <div class="mb-3">
                                                        <h5 class="fw-bold mb-1 text-dark truncate-1">{{ $row['propertyname'] }}</h5>
                                                        <p class="text-muted small mb-0"><i class="fa-solid fa-location-dot me-1"></i> {{ $row['address'] }}, {{ $row['area'] }}</p>
                                                    </div>
                                                    
                                                    <div class="mb-4 flex-grow-1">
                                                        @php
                                                            $communityFeatures = $row['features'];
                                                            $featureIds = explode(',', $communityFeatures);
                                                            $features = App\Models\ApartmentFeature::whereIn('id', $featureIds)->take(3)->get();
                                                        @endphp
                                                        <div class="d-flex flex-wrap gap-2">
                                                            @foreach ($features as $feature)
                                                                <span class="badge bg-light text-dark fw-normal rounded-1 py-2 px-3 border small">
                                                                    <i class="fa-solid fa-check text-success me-1"></i> {{ $feature->PropertyFeatureType }}
                                                                </span>
                                                            @endforeach
                                                            @if(count($features) == 0)
                                                                <span class="text-muted small italic">Standard features apply</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="d-flex gap-2 mt-auto pt-3 border-top">
                                                        <a href="{{ route('property-display', ['id' => $row['id']]) }}" class="btn btn-primary flex-fill premium-btn-sm">
                                                            <i class="fa-solid fa-eye me-1"></i> View
                                                        </a>
                                                        <button class="btn btn-outline-danger flex-fill btn-remove-fav premium-btn-sm-outline" data-id="{{ $row['id'] }}">
                                                            <i class="fa-solid fa-trash-can me-1"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm p-5 text-center">
                                        <div class="mb-4">
                                            <i class="fa-solid fa-heart-circle-xmark fa-4x text-light" style="opacity: 0.5;"></i>
                                        </div>
                                        <h4 class="fw-bold mb-2">Your collection is empty</h4>
                                        <p class="text-muted mb-4 lead">You haven't saved any apartments to your favorites yet.</p>
                                        <div>
                                            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                                                <i class="fa-solid fa-magnifying-glass me-2"></i> Browse Properties
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="col-md-6 p-0">
                                <input type="hidden" id="lat" value="{{ @$data[0]['lat'] }}">
                                <input type="hidden" id="lon" value="{{ @$data[0]['lon'] }}">
                                <input type="hidden" id="fieldname" value="{{ @$data[0]['propertyname'] }}">
                                <input type="hidden" id="fieldaddress" value="{{ @$data[0]['address'] }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> View On Map  </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="streetviewfull" style="width:100%;height:400px;float:left;"></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.btn-remove-fav').on('click', function() {
                var id = $(this).data('id');
                var $card = $(this).closest('.col-md-6');

                Swal.fire({
                    title: 'Remove Favorite?',
                    text: "This property will be removed from your collection.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('add-to-favorite') }}",
                            method: "POST",
                            data: { propertyId: id },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Removed!', response.message, 'success');
                                    $card.fadeOut(500, function() {
                                        $(this).remove();
                                        if ($('.premium-property-card').length === 0) {
                                            location.reload();
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });

        function initMap() {
            var latElement = document.getElementById('lat');
            var lonElement = document.getElementById('lon');
            if (!latElement || !lonElement || !latElement.value) return;

            var lat = parseFloat(latElement.value);
            var lon = parseFloat(lonElement.value);
            var myLatlng = new google.maps.LatLng(lat, lon);
            
            var streetViewService = new google.maps.StreetViewService();
            streetViewService.getPanoramaByLocation(myLatlng, 50, function(data, status) {
                if (status == google.maps.StreetViewStatus.OK) {
                    new google.maps.StreetViewPanorama(document.getElementById("streetviewfull"), {
                        position: data.location.latLng,
                        pov: { heading: 34, pitch: 10, zoom: 1 }
                    });
                } else {
                    document.getElementById("streetviewfull").innerHTML =
                        "<div class='google_map_back_street_view text-center p-5'><p class='text-muted'>Street level photos are not available for this location.</p></div>";
                }
            });
        }
    </script>
    <style>
        .premium-property-card {
            transition: all 0.3s ease;
            background: #fff;
        }
        .premium-property-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
        .truncate-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .premium-btn-sm {
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: 4px;
        }
        .premium-btn-sm-outline {
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: 4px;
        }
    </style>
@endpush

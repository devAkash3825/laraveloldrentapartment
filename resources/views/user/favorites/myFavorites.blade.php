@extends('user/layout/app')
@section('content')
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="title-single-box">
                    <h1 class="title-single">Favorite Property List </h1>
                    <span class="color-text-a">List View</span>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}" class="text-white">Home</a>
                        </li>
                        <li class="breadcrumb-item active text-secondary font-weight-bold" aria-current="page">
                            My Favorites List
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section id="specials" class="specials section" data-aos="fade-up">

    <!-- Section Title -->
    <div class="container">

        <div class="row">
            <div class="col-lg-3">
                <ul class="nav nav-tabs flex-column">
                    <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="tab" href="#specials-tab-1">List View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#specials-tab-2">Thumbnail View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#specials-tab-3">Map View</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9 mt-4 mt-lg-0">
                <div class="tab-content">

                    <div class="tab-pane active show" id="specials-tab-1">
                        <div class="row">
                            <div class="col-lg-12 details order-2 order-lg-1">
                                <table id="mytable" class="table align-middle mb-0 bg-white table-hover p-4">
                                    <thead class="bg-light">
                                        <tr class="header-row border">
                                            <th style="align-content:center;"></th>
                                            <th style="align-content:center;">Property Name</th>
                                            <th style="align-content:center;">Renter Notes </th>
                                            <th style="align-content:center;">Quotes</th>
                                            <th style="align-content:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($favpropertyInfos as $row)
                                        <tr>
                                            <td>
                                                <input type="checkbox">
                                            </td>
                                            <td>
                                                {{$row->PropertyName}}
                                            </td>
                                            <td class="p-3">
                                                <button class="btn btn-sm"
                                                    style="background:var(--btn-color1) !important; margin: 5px 5px 5px 0;border-radius: 0;color:#ffff;">Add
                                                    Notes</button>
                                                <button class="btn btn-sm"
                                                    style="background:var(--btn-color2) !important; margin: 5px 5px 5px 0;border-radius: 0;color:#ffff;">View
                                                    Notes</button>
                                            </td>
                                            <td>
                                                <span class="badge pill d-inline"
                                                    style="cursor:pointer; background-color:#94c045;color: #ffff;">Request
                                                    Quote</span>
                                            </td>
                                            <td>
                                                <button style="background-color:#4caa86;" class="btn text-white btn-sm">
                                                    <span><i class="fa-solid fa-map"></i></span>
                                                </button>
                                                <a href="{{route('property-display',['id'=>$row->Id])}}"
                                                    style="background-color:#398e91;" class="btn text-white btn-sm">
                                                    <span><i class="fa-solid fa-eye"></i></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="specials-tab-2">
                        <div class="container">
                            <div class="row">
                                @foreach ($favpropertyInfos as $row)
                                <div class="col-md-12">
                                    <div class="card sample-Pcard mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-5" style="align-content:center;">
                                                    @foreach($row->imageDetails as $image)
                                                    <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $row->Id }}/Original/{{ $image->ImageName }}"
                                                        alt="Property Image" class="img-fluid">
                                                    @endforeach
                                                </div>
                                                <div
                                                    class="col-md-7 sample-card-margin-lt20 d-flex flex-column justify-content-between">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span
                                                                class="card-headline-text">{{$row->PropertyName}}</span><br>
                                                            <span class="card-caption">Prathik Developers,
                                                                Bengaluru</span>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-light btn-sm" aria-label="More">
                                                                <i class="fa-sharp fa-solid fa-heart"
                                                                    style="color:red;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row sample-padding-t10">
                                                        <div class="col-md-6">
                                                            <span class="pcard-title-txt">Address</span><br>
                                                            <span class="pcard-title-caption">{{$row->Address}}</span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span class="pcard-title-txt">Area</span><br>
                                                            <span class="pcard-title-caption">{{$row->Area}}</span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span class="pcard-title-txt">Managed By</span><br>
                                                            <span class="pcard-title-caption">{{$row->Company}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row sample-padding-t10">
                                                        <div class="col-md-12">
                                                            <span class="pcard-title-txt">Property Features</span><br>
                                                            <div class="row">
                                                                <span class="col-md-4 pcard-title-caption">Washer Dryer
                                                                    Hookup</span>
                                                                <span class="col-md-4 pcard-title-caption">Washer Dryer
                                                                    In Unit</span>
                                                                <span class="col-md-4 pcard-title-caption">Washer Dryer-
                                                                    Rental Avavilable</span>
                                                            </div>

                                                        </div>
                                                    </div>




                                                    <div class="d-flex">
                                                        <a href="{{route('property-display',['id'=>$row->Id])}}"
                                                            class="btn sample-green-fab-btn quick-btn flex-fill">More
                                                            Details</a>
                                                        <a href="{{route('property-display',['id'=>$row->Id])}}"
                                                            class="btn sample-grn-fab-btn explore-btn flex-fill">View On
                                                            Map</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="specials-tab-3">
                        <div class="row">
                            <div class="col-lg-12 details order-2 order-lg-1">
                                <section class="contact">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="contact-map box">
                                                    <div id="map" class="contact-map">
                                                        <iframe
                                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.1422937950147!2d-73.98731968482413!3d40.75889497932681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25855c6480299%3A0x55194ec5a1ae072e!2sTimes+Square!5e0!3m2!1ses-419!2sve!4v1510329142834"
                                                            width="100%" height="450" frameborder="0" style="border:0"
                                                            allowfullscreen></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection


                    
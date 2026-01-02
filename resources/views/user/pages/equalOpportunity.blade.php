@extends('user.layout.app')
@section('content')
@section('title', 'RentApartement | Equal Housing ')
<div id="breadcrumb_part" style="background-image:url('images/breadcroumb_bg.jpg')">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4> Equal Housing </h4>
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Equal Housing </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container my-5">
    <div class="row">
        <div class="col-md-12 pt-3">
            @foreach($terms as $term)
            <div class="mt-3">
                <h3 class="px-2 py-1 text-left" style="color: #fff;font-size: 1.4rem; background-color:#243642;">
                    {{ $term->title }}
                </h3>
            </div>
            <div class="p-3">
                <p class="text-secondary mt-2" style="line-height:2;"> {!! @$term->description !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
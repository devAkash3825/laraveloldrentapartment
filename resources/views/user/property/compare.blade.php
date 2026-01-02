@extends('user/layout/app')
@section('content')
<div id="breadcrumb_part" style="background-image:url('images/breadcroumb_bg.jpg')">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4>About Us</h4>
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

<div>
    
</div>
@endsection
@extends('user/layout/app')
@section('content')
@section('title', 'RentApartment | Manager Terms')

<div id="breadcrumb_part" style="background-image:url('{{ asset('user_asset/images/breadcrumb_bg.jpg') }}'); background-size: cover; background-position: center;">
    <div class="bread_overlay" style="background: rgba(0,0,0,0.6);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white py-5">
                    <h2 class="font-weight-bold mb-3">Manager Terms</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center bg-transparent p-0 m-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Manager Terms</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            @if(isset($terms) && count($terms) > 0)
                @foreach($terms as $term)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="mr-3" style="width: 4px; height: 24px; background-color: var(--primary-color);"></div>
                                <h4 class="mb-0 font-weight-bold" style="color: #2c3e50;">{{ $term->title }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-muted" style="line-height: 1.8; font-size: 1rem;">
                                {!! $term->description !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="bi bi-file-text text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-3 text-muted">No terms and conditions found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

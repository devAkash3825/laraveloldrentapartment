@extends('user/layout/app')
@section('content')
@section('title', 'RentApartement | Privacy Promise ')
<div class="header-premium-gradient mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Privacy Promise</h1>
                <p class="text-white opacity-75 lead mb-0">Our commitment to your data privacy</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Privacy Promise</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


<div class="container my-5">
    <div class="row">
        <div class="col-md-12 pt-3">
            @foreach($data as $term)
            <div class="mt-3">
                <h3 class="px-3 py-2 text-left rounded-3" style="color: #fff; font-size: 1.3rem; background: var(--colorPrimary);">
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
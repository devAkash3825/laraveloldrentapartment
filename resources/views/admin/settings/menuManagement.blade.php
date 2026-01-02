@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle"> Menu Management </h6>
            </div>
            <div class="section-wrapper">
                {!! Menu::render() !!}
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    {!! Menu::scripts() !!}
@endpush


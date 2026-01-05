<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'RentApartments Admin')</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Custom Styles -->
<link rel="stylesheet" href="{{asset('admin_asset/css/login.css')}}">

<style>
    /* Auth page enhancements */
    .alert {
        border-radius: 8px;
        font-size: 14px;
        padding: 12px 16px;
        margin-bottom: 20px;
    }
    
    .submit-btn {
        position: relative;
    }
    
    .submit-btn .btn-loader {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #dc3545;
        margin-top: 4px;
    }
    
    .input.is-invalid {
        border-color: #dc3545 !important;
    }
</style>
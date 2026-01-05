    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', 'Renter Apartment Admin Section') </title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon/favicon.ico">
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('admin_asset/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_asset/css/bootstrap-iconpicker.min.css') }}">
    
    <!-- Admin Panel CSS -->
    <link rel="stylesheet" href="{{ asset('admin_asset/css/adminpanel.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/css/datatables.css') }}">
    
    <!-- Common Admin CSS -->
    <link rel="stylesheet" href="{{ asset('common/css/admin-common.css') }}">

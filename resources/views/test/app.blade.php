<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Just for test File </title>
    <link rel="stylesheet" href="{{ asset('user_asset/vendor/bootstrap5/bootstrapupdated5.min.css')}} ">
</head>
<body>
    <h1> Testing File </h1>
    {{-- @vite(['resources/js/app.js']) --}}
    <script src="{{ asset('user_asset/vendor/jquery/jquery3.min.js') }}"></script>
    <script src="{{ asset('user_asset/vendor/jquery/jquery-migrate.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script type="module" src="http://127.0.0.1:5173/resources/js/app.js"></script> --}}

    
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Echo) {
                console.log('Echo instance is available');
                Echo.channel('admin-notification')
                    .listen('NotificationEvent', (e) => {
                        alert('Notification received!');
                        console.log(e);
                    });
            } else {
                console.error('Echo is not initialized');
            }
        });
    </script> --}}
    
    {{-- @vite(['resources/js/app.js']) --}}
    
</body>
</html>
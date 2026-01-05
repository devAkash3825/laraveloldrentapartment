<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{asset('admin_asset/vendor/popper.js/js/popper.js')}}"></script>
<script src="{{asset('admin_asset/vendor/jquery.cookie/js/jquery.cookie.js')}}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('admin_asset/js/slim.js')}}"></script>

<script>
    // Toastr configuration for auth pages
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "4000"
        };
    }
</script>

<script src="{{ asset('user_asset/vendor/jquery/jquery3.min.js') }}"></script>
<script src="{{ asset('user_asset/vendor/jquery/jquery-migrate.min.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('user_asset/vendor/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('user_asset/vendor/wow/wow.min.js') }}"></script>
<script src="{{ asset('user_asset/vendor/jquery.countup.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
<script src="{{ asset('user_asset/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="{{ asset('user_asset/js/frontendjs.js') }}"></script>
<script src="{{ asset('ajax/user/userAjax.js') }}"></script>
<script src="{{ asset('js/city-state-handler.js') }}"></script>
<script src="{{ asset('common/js/validation.js') }}"></script>

<script>
    function togglePasswordVisibility(id, event) {
        if (event) event.preventDefault();
        const input = document.getElementById(id);
        const btn = event ? event.currentTarget : window.event.srcElement;
        const icon = btn.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Global Toastr Configuration for "Awesome" Look
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>


<script>
    @if($errors->any())
        $(document).ready(function() {
            window.ValidationHandler.showErrors($('form'), @json($errors->toArray()));
        });
    @endif
</script>

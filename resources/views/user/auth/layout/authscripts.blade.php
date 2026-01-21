<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="{{ asset('user_asset/vendor/bootstrap5/bootstrap5.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Global toastr options
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
    };
</script>
<script>
    function togglePasswordVisibility(id, event) {
        if (event) event.preventDefault();
        const input = document.getElementById(id);
        const btn = event ? event.currentTarget : window.event.srcElement;
        const icon = btn ? btn.querySelector('i') : null;
        
        if (input && icon) {
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
    }
</script>
<script src="{{ asset('js/city-state-handler.js') }}"></script>


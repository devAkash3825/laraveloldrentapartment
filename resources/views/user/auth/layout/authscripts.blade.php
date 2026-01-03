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
    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const btn = event.currentTarget;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>


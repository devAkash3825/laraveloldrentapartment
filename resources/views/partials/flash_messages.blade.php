<script>
    @if(session('success'))
        toastr.success("<i class='fa-solid fa-circle-check me-2'></i> {{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("<i class='fa-solid fa-circle-exclamation me-2'></i> {{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("<i class='fa-solid fa-triangle-exclamation me-2'></i> {{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("<i class='fa-solid fa-circle-info me-2'></i> {{ session('info') }}");
    @endif

    @if($errors->any())
        $(document).ready(function() {
            if(window.ValidationHandler) {
                window.ValidationHandler.showErrors($('form'), @json($errors->toArray()));
            } else {
                 console.warn('ValidationHandler not found');
            }
        });
    @endif
</script>

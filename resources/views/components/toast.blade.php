<div class="toast-container fixed top-4 right-4 z-50 flex flex-col gap-3"></div>

@push('styles')
{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    .toast {
        background: #fff;
        padding: 14px 16px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 280px;
        max-width: 380px;
        animation: slideIn 0.4s ease forwards;
        position: relative;
        overflow: hidden;
    }

    .toast .icon {
        font-size: 22px;
        margin-right: 10px;
    }

    .toast .message {
        flex-grow: 1;
    }

    .toast .message .title {
        font-weight: 600;
        margin-bottom: 2px;
        text-transform: capitalize;
    }

    .toast .close {
        cursor: pointer;
        font-size: 18px;
        margin-left: 10px;
    }

    .toast .progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        animation: progress 5s linear forwards;
    }

    @keyframes slideIn {
        from {
            transform: translateX(120%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(120%);
            opacity: 0;
        }
    }

    @keyframes progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    /* Colors */
    .toast.success {
        border-left: 5px solid #22c55e;
    }

    .toast.success .icon,
    .toast.success .progress {
        color: #22c55e;
        background: #22c55e;
    }

    .toast.error {
        border-left: 5px solid #ef4444;
    }

    .toast.error .icon,
    .toast.error .progress {
        color: #ef4444;
        background: #ef4444;
    }

    .toast.warning {
        border-left: 5px solid #f59e0b;
    }

    .toast.warning .icon,
    .toast.warning .progress {
        color: #f59e0b;
        background: #f59e0b;
    }

    .toast.info {
        border-left: 5px solid #3b82f6;
    }

    .toast.info .icon,
    .toast.info .progress {
        color: #3b82f6;
        background: #3b82f6;
    }
</style>
@endpush

@push('adminscripts')
<script>
    const toastTimeout = 5000;

    function showToast(message, type = "success") {
        const container = document.querySelector(".toast-container");
        const toast = document.createElement("div");
        toast.classList.add("toast", type);

        toast.innerHTML = `
            <i class="icon ${getIcon(type)}"></i>
            <div class="message">
                <div class="title">${capitalize(type)}</div>
                <div>${message}</div>
            </div>
            <span class="close">&times;</span>
            <div class="progress"></div>
        `;

        container.appendChild(toast);

        const removeToast = () => {
            toast.style.animation = "slideOut 0.4s ease forwards";
            setTimeout(() => toast.remove(), 400);
        };

        // Auto remove
        setTimeout(removeToast, toastTimeout);

        // Close button
        toast.querySelector(".close").addEventListener("click", removeToast);
    }

    function getIcon(type) {
        switch (type) {
            case "success":
                return "bi bi-check-circle-fill";
            case "error":
                return "bi bi-x-circle-fill";
            case "warning":
                return "bi bi-exclamation-triangle-fill";
            case "info":
                return "bi bi-info-circle-fill";
            default:
                return "bi bi-bell-fill";
        }
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Trigger Laravel flash message automatically
    @if(session('toast'))
    showToast("{{ session('toast.message') }}", "{{ session('toast.type') }}");
    @endif
</script>
@endpush
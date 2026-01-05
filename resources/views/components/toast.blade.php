{{-- Bootstrap 5 Toast Container --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
</div>

@push('styles')
<style>
    /* Bootstrap 5 Style Toast */
    .toast-container .toast {
        min-width: 320px;
        max-width: 420px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        opacity: 0;
        transform: translateX(100%);
        animation: toastSlideIn 0.4s ease forwards;
    }

    .toast-container .toast.hiding {
        animation: toastSlideOut 0.3s ease forwards;
    }

    .toast-container .toast .toast-header {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toast-container .toast .toast-header .toast-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .toast-container .toast .toast-header strong {
        flex: 1;
        font-weight: 600;
        font-size: 14px;
    }

    .toast-container .toast .toast-header .btn-close {
        font-size: 10px;
        opacity: 0.5;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
    }

    .toast-container .toast .toast-header .btn-close:hover {
        opacity: 1;
    }

    .toast-container .toast .toast-body {
        padding: 12px 16px;
        font-size: 13px;
        color: #333;
    }

    .toast-container .toast .toast-progress {
        height: 3px;
        width: 100%;
        background: rgba(0,0,0,0.1);
    }

    .toast-container .toast .toast-progress-bar {
        height: 100%;
        animation: progressShrink 5s linear forwards;
    }

    /* Toast Types */
    .toast-container .toast.toast-success .toast-icon {
        background: #d1fae5;
        color: #059669;
    }
    .toast-container .toast.toast-success .toast-progress-bar {
        background: #10b981;
    }

    .toast-container .toast.toast-error .toast-icon {
        background: #fee2e2;
        color: #dc2626;
    }
    .toast-container .toast.toast-error .toast-progress-bar {
        background: #ef4444;
    }

    .toast-container .toast.toast-warning .toast-icon {
        background: #fef3c7;
        color: #d97706;
    }
    .toast-container .toast.toast-warning .toast-progress-bar {
        background: #f59e0b;
    }

    .toast-container .toast.toast-info .toast-icon {
        background: #dbeafe;
        color: #2563eb;
    }
    .toast-container .toast.toast-info .toast-progress-bar {
        background: #3b82f6;
    }

    @keyframes toastSlideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes toastSlideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    @keyframes progressShrink {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>
@endpush

@push('adminscripts')
<script>
    /**
     * Bootstrap 5 Style Toast Notification System
     */
    window.AdminToast = window.AdminToast || {};
    
    const TOAST_DURATION = 5000;
    
    const TOAST_ICONS = {
        success: '<i class="fa-solid fa-check"></i>',
        error: '<i class="fa-solid fa-xmark"></i>',
        warning: '<i class="fa-solid fa-exclamation"></i>',
        info: '<i class="fa-solid fa-info"></i>'
    };

    const TOAST_TITLES = {
        success: 'Success',
        error: 'Error',
        warning: 'Warning',
        info: 'Information'
    };

    function showToast(message, type = 'success') {
        const container = document.querySelector('.toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
            <div class="toast-header">
                <span class="toast-icon">${TOAST_ICONS[type] || TOAST_ICONS.info}</span>
                <strong>${TOAST_TITLES[type] || 'Notification'}</strong>
                <button type="button" class="btn-close" aria-label="Close">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="toast-body">${message}</div>
            <div class="toast-progress">
                <div class="toast-progress-bar"></div>
            </div>
        `;

        container.appendChild(toast);

        const removeToast = () => {
            toast.classList.add('hiding');
            setTimeout(() => toast.remove(), 300);
        };

        // Close button
        toast.querySelector('.btn-close').addEventListener('click', removeToast);

        // Auto remove after duration
        setTimeout(removeToast, TOAST_DURATION);
    }

    // Expose globally
    window.showToast = showToast;
    
    // Override AdminToast for consistency
    window.AdminToast.success = (msg) => showToast(msg, 'success');
    window.AdminToast.error = (msg) => showToast(msg, 'error');
    window.AdminToast.warning = (msg) => showToast(msg, 'warning');
    window.AdminToast.info = (msg) => showToast(msg, 'info');

    // Handle Laravel session flash messages on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif
        
        @if(session('error'))
            showToast(@json(session('error')), 'error');
        @endif
        
        @if(session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif
        
        @if(session('message') || session('info'))
            showToast(@json(session('message') ?? session('info')), 'info');
        @endif

        @if(session('status'))
            showToast(@json(session('status')), 'info');
        @endif

        // Handle validation errors
        @if($errors->any())
            showToast(@json($errors->first()), 'error');
        @endif
    });
</script>
@endpush
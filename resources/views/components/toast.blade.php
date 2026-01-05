@push('toast_html')
<div class="minimal-toast-container position-fixed bottom-0 end-0 mt-4 me-4" style="z-index: 99999;">
</div>
@endpush

@push('style')
<style>
    :root {
        --m-toast-success: #059669;
        --m-toast-error: #dc2626;
        --m-toast-warning: #d97706;
        --m-toast-info: #2563eb;
        --m-toast-bg: #ffffff;
        --m-toast-border: #e5e7eb;
        --m-toast-text: #1f2937;
        --m-toast-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .minimal-toast-container {
        pointer-events: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-width: 380px;
        width: 100%;
    }

    .m-toast {
        pointer-events: auto;
        background: var(--m-toast-bg);
        border: 1px solid var(--m-toast-border);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        box-shadow: var(--m-toast-shadow);
        margin-bottom: 0;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform: translateX(100px);
        opacity: 0;
        position: relative;
        overflow: hidden;
    }

    .m-toast::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: currentColor;
        opacity: 0.15;
    }

    .m-toast.show {
        transform: translateX(0);
        opacity: 1;
    }

    .m-toast.hide {
        transform: translateX(100px);
        opacity: 0;
    }

    .m-toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
        color: #fff;
        margin-top: -2px;
    }

    .m-toast-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .m-toast-message {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        font-size: 14px;
        font-weight: 500;
        color: var(--m-toast-text);
        line-height: 1.4;
        white-space: normal;
        word-break: break-word;
    }

    .m-toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: currentColor;
        opacity: 0.3;
        width: 100%;
        transform-origin: left;
        transform: scaleX(1);
        transition: transform 4s linear;
    }

    .m-toast.hide .m-toast-progress {
        transform: scaleX(0);
        transition: transform 0.6s linear;
    }

    .m-toast-close {
        background: transparent;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 6px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
        margin-top: -8px;
        margin-right: -8px;
        width: 32px;
        height: 32px;
    }

    .m-toast-close:hover {
        background: #f3f4f6;
        color: #374151;
    }

    /* Toast types */
    .m-toast-success { color: var(--m-toast-success); }
    .m-toast-error { color: var(--m-toast-error); }
    .m-toast-warning { color: var(--m-toast-warning); }
    .m-toast-info { color: var(--m-toast-info); }

    .m-toast-success .m-toast-icon { 
        background: var(--m-toast-success); 
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }
    
    .m-toast-error .m-toast-icon { 
        background: var(--m-toast-error); 
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    }
    
    .m-toast-warning .m-toast-icon { 
        background: var(--m-toast-warning); 
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
    }
    
    .m-toast-info .m-toast-icon { 
        background: var(--m-toast-info); 
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    /* Responsive */
    @media (max-width: 640px) {
        .minimal-toast-container {
            max-width: calc(100vw - 32px);
            margin: 0 16px;
            left: 0;
            right: 0;
            top: 0;
            end: initial;
        }
        
        .m-toast {
            max-width: 100%;
        }
    }
</style>
@endpush

@push('adminscripts')
<script>
    (function() {
        const ICONS = {
            success: '<i class="fa-solid fa-check"></i>',
            error: '<i class="fa-solid fa-xmark"></i>',
            warning: '<i class="fa-solid fa-triangle-exclamation"></i>',
            info: '<i class="fa-solid fa-circle-info"></i>'
        };

        function showToast(message, type = 'success') {
            const container = document.querySelector('.minimal-toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `m-toast m-toast-${type}`;
            
            toast.innerHTML = `
                <div class="m-toast-icon">${ICONS[type] || ICONS.success}</div>
                <div class="m-toast-content">
                    <div class="m-toast-message">${message}</div>
                </div>
                <button class="m-toast-close" aria-label="Close toast">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="m-toast-progress"></div>
            `;

            // Add to top of container (newest first)
            container.insertBefore(toast, container.firstChild);
            
            // Forced reflow to trigger animation
            toast.offsetHeight;
            
            // Show toast
            setTimeout(() => toast.classList.add('show'), 10);
            
            // Start progress bar animation
            setTimeout(() => {
                const progress = toast.querySelector('.m-toast-progress');
                if (progress) {
                    progress.style.transform = 'scaleX(0)';
                    progress.style.transition = 'transform 10s linear';
                }
            }, 50);

            const removeToast = () => {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 500);
            };

            // Close button
            toast.querySelector('.m-toast-close').addEventListener('click', removeToast);
            
            // Auto dismiss after 5 seconds
            const dismissTimeout = setTimeout(removeToast, 5000);
            
            // Pause dismissal on hover
            toast.addEventListener('mouseenter', () => {
                clearTimeout(dismissTimeout);
                const progress = toast.querySelector('.m-toast-progress');
                if (progress) {
                    progress.style.transition = 'none';
                }
            });
            
            toast.addEventListener('mouseleave', () => {
                const progress = toast.querySelector('.m-toast-progress');
                if (progress) {
                    const remainingWidth = progress.getBoundingClientRect().width / toast.getBoundingClientRect().width;
                    const remainingTime = remainingWidth * 5000;
                    
                    progress.style.transition = `transform ${remainingTime}ms linear`;
                    progress.style.transform = 'scaleX(0)';
                    
                    setTimeout(removeToast, remainingTime);
                } else {
                    setTimeout(removeToast, 5000);
                }
            });
        }

        // Global toast functions
        window.AdminToast = {
            success: (msg) => showToast(msg, 'success'),
            error: (msg) => showToast(msg, 'error'),
            warning: (msg) => showToast(msg, 'warning'),
            info: (msg) => showToast(msg, 'info')
        };
        
        window.showToast = showToast;
        window.toastr = window.AdminToast;

        // Show session toasts
        document.addEventListener('DOMContentLoaded', () => {
            const shownMessages = new Set();
            
            const triggerToast = (message, type) => {
                const key = `${type}:${message}`;
                if (shownMessages.has(key)) return;
                showToast(message, type);
                shownMessages.add(key);
            };

            // Toast from session
            @if(session('toast'))
                @php $toast = session('toast'); @endphp
                triggerToast(@json($toast['message']), @json($toast['type'] ?? 'success'));
            @endif

            // Legacy session messages
            @if(session('success')) triggerToast(@json(session('success')), 'success'); @endif
            @if(session('error')) triggerToast(@json(session('error')), 'error'); @endif
            @if(session('warning')) triggerToast(@json(session('warning')), 'warning'); @endif
            @if(session('info')) triggerToast(@json(session('info')), 'info'); @endif
            @if(session('message')) triggerToast(@json(session('message')), 'info'); @endif
            @if(session('status')) triggerToast(@json(session('status')), 'info'); @endif
            
            @if($errors->any()) 
                @foreach($errors->all() as $error)
                    triggerToast(@json($error), 'error');
                @endforeach
            @endif
        });
    })();
</script>
@endpush
/**
 * Admin Common JavaScript - Rent Apartments
 * This file contains common JavaScript functions used across all admin pages
 * DO NOT add page-specific logic here
 */

(function ($) {
    'use strict';

    /**
     * ============================================
     * CSRF TOKEN SETUP
     * ============================================
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * ============================================
     * TOAST NOTIFICATIONS
     * ============================================
     */
    window.AdminToast = {
        success: function (msg) {
            if (window.showToast) window.showToast(msg, 'success');
            else if (window.toastr) toastr.success(msg);
            else alert(msg);
        },
        error: function (msg) {
            if (window.showToast) window.showToast(msg, 'error');
            else if (window.toastr) toastr.error(msg);
            else alert('Error: ' + msg);
        },
        info: function (msg) {
            if (window.showToast) window.showToast(msg, 'info');
            else if (window.toastr) toastr.info(msg);
            else console.info(msg);
        },
        warning: function (msg) {
            if (window.showToast) window.showToast(msg, 'warning');
            else if (window.toastr) toastr.warning(msg);
            else console.warn(msg);
        }
    };

    /**
     * ============================================
     * COMMON AJAX HANDLER
     * ============================================
     */
    window.AdminAjax = {
        /**
         * Generic AJAX request handler
         * @param {string} url - The URL to send the request to
         * @param {string} method - HTTP method (GET, POST, PUT, DELETE)
         * @param {object} data - Data to send with the request
         * @param {object} options - Additional options (beforeSend, success, error)
         */
        request: function (url, method, data, options) {
            options = options || {};

            const ajaxConfig = $.extend({}, options, {
                url: url,
                method: method || 'POST',
                data: data || {},
                beforeSend: function () {
                    if (typeof options.beforeSend === 'function') {
                        options.beforeSend();
                    }
                },
                success: function (response) {
                    if (response.success || response.message) {
                        AdminToast.success(response.message || 'Action completed successfully');
                    }
                    if (typeof options.success === 'function') {
                        options.success(response);
                    }
                },
                error: function (xhr, status, error) {
                    // Only show error toast if it's not a validation error (handled by FormHelpers)
                    if (xhr.status !== 422) {
                        let errorMsg = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        AdminToast.error(errorMsg);
                    }

                    if (typeof options.error === 'function') {
                        options.error(xhr, status, error);
                    }
                },
                complete: function () {
                    if (typeof options.complete === 'function') {
                        options.complete();
                    }
                }
            });

            $.ajax(ajaxConfig);
        },

        /**
         * Default error handler
         */
        handleError: function (xhr, status, error) {
            let errorMessage = 'An error occurred. Please try again.';

            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Resource not found.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please contact support.';
            } else if (xhr.status === 403) {
                errorMessage = 'You do not have permission to perform this action.';
            } else if (xhr.status === 401) {
                errorMessage = 'Your session has expired. Please login again.';
                setTimeout(function () {
                    window.location.href = '/admin/login';
                }, 2000);
            }

            toastr.error(errorMessage);
            console.error('AJAX Error:', error);
        }
    };

    /**
     * ============================================
     * LOADING STATE HANDLERS
     * ============================================
     */
    window.LoadingState = {
        /**
         * Show loading state on button
         * @param {jQuery} $button - The button element
         * @param {string} text - Loading text (default: 'Loading...')
         */
        showButton: function ($button, text) {
            text = text || 'Processing...';
            $button.data('original-text', $button.html());
            $button.prop('disabled', true);
            $button.addClass('btn-loading');
            $button.html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + text);
        },

        /**
         * Hide loading state on button
         * @param {jQuery} $button - The button element
         */
        hideButton: function ($button) {
            $button.prop('disabled', false);
            $button.removeClass('btn-loading');
            $button.html($button.data('original-text'));
        },

        /**
         * Show loading overlay
         * @param {jQuery} $element - The element to show loading on
         */
        show: function ($element) {
            if (!$element.find('.loading-overlay').length) {
                $element.css('position', 'relative');
                $element.append(
                    '<div class="loading-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; z-index: 9999;">' +
                    '<div class="spinner-border text-primary" role="status">' +
                    '<span class="sr-only">Loading...</span>' +
                    '</div>' +
                    '</div>'
                );
            }
        },

        /**
         * Hide loading overlay
         * @param {jQuery} $element - The element to hide loading from
         */
        hide: function ($element) {
            $element.find('.loading-overlay').remove();
        }
    };

    /**
     * ============================================
     * CONFIRMATION DIALOGS
     * ============================================
     */
    window.ConfirmDialog = {
        /**
         * Show confirmation dialog
         * @param {object} options - Dialog options
         */
        show: function (options) {
            options = $.extend({
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel'
            }, options);

            if (typeof Swal !== 'undefined') {
                Swal.fire(options).then((result) => {
                    if (result.isConfirmed && typeof options.onConfirm === 'function') {
                        options.onConfirm();
                    }
                });
            } else {
                if (confirm(options.text)) {
                    if (typeof options.onConfirm === 'function') {
                        options.onConfirm();
                    }
                }
            }
        },

        /**
         * Show delete confirmation
         * @param {function} callback - Function to call on confirm
         */
        delete: function (callback) {
            this.show({
                title: 'Delete Confirmation',
                text: 'Are you sure you want to delete this item? This cannot be undone.',
                icon: 'warning',
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: '#d33',
                onConfirm: callback
            });
        }
    };

    /**
     * ============================================
     * DATATABLES HELPERS
     * ============================================
     */
    window.DataTableHelpers = {
        /**
         * Default DataTable configuration
         */
        defaultConfig: {
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                lengthMenu: "Show _MENU_ entries",
                emptyTable: "No data available",
                zeroRecords: "No matching records found"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            order: [],
            drawCallback: function () {
                // Re-initialize tooltips after table redraw
                $('[data-toggle="tooltip"]').tooltip();
            }
        },

        /**
         * Get configuration with ajax URL
         * @param {string} ajaxUrl - The URL to fetch data from
         * @param {array} columns - Column definitions
         * @param {object} additionalConfig - Additional configuration
         */
        getConfig: function (ajaxUrl, columns, additionalConfig) {
            return $.extend({}, this.defaultConfig, {
                ajax: ajaxUrl,
                columns: columns
            }, additionalConfig || {});
        }
    };

    /**
     * ============================================
     * COMMON EVENT HANDLERS
     * ============================================
     */

    // Delete handler with confirmation
    $(document).on('click', '.deleteRenter, .delete-btn, .propertyDlt, .deleterecords', function (e) {
        const $this = $(this);

        // Skip if this button is marked for traditional form submission (non-AJAX)
        if ($this.data('traditional') === true || $this.attr('data-traditional') === 'true') {
            return;
        }

        e.preventDefault();
        const url = $this.data('url');
        const id = $this.data('id');

        ConfirmDialog.delete(function () {
            AdminAjax.request(url, 'POST', { id: id, _method: 'DELETE' }, {
                beforeSend: function () {
                    LoadingState.showButton($this, '...');
                },
                success: function (response) {
                    // Success toast is handled by AdminAjax.request

                    // Reload any DataTable on the page
                    if ($.fn.DataTable) {
                        $('.dataTable, table.display').each(function () {
                            if ($.fn.DataTable.isDataTable(this)) {
                                $(this).DataTable().ajax.reload(null, false);
                            }
                        });
                    } else {
                        // Remove row from static table
                        $this.closest('tr').fadeOut(300, function () {
                            $(this).remove();
                        });
                    }
                },
                complete: function () {
                    LoadingState.hideButton($this);
                }
            });
        });
    });

    /**
     * ============================================
     * FORM HELPERS
     * ============================================
     */
    window.FormHelpers = {
        /**
         * Reset form
         * @param {jQuery} $form - The form element
         */
        reset: function ($form) {
            $form[0].reset();
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
        },

        /**
         * Show validation errors
         * @param {jQuery} $form - The form element
         * @param {object} errors - Laravel validation errors object
         */
        showErrors: function ($form, errors) {
            this.clearErrors($form);

            $.each(errors, function (field, messages) {
                const $field = $form.find('[name="' + field + '"]');
                $field.addClass('is-invalid');
                $field.after('<div class="invalid-feedback d-block">' + messages[0] + '</div>');
            });
        },

        /**
         * Clear validation errors
         * @param {jQuery} $form - The form element
         */
        clearErrors: function ($form) {
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
        },

        /**
         * Generic AJAX form submit handler
         * @param {jQuery} $form - The form element
         * @param {object} options - Success and error callbacks
         */
        submit: function ($form, options) {
            options = options || {};
            const $submitBtn = $form.find('[type="submit"]');
            const originalText = $submitBtn.text();
            const url = $form.attr('action');
            const method = $form.attr('method') || 'POST';
            const formData = new FormData($form[0]);

            AdminAjax.request(url, method, formData, {
                contentType: false,
                processData: false,
                beforeSend: function () {
                    FormHelpers.clearErrors($form);
                    LoadingState.showButton($submitBtn, 'Saving...');
                    if (typeof options.beforeSend === 'function') options.beforeSend();
                },
                success: function (response) {
                    if (typeof options.success === 'function') {
                        options.success(response);
                    } else if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        FormHelpers.showErrors($form, xhr.responseJSON.errors);
                    }
                    if (typeof options.error === 'function') options.error(xhr);
                },
                complete: function () {
                    LoadingState.hideButton($submitBtn, originalText);
                    if (typeof options.complete === 'function') options.complete();
                }
            });
        }
    };

    /**
     * ============================================
     * UTILITY FUNCTIONS
     * ============================================
     */
    window.Utils = {
        /**
         * Format number with commas
         * @param {number} num - Number to format
         */
        formatNumber: function (num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        /**
         * Format currency
         * @param {number} amount - Amount to format
         * @param {string} currency - Currency symbol (default: $)
         */
        formatCurrency: function (amount, currency) {
            currency = currency || '$';
            return currency + this.formatNumber(parseFloat(amount).toFixed(2));
        },

        /**
         * Debounce function
         * @param {function} func - Function to debounce
         * @param {number} wait - Wait time in milliseconds
         */
        debounce: function (func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    };

    /**
     * ============================================
     * INITIALIZATION
     * ============================================
     */
    $(document).ready(function () {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Initialize popovers
        $('[data-toggle="popover"]').popover();

        // Auto-hide alerts after 5 seconds
        setTimeout(function () {
            $('.alert:not(.alert-permanent)').fadeOut(300);
        }, 5000);

        // Toastr configuration
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
        }

        console.log('Admin Common JS Loaded');
    });

})(jQuery);

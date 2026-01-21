window.ValidationHandler = {
    /**
     * Show validation errors for a form
     * @param {jQuery} $form - The form to show errors for
     * @param {Object} errors - Laravel validation errors object
     */
    showErrors: function ($form, errors) {
        this.clearErrors($form);

        $.each(errors, function (field, messages) {
            // Laravel uses dot notation for arrays, e.g., 'features.0'
            let $field = $form.find(`[name="${field}"], [name="${field}[]"]`);

            if ($field.length === 0 && field.includes('.')) {
                let parts = field.split('.');
                let arrayField = parts[0] + '[]';
                $field = $form.find(`[name="${arrayField}"]`).eq(parts[1]);
                if ($field.length === 0) {
                    $field = $form.find(`[name="${arrayField}"]`);
                }
            }

            if ($field.length === 0) {
                $field = $form.find(`#${field}`);
            }

            if ($field.length > 0) {
                $field.addClass('is-invalid');

                // Add shake effect
                $field.addClass('shake');
                setTimeout(() => $field.removeClass('shake'), 400);

                let errorMsg = Array.isArray(messages) ? messages[0] : messages;

                // Find or create feedback element
                let $container = $field.closest('.input_area, .form-group, .my_listing_single, .col-12, .col-md-6, .col-xl-4');
                let $feedback = $container.find('.invalid-feedback');

                if ($feedback.length === 0) {
                    $feedback = $('<div class="invalid-feedback active"></div>').text(errorMsg);

                    if ($field.next('.select2-container').length > 0) {
                        $field.next('.select2-container').after($feedback);
                        $field.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                    } else if ($field.parent().hasClass('input-group')) {
                        $field.parent().after($feedback);
                    } else {
                        $field.after($feedback);
                    }
                } else {
                    $feedback.text(errorMsg).addClass('active');
                }
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error(messages[0] || messages);
                }
            }
        });

        // Scroll to first error
        let $firstError = $form.find('.is-invalid').first();
        if ($firstError.length > 0) {
            $('html, body').animate({
                scrollTop: $firstError.offset().top - 150
            }, 500);
        }
    },

    /**
     * Clear all validation errors from a form
     */
    clearErrors: function ($form) {
        $form.find('.is-invalid').removeClass('is-invalid shake');
        $form.find('.select2-container .select2-selection').removeClass('is-invalid');
        $form.find('.invalid-feedback').removeClass('active').text('');
    },

    /**
     * Show error for a single field
     */
    showFieldError: function ($field, message) {
        $field.addClass('is-invalid');
        let $container = $field.closest('.input_area, .form-group, .my_listing_single');
        let $feedback = $container.find('.invalid-feedback');

        // Handle Select2
        if ($field.next('.select2-container').length > 0) {
            $field.next('.select2-container').find('.select2-selection').addClass('is-invalid');
        }

        if ($feedback.length === 0) {
            $feedback = $('<div class="invalid-feedback active"></div>').text(message);

            if ($field.next('.select2-container').length > 0) {
                $field.next('.select2-container').after($feedback);
            } else if ($field.parent().hasClass('input-group')) {
                $field.parent().after($feedback);
            } else {
                $field.after($feedback);
            }
        } else {
            $feedback.text(message).addClass('active');
        }
    },

    /**
     * Initialize automatic error clearing and native validation handling
     */
    init: function () {
        const self = this;

        // Clear error on input
        $(document).on('input change', 'input, select, textarea', function () {
            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid shake');
                let $container = $(this).closest('.input_area, .form-group, .my_listing_single');
                $container.find('.invalid-feedback').removeClass('active');

                if ($(this).next('.select2-container').length > 0) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }
            }
        });

        // Handle native browser validation
        document.addEventListener('invalid', (function () {
            return function (e) {
                // Prevent the default browser tooltip
                e.preventDefault();
                self.showFieldError($(e.target), e.target.validationMessage);
            };
        })(), true);
    }
};

$(document).ready(function () {
    window.ValidationHandler.init();
});

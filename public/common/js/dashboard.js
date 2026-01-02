/**
 * Dashboard JavaScript
 * Handles dashboard-specific functionality
 */

(function ($) {
    'use strict';

    /**
     * Change property status
     * @param {number} propertyId - The property ID
     */
    window.changeStatus = function (propertyId) {
        const $button = $(event.target).closest('a');
        const originalHtml = $button.html();

        AdminAjax.request(
            dashboardRoutes.changePropertyStatus,
            'POST',
            { id: propertyId },
            {
                beforeSend: function () {
                    $button.html('<span class="spinner-grow spinner-grow-sm" role="status"></span>');
                    $button.css('pointer-events', 'none');
                },
                success: function (response) {
                    if (response.success || response.message) {
                        $('#property-row-' + propertyId).fadeOut(300, function () {
                            $(this).remove();
                        });
                        toastr.success(response.message || "Status changed successfully!");
                    } else {
                        toastr.error("Failed to change status. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error("An error occurred. Please try again.");
                    console.error('Error:', error);
                },
                complete: function () {
                    $button.html(originalHtml);
                    $button.css('pointer-events', '');
                }
            }
        );
    };

    /**
     * Claim renter
     * @param {number} renterId - The renter ID
     */
    window.claimRenter = function (renterId) {
        const $button = $(`.submit-spinner-${renterId}`);
        const originalHtml = $button.html();

        AdminAjax.request(
            dashboardRoutes.claimRenter,
            'POST',
            { renterId: renterId },
            {
                beforeSend: function () {
                    $button.html(
                        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Claiming...'
                    );
                    $button.prop('disabled', true);
                },
                success: function (response) {
                    if (response.message || response.status === 'success') {
                        $('#renter-row-' + renterId).fadeOut(300, function () {
                            $(this).remove();
                        });
                        toastr.success(response.message || 'Renter claimed successfully!');
                    } else {
                        toastr.error(response.message || 'Failed to claim renter.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error("An error occurred. Please try again.");
                    console.error('Error:', error);
                },
                complete: function () {
                    $button.html(originalHtml);
                    $button.prop('disabled', false);
                }
            }
        );
    };

    /**
     * Initialize dashboard
     */
    $(document).ready(function () {
        // Add any dashboard-specific initialization here
        console.log('Dashboard JS Loaded');

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Add loading animation to cards
        $('.card').each(function () {
            $(this).addClass('animate__animated animate__fadeIn');
        });
    });

})(jQuery);

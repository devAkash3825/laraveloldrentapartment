/**
 * Global City/State Dropdown Handler
 * 
 * Usage:
 * 1. Add class 'state-dropdown' to your state select
 * 2. Add data-city-target="#city-select-id" to point to the corresponding city dropdown
 * 
 * Example:
 * <select class="state-dropdown" data-city-target="#property-city">...</select>
 * <select id="property-city">...</select>
 */

(function () {
    'use strict';

    /**
     * Load cities for a given state
     */
    async function loadCities(stateId, citySelectElement, showToast = true) {
        if (!citySelectElement) {
            console.error('City select element not provided');
            return;
        }

        // Reset if no state selected
        if (!stateId) {
            citySelectElement.innerHTML = '<option value="">Select City</option>';
            citySelectElement.disabled = true;
            return;
        }

        // Show loading state
        citySelectElement.innerHTML = '<option value="">Loading cities...</option>';
        citySelectElement.disabled = true;

        try {
            console.log(`Fetching cities for state ID: ${stateId}`);
            const response = await fetch(`/cities/${stateId}`);

            if (!response.ok) {
                console.error(`Fetch failed with status: ${response.status}`);
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const cities = await response.json();
            console.log(`Received cities:`, cities);

            // Clear and add default option
            citySelectElement.innerHTML = '<option value="">Select City</option>';
            if (typeof jQuery !== 'undefined' && jQuery.fn.niceSelect) {
                jQuery(citySelectElement).niceSelect('update');
            }

            // Check if cities exist
            if (!cities || cities.length === 0) {
                console.warn('Empty city list received');
                citySelectElement.innerHTML = '<option value="">No cities available</option>';
                if (showToast && typeof toastr !== 'undefined') {
                    toastr.warning('No cities found for this state.');
                }
                citySelectElement.disabled = true;
                return;
            }

            // Populate cities
            cities.forEach(city => {
                const option = document.createElement('option');
                const cityId = city.Id || city.id || city.ID;
                const cityName = city.CityName || city.name || city.cityName || city.City;

                if (cityId !== undefined && cityName !== undefined) {
                    option.value = cityId;
                    option.textContent = cityName;
                    citySelectElement.appendChild(option);
                } else {
                    console.error('Invalid city object:', city);
                }
            });

            citySelectElement.disabled = false;

            // Support for NiceSelect update
            if (typeof jQuery !== 'undefined' && jQuery.fn.niceSelect) {
                jQuery(citySelectElement).niceSelect('update');
            }

            console.log('City dropdown populated and enabled');

        } catch (error) {
            console.error('Error in loadCities:', error);
            citySelectElement.innerHTML = '<option value="">Error loading cities</option>';
            citySelectElement.disabled = true;

            if (showToast && typeof toastr !== 'undefined') {
                toastr.error('Failed to load cities: ' + error.message);
            }
        }
    }

    /**
     * Initialize all state dropdowns on the page
     */
    function initializeStateDropdowns() {
        const stateDropdowns = document.querySelectorAll('.state-dropdown');

        stateDropdowns.forEach(stateSelect => {
            const cityTargetSelector = stateSelect.getAttribute('data-city-target');

            if (!cityTargetSelector) {
                console.warn('State dropdown missing data-city-target attribute:', stateSelect);
                return;
            }

            const citySelect = document.querySelector(cityTargetSelector);

            if (!citySelect) {
                console.error('City dropdown not found for selector:', cityTargetSelector);
                return;
            }

            // Add change event listener
            stateSelect.addEventListener('change', function () {
                const stateId = this.value;
                loadCities(stateId, citySelect);
            });

            // Support for jQuery plugins like Select2 or NiceSelect
            if (typeof jQuery !== 'undefined') {
                jQuery(stateSelect).on('change', function () {
                    const stateId = jQuery(this).val();
                    loadCities(stateId, citySelect);
                });
            }
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeStateDropdowns);
    } else {
        initializeStateDropdowns();
    }

    // Expose globally for manual initialization
    window.CityStateHandler = {
        loadCities: loadCities,
        initialize: initializeStateDropdowns
    };

})();

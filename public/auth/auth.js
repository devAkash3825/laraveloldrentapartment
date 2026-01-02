$(document).ready(function () {
    
    // Manager form submission
    // $("#manager-form").on("submit", function (event) {
    //     alert("auth.js loaded");
    //     event.preventDefault();
    //     $(".invalid-feedback").empty().removeClass("d-block");
    //     let isValid = true;
        
    //     if (!$('input[name="username"]').val()) {
    //         $("#error-username")
    //             .text("Please Enter UserName.")
    //             .addClass("d-block");
    //         isValid = false;
    //     }
        
    //     if (!$('input[name="password"]').val()) {
    //         $("#error-password")
    //             .text("Please Enter Password.")
    //             .addClass("d-block");
    //         isValid = false;
    //     }
        
    //     if (
    //         $('input[name="password"]').val() !==
    //         $('input[name="password_confirmation"]').val()
    //     ) {
    //         $("#error-password_confirmation")
    //             .text("Passwords do not match.")
    //             .addClass("d-block");
    //         isValid = false;
    //     }
        
    //     if (!$('input[name="email"]').val() || !isValidEmail($('input[name="email"]').val())) {
    //         $("#error-email")
    //             .text("Please Enter a Valid Email Address.")
    //             .addClass("d-block");
    //         isValid = false;
    //     }

    //     if (!isValid) {
    //         return;
    //     }
        
    //     let formData = $(this).serialize();
    //     $.ajax({
    //         url: "/manager-register",
    //         type: "POST",
    //         data: formData,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //         beforeSend: function () {
    //             $('.send-btn').html(` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`)
    //             $('.send-btn').prop('disabled', true);
    //         },
    //         success: function (response) {
    //             if (response.success) {
    //                 $('.send-btn').html(`Register`);
    //                 $('.send-btn').prop('disabled', true);
    //                 toastr.success(response.success);
    //                 window.location.href = "/";
    //             } else {
    //                 $('.send-btn').html(`Register`);
    //                 toastr.error("There were errors with your submission.");
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             $('.send-btn').html(`Register`);
    //             console.error("Error:", error);
    //         },
    //         complete: function () {
    //             $('.send-btn').html(`Register`);
    //             $('.send-btn').prop('disabled', false);
    //         }
    //     });
    // });

    // Renter form submission
    $("#renterRegister-btn").on("click", function (event) {
        event.preventDefault();
        
        // Validate all steps before submission
        let allValid = true;
        for (let i = 0; i <= stepCount; i++) {
            if (!validateStep(i)) {
                allValid = false;
            }
        }
        
        if (!allValid) {
            toastr.error("Please complete all required fields.");
            return;
        }

        const preloader = $(".preloader");
        const overlay = $(".overlay");
        preloader.show();
        overlay.show();

        let formData = new FormData($("#form-wrapper")[0]);
        $.ajax({
            url: "renter-register",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                preloader.hide();
                overlay.hide();
                if (response.success) {
                    console.log(" Renter Submitted ", response);
                    toastr.success("Form submitted successfully!");
                    window.location.href = "/";
                } else {
                    console.log("Not Submitted ");
                    toastr.error("There were errors with your submission.");
                    $.each(response.errors, function (key, value) {
                        let errorElement = $(`#error-${key}`);
                        if (errorElement.length) {
                            errorElement.text(value[0]).addClass("d-block");
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                preloader.hide();
                overlay.hide();
                toastr.error("An error occurred while submitting the form.");
                console.error("Error:", error);
            },
        });
    });

    // City dropdown population based on state selection
    $("#renterstate").on("change", function () {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: "/cities/" + stateId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#rentercity").empty();
                    $("#rentercity").append(
                        '<option value="">Select City</option>'
                    );
                    $.each(data, function (key, value) {
                        $("#rentercity").append(
                            '<option value="' +
                            value.Id +
                            '">' +
                            value.CityName +
                            "</option>"
                        );
                    });
                },
            });
        } else {
            $("#rentercity").empty();
            $("#rentercity").append('<option value="">Select City</option>');
        }
    });

    // Multi-step form functionality
    let step = document.getElementsByClassName("step");
    let prevBtn = document.getElementById("before-btn");
    let nextBtn = document.getElementById("after-btn");
    let submitBtn = document.getElementById("renterRegister-btn");
    let form = document.getElementById("form-wrapper");
    let current_step = 0;
    let stepCount = step.length - 1;
    
    if (step[current_step]) {
        step[current_step].classList.add("d-block");
    }

    if (current_step == 0) {
        prevBtn.classList.add("d-none");
        submitBtn.classList.add("d-none");
        nextBtn.classList.add("d-inline-block");
    }

    const progress = (value) => {
        document.getElementsByClassName(
            "progress-bar"
        )[0].style.width = `${value}%`;
    };

    // Email validation function
    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // Password validation function
    function validatePassword(password) {
        // At least 8 characters, one uppercase, one lowercase, one number
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        return re.test(password);
    }

    // Validate specific step
    function validateStep(stepIndex) {
        let inputs = step[stepIndex].querySelectorAll(
            "input, select, textarea"
        );
        let valid = true;

        inputs.forEach((input) => {
            // Skip validation for non-required fields
            if (!input.hasAttribute('required')) return;
            
            let errorElement = document.getElementById(`error-${input.name}`) || 
                              document.getElementById(`error-${input.id}`);
            
            // Clear previous errors
            if (errorElement) {
                errorElement.classList.remove("d-block");
            }
            
            // Special validation for email
            if (input.type === 'email' && input.value && !isValidEmail(input.value)) {
                valid = false;
                input.classList.add("is-invalid");
                if (errorElement) {
                    errorElement.textContent = "Please enter a valid email address.";
                    errorElement.classList.add("d-block");
                }
                return;
            }
            
            // Special validation for password on step 0
            if (stepIndex === 0 && input.name === 'password' && input.value && !validatePassword(input.value)) {
                valid = false;
                input.classList.add("is-invalid");
                if (errorElement) {
                    errorElement.textContent = "Password must be at least 8 characters with uppercase, lowercase, and number.";
                    errorElement.classList.add("d-block");
                }
                return;
            }
            
            // Special validation for password confirmation
            if (stepIndex === 0 && input.name === 'password_confirmation' && input.value) {
                let password = document.getElementById('password').value;
                if (input.value !== password) {
                    valid = false;
                    input.classList.add("is-invalid");
                    if (errorElement) {
                        errorElement.textContent = "Passwords do not match.";
                        errorElement.classList.add("d-block");
                    }
                    return;
                }
            }
            
            // Special validation for zip code
            if (input.name === 'zip' && input.value && !/^\d{5}(-\d{4})?$/.test(input.value)) {
                valid = false;
                input.classList.add("is-invalid");
                if (errorElement) {
                    errorElement.textContent = "Please enter a valid zip code.";
                    errorElement.classList.add("d-block");
                }
                return;
            }
            
            // Special validation for phone numbers
            if ((input.name === 'cell' || input.name === 'otherphone') && input.value && 
                !/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/.test(input.value)) {
                valid = false;
                input.classList.add("is-invalid");
                if (errorElement) {
                    errorElement.textContent = "Please enter a valid phone number.";
                    errorElement.classList.add("d-block");
                }
                return;
            }
            
            // Special validation for date fields
            if ((input.name === 'earliestdate' || input.name === 'latestdate') && input.value) {
                let earliest = new Date(document.getElementById('earliestdate').value);
                let latest = new Date(document.getElementById('latestdate').value);
                
                if (earliest > latest) {
                    valid = false;
                    input.classList.add("is-invalid");
                    if (errorElement) {
                        errorElement.textContent = "Latest date must be after earliest date.";
                        errorElement.classList.add("d-block");
                    }
                    return;
                }
            }
            
            // Special validation for price range
            if ((input.name === 'price_from' || input.name === 'price_to') && input.value) {
                let priceFrom = parseFloat(document.getElementById('price-from').value) || 0;
                let priceTo = parseFloat(document.getElementById('price-to').value) || 0;
                
                if (priceFrom > priceTo) {
                    valid = false;
                    input.classList.add("is-invalid");
                    if (errorElement) {
                        errorElement.textContent = "Maximum price must be greater than minimum price.";
                        errorElement.classList.add("d-block");
                    }
                    return;
                }
            }
            
            // Standard required field validation
            if (!input.value) {
                valid = false;
                input.classList.add("is-invalid");
                if (errorElement) {
                    errorElement.textContent = "This field is required.";
                    errorElement.classList.add("d-block");
                }
            } else {
                input.classList.remove("is-invalid");
            }
        });

        return valid;
    }

    nextBtn.addEventListener("click", () => {
        if (validateStep(current_step)) {
            current_step++;
            let previous_step = current_step - 1;
            if (current_step <= stepCount) {
                prevBtn.classList.remove("d-none");
                prevBtn.classList.add("d-inline-block");
                step[current_step].classList.remove("d-none");
                step[current_step].classList.add("d-block");
                step[previous_step].classList.remove("d-block");
                step[previous_step].classList.add("d-none");
                if (current_step == stepCount) {
                    submitBtn.classList.remove("d-none");
                    submitBtn.classList.add("d-inline-block");
                    nextBtn.classList.remove("d-inline-block");
                    nextBtn.classList.add("d-none");
                }
            }
            progress((100 / stepCount) * current_step);
        }
    });

    prevBtn.addEventListener("click", () => {
        if (current_step > 0) {
            current_step--;
            let previous_step = current_step + 1;
            step[current_step].classList.remove("d-none");
            step[current_step].classList.add("d-block");
            step[previous_step].classList.remove("d-block");
            step[previous_step].classList.add("d-none");
            if (current_step < stepCount) {
                submitBtn.classList.remove("d-inline-block");
                submitBtn.classList.add("d-none");
                nextBtn.classList.remove("d-none");
                nextBtn.classList.add("d-inline-block");
            }
            if (current_step == 0) {
                prevBtn.classList.remove("d-inline-block");
                prevBtn.classList.add("d-none");
            }
            progress((100 / stepCount) * current_step);
        }
    });

    // Update price range display
    function updatePriceRange(value) {
        document.getElementById("price-range-value").innerText = value;
    }

    // Bedroom selection styling
    document.querySelectorAll('.selectbeds-div input[type="checkbox"]')
        .forEach((checkbox) => {
            checkbox.addEventListener("change", function () {
                if (this.checked) {
                    this.parentNode.classList.add("checked");
                } else {
                    this.parentNode.classList.remove("checked");
                }
            });
        });
});
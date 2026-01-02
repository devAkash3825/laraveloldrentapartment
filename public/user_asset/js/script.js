document.addEventListener("DOMContentLoaded", () => {
    let step = document.getElementsByClassName("step");
    let prevBtn = document.getElementById("prev-btn");
    let nextBtn = document.getElementById("next-btn");
    let submitBtn = document.getElementById("submit-btn-add-property");
    let form = document.getElementById("form-wrapper");
    let preloader = document.getElementById("preloader-wrapper");
    let bodyElement = document.querySelector("body");
    let successDiv = document.getElementById("success");
    let current_step = 0;
    let stepCount = step.length - 1;
    step[current_step].classList.add("d-block");

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

    const validateStep = () => {
        let inputs = step[current_step].querySelectorAll(
            "input, select, textarea"
        );
        for (let input of inputs) {
            if (!input.checkValidity()) {
                input.classList.add("is-invalid");
                return false;
            }
            input.classList.remove("is-invalid");
        }
        return true;
    };

    nextBtn.addEventListener("click", () => {
        if (validateStep()) {
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

    const radioButtons = document.querySelectorAll(
        'input[name="inlineRadioOptions"]'
    );

    const addressField = document.getElementById("addressField");

    radioButtons.forEach((radio) => {
        radio.addEventListener("change", function () {
            if (this.value === "address") {
                addressField.classList.remove("hidden");
            } else {
                addressField.classList.add("hidden");
            }
        });
    });

    submitBtn.addEventListener("click", (event) => {
        if (validateStep()) {
            form.submit();
        } else {
            event.preventDefault();
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    let step = document.getElementsByClassName("step");
    let prevBtn = document.getElementById("before-btn");
    let nextBtn = document.getElementById("after-btn");
    let submitBtn = document.getElementById("renterRegister-btn");
    let form = document.getElementById("form-wrapper");
    let preloader = document.getElementById("preloader-wrapper");
    let bodyElement = document.querySelector("body");
    let successDiv = document.getElementById("success");
    let current_step = 0;
    let stepCount = step.length - 1;
    step[current_step].classList.add("d-block");

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

    const validateStep = () => {
        let inputs = step[current_step].querySelectorAll(
            "input, select, textarea"
        );
        for (let input of inputs) {
            if (!input.checkValidity()) {
                input.classList.add("is-invalid");
                return false;
            }
            input.classList.remove("is-invalid");
        }
        return true;
    };

    nextBtn.addEventListener("click", () => {
        if (validateStep()) {
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

    const radioButtons = document.querySelectorAll(
        'input[name="inlineRadioOptions"]'
    );

    const addressField = document.getElementById("addressField");

    radioButtons.forEach((radio) => {
        radio.addEventListener("change", function () {
            if (this.value === "address") {
                addressField.classList.remove("hidden");
            } else {
                addressField.classList.add("hidden");
            }
        });
    });

    submitBtn.addEventListener("click", (event) => {
        if (validateStep()) {
            form.submit();
        } else {
            event.preventDefault();
        }
    });
});

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

document.addEventListener("DOMContentLoaded", (event) => {
    var toastElList = [].slice.call(document.querySelectorAll(".toast"));
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });
    toastList.forEach((toast) => toast.show());
});
$(document).ready(function () {
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

    $("#renterRegister-btn").on("click", function (event) {
        alert("dddd");
        if (validateStep()) {
            let formData = new FormData($("#form-wrapper")[0]);

            $.ajax({
                url: "renter-register",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(), // CSRF token from hidden input field
                },
                success: function (response) {
                    if (response.success) {
                        alert("Form submitted successfully!");
                    } else {
                        // Display validation errors from the server
                        $.each(response.errors, function (key, value) {
                            let errorElement = $(`#error-${key}`);
                            if (errorElement.length) {
                                errorElement.text(value[0]); // Display the first error message
                            }
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                },
            });
        } else {
            event.preventDefault();
        }
    });
});

// addtoFavorite



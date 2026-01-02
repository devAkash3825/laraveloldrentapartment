// $("#add-property-state").on("change", function () {
//     var stateId = $(this).val();
//     if (stateId) {
//         $.ajax({
//             url: "/cities/" + stateId,
//             type: "GET",
//             dataType: "json",
//             success: function (data) {
//                 $("#add-property-city").empty();
//                 $("#add-property-city").append(
//                     '<option value="">Select City</option>'
//                 );
//                 $.each(data, function (key, value) {
//                     $("#add-property-city").append(
//                         '<option value="' +
//                             value.Id +
//                             '">' +
//                             value.CityName +
//                             "</option>"
//                     );
//                 });
//             },
//         });
//     } else {
//         $("#add-property-city").empty();
//         $("#add-property-city").append('<option value="">Select City</option>');
//     }
// });


// $("#add-property-city").on("change", function () {
//     var cityid = $(this).val();
//     if (cityid) {
//         $.ajax({
//             url: "/getstate-city-name/" + cityid,
//             type: "GET",
//             dataType: "json",
//             success: function (data) {
//                 $("#filledcity").val(data.city_name);
//                 $("#filledstate").val(data.state_name);
//                 $("#fillstateid").val(data.state_id);
//                 $("#filledcityid").val(cityid);
//             },
//         });
//     } else {
//         $("#add-property-city").empty();
//         $("#add-property-city").append('<option value="">Select City</option>');
//     }
// });


$("#bill_address_state").on("change", function () {
    var stateId = $(this).val();
    if (stateId) {
        $.ajax({
            url: "/cities/" + stateId,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#bill_address_city").empty();
                $("#bill_address_city").append(
                    '<option value="">Select City</option>'
                );
                $.each(data, function (key, value) {
                    $("#bill_address_city").append(
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
        $("#bill_address_city").empty();
        $("#bill_address_city").append('<option value="">Select City</option>');
    }
});

$('#selectAll').on('click', function() {
    $('.selectItem').prop('checked', this.checked);
});
$("#sameaspropertyaddress").change(function () {
    if ($(this).is(":checked")) {
        var selectedStateId = $("#fillstateid").val();
        var selectedCityId = $("#filledcityid").val();
        console.log(selectedStateId);
        console.log(selectedCityId);
        $.ajax({
            url: "states-n-cities",
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#ifnotchecked").hide();
                $("#ifchecked").show();
                $("#bill_address_state_same").empty();
                $("#bill_address_state").removeAttr("required");
                $("#bill_address_state_same").append(
                    '<option value="">Select State</option>'
                );

                $("#bill_address_city_same").empty();
                $("#bill_address_city").removeAttr("required");
                $("#bill_address_city_same").append(
                    '<option value="">Select City</option>'
                );

                $("#billemail").val($("#addpropertyemail").val());

                $.each(data.states, function (key, value) {
                    if (value.Id == selectedStateId) {
                        $("#bill_address_state_same").append(
                            '<option value="' +
                                value.Id +
                                '" selected>' +
                                value.StateName +
                                "</option>"
                        );
                    }
                });

                $.each(data.states, function (key, value) {
                    if (value.Id != selectedStateId) {
                        $("#bill_address_state_same").append(
                            '<option value="' +
                                value.Id +
                                '">' +
                                value.StateName +
                                "</option>"
                        );
                    }
                });

                $.each(data.cities, function (key, value) {
                    if (value.Id == selectedCityId) {
                        $("#bill_address_city_same").append(
                            '<option value="' +
                                value.Id +
                                '" selected>' +
                                value.CityName +
                                "</option>"
                        );
                    }
                });

                $.each(data.cities, function (key, value) {
                    if (value.Id != selectedCityId) {
                        $("#bill_address_city_same").append(
                            '<option value="' +
                                value.Id +
                                '">' +
                                value.CityName +
                                "</option>"
                        );
                    }
                });
            },
        });
    } else {
        $("#ifnotchecked").show();
        $("#ifchecked").hide();
        $("#bill_address_state").prop("required");
        $("#bill_address_city").prop("required");
        $("#bill_address_state_same").val("");
        $("#bill_address_city_same").val("");
        $("#billemail").val("");
    }
});

$('#notes-close-btn').on('click',function(){
    $("#message-block").empty();
});

$(".getnotedetails").on("click", function () {
    var propertyId = $(this).data("id");
    $("#message-block").empty();
    console.log(propertyId);
    try {
        $.ajax({
            url: "get-notes-detail",
            type: "post",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                propertyId: propertyId,
            },
            success: function (data) {
                $("#message-block").append(data.notedetails[0].message);
            },
            error: function (xhr, status, error) {
                console.log("Error:", error);
            },
        });
    } catch (err) {
        console.log("There is Some issue in Adding Notes", err);
    }
});


(function () {
    "use strict";

    const select = (el, all = false) => {
        el = el.trim();
        if (all) {
            return [...document.querySelectorAll(el)];
        } else {
            return document.querySelector(el);
        }
    };

    const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all);
        if (selectEl) {
            if (all) {
                selectEl.forEach((e) => e.addEventListener(type, listener));
            } else {
                selectEl.addEventListener(type, listener);
            }
        }
    };

    const onscroll = (el, listener) => {
        el.addEventListener("scroll", listener);
    };

    let selectHNavbar = select(".navbar-default");
    if (selectHNavbar) {
        onscroll(document, () => {
            if (window.scrollY > 100) {
                selectHNavbar.classList.add("navbar-reduce");
                selectHNavbar.classList.remove("navbar-trans");
            } else {
                selectHNavbar.classList.remove("navbar-reduce");
                selectHNavbar.classList.add("navbar-trans");
            }
        });
    }

    let backtotop = select(".back-to-top");
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add("active");
            } else {
                backtotop.classList.remove("active");
            }
        };
        window.addEventListener("load", toggleBacktotop);
        onscroll(document, toggleBacktotop);
    }

    let preloader = select("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }

    let body = select("body");
    on("click", ".navbar-toggle-box", function (e) {
        e.preventDefault();
        body.classList.add("box-collapse-open");
        body.classList.remove("box-collapse-closed");
    });

    on("click", ".close-box-collapse", function (e) {
        e.preventDefault();
        body.classList.remove("box-collapse-open");
        body.classList.add("box-collapse-closed");
    });

    new Swiper(".intro-carousel", {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        slidesPerView: "auto",
        pagination: {
            el: ".swiper-pagination",
            type: "bullets",
            clickable: true,
        },
    });

    new Swiper("#property-carousel", {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: "auto",
        pagination: {
            el: ".propery-carousel-pagination",
            type: "bullets",
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20,
            },

            1200: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });

    new Swiper("#news-carousel", {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: "auto",
        pagination: {
            el: ".news-carousel-pagination",
            type: "bullets",
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20,
            },

            1200: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });

    new Swiper("#testimonial-carousel", {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: "auto",
        pagination: {
            el: ".testimonial-carousel-pagination",
            type: "bullets",
            clickable: true,
        },
    });

    new Swiper("#property-single-carousel", {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".property-single-carousel-pagination",
            type: "bullets",
            clickable: true,
        },
    });
})();

(function ($) {
    "use strict";

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $(".back-to-top").fadeIn("slow");
        } else {
            $(".back-to-top").fadeOut("slow");
        }
    });

    $(".back-to-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
        return false;
    });

    $(".counter").countUp();

    var nav = $("nav");
    var navHeight = nav.outerHeight();

    $(".intro-carousel").on("translate.owl.carousel", function () {
        $(".intro-content .intro-title").removeClass("zoomIn animated").hide();
        $(".intro-content .intro-price")
            .removeClass("fadeInUp animated")
            .hide();
        $(".intro-content .intro-title-top, .intro-content .spacial")
            .removeClass("fadeIn animated")
            .hide();
    });

    $(".intro-carousel").on("translated.owl.carousel", function () {
        $(".intro-content .intro-title").addClass("zoomIn animated").show();
        $(".intro-content .intro-price").addClass("fadeInUp animated").show();
        $(".intro-content .intro-title-top, .intro-content .spacial")
            .addClass("fadeIn animated")
            .show();
    });

    $(".navbar-toggle-box-collapse").on("click", function () {
        $("body")
            .removeClass("box-collapse-closed")
            .addClass("box-collapse-open");
    });

    $(".close-box-collapse, .click-closed").on("click", function () {
        $("body")
            .removeClass("box-collapse-open")
            .addClass("box-collapse-closed");
        $(".menu-list ul").slideUp(700);
    });

    $(window).trigger("scroll");

    $(window).bind("scroll", function () {
        var pixels = 50;
        var top = 1200;
        if ($(window).scrollTop() > pixels) {
            $(".navbar-default").addClass("navbar-reduce");
            $(".navbar-default").removeClass("navbar-trans");
        } else {
            $(".navbar-default").addClass("navbar-trans");
            $(".navbar-default").removeClass("navbar-reduce");
        }
        if ($(window).scrollTop() > top) {
            $(".scrolltop-mf").fadeIn(1000, "easeInOutExpo");
        } else {
            $(".scrolltop-mf").fadeOut(1000, "easeInOutExpo");
        }
    });

    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        nav: true,
        navText: [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>',
        ],
    });

    $(".navbar-toggle-box-collapse").on("click", function () {
        $("body")
            .removeClass("box-collapse-closed")
            .addClass("box-collapse-open");
    });

    $(".close-box-collapse, .click-closed").on("click", function () {
        $("body")
            .removeClass("box-collapse-open")
            .addClass("box-collapse-closed");
        $(".menu-list ul").slideUp(700);
    });

    $(function () {
        $(".js-check-all").on("click", function () {
            if ($(this).prop("checked")) {
                $('.control--checkbox input[type="checkbox"]').each(
                    function () {
                        $(this).prop("checked", true);
                        $(this).closest("tr").addClass("active");
                    }
                );
            } else {
                $('.control--checkbox input[type="checkbox"]').each(
                    function () {
                        $(this).prop("checked", false);
                        $(this).closest("tr").removeClass("active");
                    }
                );
            }
        });

        $('.control--checkbox input[type="checkbox"]').on("click", function () {
            if ($(this).closest("tr").hasClass("active")) {
                $(this).closest("tr").removeClass("active");
            } else {
                $(this).closest("tr").addClass("active");
            }
        });
    });
    
})(jQuery);

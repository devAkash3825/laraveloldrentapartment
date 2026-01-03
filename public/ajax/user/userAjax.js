
$(function () {
    // 1. GLOBAL AJAX SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function (xhr, settings) {
            // Don't show global loader for 'checkIsFavorite' or other background background tasks
            const backgroundUrls = ['/is-favorite', '/is-favorite'];
            if (!backgroundUrls.some(url => settings.url.includes(url))) {
                $('#global-loader').css('display', 'flex');
            }
        },
        complete: function () {
            $('#global-loader').hide();
        },
        error: function (xhr, status, error) {
            if (xhr.status === 401) {
                toastr.error("Please login to continue.");
            } else if (xhr.status >= 500) {
                toastr.error("Something went wrong on the server. Please try again later.");
            }
            console.error("AJAX Error:", error, xhr);
        }
    });

    // 2. FAVORITE FUNCTIONALITY
    function checkIsFav() {
        var propertyId = $("#addtofavorite").val();
        if (!propertyId) return;

        $.ajax({
            url: "/is-favorite",
            method: "POST",
            data: JSON.stringify({ propertyId: propertyId }),
            contentType: "application/json",
            success: function (data) {
                var $filledHeartIcon = $("#addtofavorite .bi-heart-fill");
                var $outlineHeartIcon = $("#addtofavorite .bi-heart");
                if (data.isFavorite) {
                    $filledHeartIcon.show();
                    $outlineHeartIcon.hide();
                } else {
                    $filledHeartIcon.hide();
                    $outlineHeartIcon.show();
                }
            }
        });
    }
    checkIsFav();

    $("#addtofavorite").on("click", function (e) {
        e.preventDefault();
        var $btn = $(this);
        var propertyId = $btn.val();
        var $iconFilled = $btn.find(".bi-heart-fill");
        var $iconOutline = $btn.find(".bi-heart");

        $.ajax({
            url: "/add-to-favorite",
            method: "POST",
            data: { propertyId: propertyId },
            beforeSend: function () {
                $btn.css('pointer-events', 'none').css('opacity', '0.7');
            },
            success: function (response) {
                if (response.success) {
                    if (response.action === 'added') {
                        toastr.success(response.message);
                        $iconFilled.show();
                        $iconOutline.hide();
                    } else {
                        toastr.info(response.message);
                        $iconFilled.hide();
                        $iconOutline.show();
                    }
                }
            },
            complete: function () {
                $btn.css('pointer-events', 'auto').css('opacity', '1');
            }
        });
    });

    // 3. DATATABLES INITIALIZATION
    const dtConfigs = [
        { id: "#fav-listview", url: "/favorite/list-view", columns: [{ data: "DT_RowIndex" }, { data: "propertyname" }, { data: "quote" }, { data: "action" }] },
        { id: "#recently-visited", url: "/recently-visited", columns: [{ data: "DT_RowIndex" }, { data: "propertyname" }, { data: "datetime" }] },
        { id: "#myproperties", url: "/my-properties", columns: [{ data: "DT_RowIndex" }, { data: "image" }, { data: "propertyname" }, { data: "action" }] }
    ];

    dtConfigs.forEach(config => {
        if ($(config.id).length) {
            $(config.id).DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                ajax: config.url,
                columns: config.columns,
                autoWidth: true,
                responsive: true
            });
        }
    });

    // 4. PASSWORD CHANGE
    $("#changePasswordForm").on("submit", function (e) {
        e.preventDefault();
        var $form = $(this);
        $.ajax({
            url: "/reset-password",
            type: "POST",
            data: $form.serialize(),
            success: function (response) {
                toastr.success(response.success || "Password Changed Successfully");
                $form[0].reset();
            },
            error: function (xhr) {
                let msg = xhr.responseJSON?.error || "Failed to change password.";
                toastr.error(msg);
            }
        });
    });

    // 5. CONTACT FORM
    $("#submitContactForm").on("click", function (e) {
        e.preventDefault();
        var $form = $("#contactForm");
        var $btn = $(this);
        $(".error-message").remove();

        $.ajax({
            url: "/submit-contact-us",
            type: "POST",
            data: new FormData($form[0]),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm"></span> Submitting...');
            },
            success: function (response) {
                if (response.success) {
                    $form[0].reset();
                    toastr.success("Message sent successfully!");
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $form.find("[name='" + key + "']").after('<div class="error-message text-danger small mt-1">' + value[0] + '</div>');
                    });
                }
                toastr.error("Please fix the errors below.");
            },
            complete: function () {
                $btn.prop("disabled", false).html('Submit');
            }
        });
    });

    // 6. PROPERTY FILTERS & PAGINATION
    $(document).on("click", ".grid-pagination span, .ajax-pagination a", function (e) {
        e.preventDefault();
        var url = $(this).attr("href") || $(this).data("url");
        if (!url) return;

        $.ajax({
            url: url,
            method: "get",
            success: function (response) {
                $("#propertyGrid").html(response.html);
                $("#paginationLinks, #pagination").html(response.pagination);
                response.html ? $("#notFoundMessage").hide() : $("#notFoundMessage").show();
            }
        });
    });

    // 7. YEAR SELECTS
    if ($("#year-select").length || $("#year-remodeled").length) {
        const currentYear = new Date().getFullYear();
        const selectedYear = $("#yearbuildvalue").val();
        const selectedRemodeledYear = $("#yearremodeledvalue").val();

        for (let year = currentYear; year >= 1900; year--) {
            $("#year-select").append(new Option(year, year, year == selectedYear, year == selectedYear));
            $("#year-remodeled").append(new Option(year, year, year == selectedRemodeledYear, year == selectedRemodeledYear));
        }
    }

    // 8. MISC HELPERS
    $(".summer_note").length && $(".summer_note").summernote();

    // Dynamic row addition (if needed)
    $("#add_row").on("click", function () {
        const html = `
            <div class="remove-container mt-2">
                <div class="d-flex gap-2">
                    <input type="date" name="name[]" class="form-control">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                </div>
            </div>`;
        $("#medicine_row").append(html);
    });

    $(document).on("click", ".remove-row", function () {
        $(this).closest(".remove-container").remove();
    });
});

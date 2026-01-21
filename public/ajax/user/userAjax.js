
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
        var $favBtn = $("#addtofavorite");
        if ($favBtn.length === 0) return;

        var propertyId = $favBtn.data('value') || $favBtn.attr('value') || $favBtn.val();
        if (!propertyId) return;

        $.ajax({
            url: "/is-favorite",
            method: "POST",
            data: { propertyId: propertyId },
            success: function (data) {
                var $link = $favBtn.find('a');
                if (data.isFavorite) {
                    $link.html('<i class="fa-solid fa-heart text-danger me-1"></i> Saved to Favorites');
                    $favBtn.addClass('is-fav');
                } else {
                    $link.html('<i class="fa-regular fa-heart me-1"></i> Add to Favorite');
                    $favBtn.removeClass('is-fav');
                }
            }
        });
    }
    checkIsFav();

    $("#addtofavorite").on("click", function (e) {
        e.preventDefault();
        var $btn = $(this);
        var propertyId = $btn.data('value') || $btn.attr('value') || $btn.val();
        if (!propertyId) return;

        // Directly call toggleFavorite without a modal
        toggleFavorite(propertyId, $btn, '');
    });

    function toggleFavorite(propertyId, $btn, note) {
        $.ajax({
            url: "/add-to-favorite",
            method: "POST",
            data: {
                propertyId: propertyId,
                notes: note
            },
            beforeSend: function () {
                $btn.css('pointer-events', 'none').css('opacity', '0.7');
            },
            success: function (response) {
                if (response.success) {
                    if (response.action === 'added') {
                        toastr.success('<i class="fa-solid fa-heart me-2"></i>' + response.message);
                    } else {
                        // Action was 'removed'
                        toastr.info('<i class="fa-regular fa-heart me-2"></i>' + response.message);

                        // If this was a remove button in the table, remove the row immediately
                        if ($btn.hasClass('remove-single-fav')) {
                            var $row = $btn.closest('tr');
                            if ($.fn.DataTable.isDataTable('#fav-listview')) {
                                $('#fav-listview').DataTable().row($row).remove().draw(false);
                            } else {
                                $row.fadeOut(300, function () { $(this).remove(); });
                            }
                        }
                    }
                    checkIsFav(); // Refresh global favorite state (e.g. counters)

                    // Always reload table if it exists to ensure sync
                    if ($.fn.DataTable.isDataTable('#fav-listview')) {
                        $('#fav-listview').DataTable().ajax.reload(null, false);
                    }
                }
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    toastr.error("Please login to manage favorites.");
                } else {
                    toastr.error("Could not update favorites. Please try again.");
                }
            },
            complete: function () {
                $btn.css('pointer-events', 'auto').css('opacity', '1');
            }
        });
    }

    // Remove single favorite from list view
    $(document).on('click', '.remove-single-fav', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var propertyId = $btn.data('id');

        Swal.fire({
            title: 'Remove from Favorites?',
            text: "Are you sure you want to remove this property?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                toggleFavorite(propertyId, $btn, '');
            }
        });
    });

    // 3. DATATABLES INITIALIZATION
    const dtConfigs = [
        { id: "#recently-visited", url: "/recently-visited", columns: [{ data: "DT_RowIndex" }, { data: "propertyname" }, { data: "datetime" }] },
        { id: "#myproperties", url: "/my-properties", columns: [{ data: "DT_RowIndex" }, { data: "image" }, { data: "propertyname" }, { data: "action" }] }
    ];

    dtConfigs.forEach(config => {
        if ($(config.id).length && !$.fn.DataTable.isDataTable(config.id)) {
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
                if (xhr.status === 422) {
                    window.ValidationHandler.showErrors($form, xhr.responseJSON.errors);
                } else {
                    let msg = xhr.responseJSON?.error || "Failed to change password.";
                    toastr.error(msg);
                }
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
                    window.ValidationHandler.showErrors($form, xhr.responseJSON.errors);
                } else {
                    toastr.error("An error occurred. Please try again later.");
                }
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



    // Dynamic row addition (if needed)
    $("#add_row").on("click", function () {
        const html = `
            <div class="remove-container mt-2">
                <div class="d-flex gap-2">
                    <input type="date" name="name[]" class="form-control">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>`;
        $("#medicine_row").append(html);
    });

    $(document).on("click", ".remove-row", function () {
        $(this).closest(".remove-container").remove();
    });
});

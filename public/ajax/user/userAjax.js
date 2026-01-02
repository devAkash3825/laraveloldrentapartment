$(document).ready(function () {
    function checkIsFav() {
        var propertyId = $("#addtofavorite").val();
        $.ajax({
            url: "/is-favorite",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: "application/json",
            data: JSON.stringify({
                propertyId: propertyId,
            }),
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
            },
            error: function (xhr, status, error) {
                console.error("An error occurred: " + error);
            },
        });
    }
    checkIsFav();

    $(function () {
        try {
            $("#fav-listview").DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                ajax: "/favorite/list-view",
                columns: [
                    { data: "DT_RowIndex", name: "DT_RowIndex" },
                    { data: "propertyname", name: "propertyname" },
                    { data: "quote", name: "quote" },
                    { data: "action", name: "action" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    $(function () {
        try {
            $("#recently-visited").DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                ajax: "/recently-visited",
                columns: [
                    { data: "DT_RowIndex", name: "DT_RowIndex" },
                    { data: "propertyname", name: "propertyname" },
                    { data: "datetime", name: "datetime" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    $(".addtorecent").on("click", function (e) {
        e.preventDefault();
        var propertyId = $(this).data("id");
        console.log("addtorecent", propertyId);

        $.ajax({
            url: "/add-to-recent",
            method: "POST",
            data: {
                propertyId: propertyId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.error) {
                    // toastr.warning("Property removed from Favorite List !");
                    console.log("");
                } else {
                    console.log("err: Property Not Added in Recent List ");
                }
            },
            error: function (xhr, status, error) {
                console.error("An error occurred: " + error);
            },
        });
    });

    $("#changePasswordForm").on("submit", function (e) {
        e.preventDefault();

        var formData = {
            old_password: $('input[name="old_password"]').val(),
            password: $('input[name="password"]').val(),
            password_confirmation: $(
                'input[name="password_confirmation"]'
            ).val(),
            _token: $('input[name="_token"]').val(),
        };

        $.ajax({
            url: "/reset-password",
            type: "POST",
            data: formData,
            success: function (response) {
                toastr.success("Password Changed Successfully ");
            },
            error: function (response) {
                toastr.warning("Oops, Password not Change Please Try Again ");
            },
        });
    });

    $("#advancedSearchForm").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "advance-search",
            method: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                displaySearchResults(response);
            },
            error: function (xhr) {
                console.error(
                    "Error fetching search results:",
                    xhr.responseText
                );
                $("#searchResults").html(
                    "<p>An error occurred while searching. Please try again.</p>"
                );
            },
        });
    });

    $(document).on("click", ".grid-pagination span", function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        $.ajax({
            url: url,
            method: "get",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.data.length > 0) {
                    $("#propertyGrid").html(response.html);
                    $("#paginationLinks").html(response.pagination);
                    $("#notFoundMessage").hide();
                } else {
                    $("#propertyGrid").html("");
                    $("#paginationLinks").html("");
                    $("#notFoundMessage").show();
                }
            },
            error: function (xhr) {
                console.error(
                    "Error fetching pagination results:",
                    xhr.responseText
                );
                $("#propertyGrid").html(
                    "<p>An error occurred while loading. Please try again.</p>"
                );
            },
        });
    });

    $(function () {
        try {
            $("#myproperties").DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                autoWidth: true,
                responsive: true,
                ajax: "/my-properties",
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: false,
                        searchable: false,
                    },
                    { data: "image", name: "image" },
                    { data: "propertyname", name: "propertyname" },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    $("#add-property-state").on("change", function () {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: "/cities/" + stateId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#add-property-city").empty();
                    $("#add-property-city").append(
                        '<option value="">Select City</option>'
                    );
                    $.each(data, function (key, value) {
                        $("#add-property-city").append(
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
            $("#add-property-city").empty();
            $("#add-property-city").append(
                '<option value="">Select City</option>'
            );
        }
    });

    $("#add-property-city").on("change", function () {
        var cityid = $(this).val();
        if (cityid) {
            $.ajax({
                url: "/getstate-city-name/" + cityid,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#filledcity").val(data.city_name);
                    $("#filledstate").val(data.state_name);
                    $("#fillstateid").val(data.state_id);
                    $("#filledcityid").val(cityid);
                },
            });
        } else {
            $("#add-property-city").empty();
            $("#add-property-city").append(
                '<option value="">Select City</option>'
            );
        }
    });

    $("#advsearchstate").on("change", function () {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: "/cities/" + stateId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#advsearchcity").empty();
                    $("#advsearchcity").append(
                        '<option value="">Select City</option>'
                    );
                    $.each(data, function (key, value) {
                        $("#advsearchcity").append(
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
            $("#advsearchcity").empty();
            $("#advsearchcity").append('<option value="">Select City</option>');
        }
    });

    $("#addtofavorite").on("click", function (e) {
        e.preventDefault();
        var propertyId = $(this).val();

        $.ajax({
            url: "/add-to-favorite",
            method: "POST",
            data: {
                propertyId: propertyId, // Send propertyId as data in the request
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var $filledHeartIcon = $("#addtofavorite .bi-heart-fill");
                var $outlineHeartIcon = $("#addtofavorite .bi-heart");
                if (response.error) {
                    toastr.warning("Property removed from Favorite List !");
                    $filledHeartIcon.hide();
                    $outlineHeartIcon.show();
                } else {
                    toastr.success("Property added in Favorite List !");
                    $filledHeartIcon.show();
                    $outlineHeartIcon.hide();
                }
            },
            error: function (xhr, status, error) {
                console.error("An error occurred: " + error);
            },
        });
    });

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


    $("#quicksearchstate").on("change", function () {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: "/cities/" + stateId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#quicksearchcity").empty();
                    $("#quicksearchcity").append(
                        '<option value="">Select City</option>'
                    );
                    $.each(data, function (key, value) {
                        $("#quicksearchcity").append(
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
            $("#quicksearchcity").empty();
            $("#quicksearchcity").append(
                '<option value="">Select City</option>'
            );
        }
    });

    $("#example").DataTable();

    $("#propertyEditForm").submit(function (e) {
        var propertyId = $("#editpropertyId").val();
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "/edit-property-details/" + propertyId,
            type: "POST",
            data: formData,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $("#formMessage").html("<p>Updating, please wait...</p>");
            },
            success: function (response) {
                toastr.success(response.message);
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error(
                        "Failed to update property additional details."
                    );
                }
            },
        });
    });

    $("#date_filter").on("change", function (e) {
        e.preventDefault();
        var searchText = $("#date_filter").val().trim();
        var formData = $(this).serialize();
        console.log("check search Text", searchText);

        $.ajax({
            url: "list-properties",
            method: "get",
            data: {
                last_month: searchText,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log("==>", response);
                if (response.html == "") {
                    $("#notFoundMessage").show();
                } else {
                    $("#propertyGrid").html(response.html);
                    $("#notFoundMessage").hide();
                    if (response.pagination == "") {
                        $("#pagination").hide();
                    } else {
                        $("#pagination").show();
                    }
                }
                // if (response.data.length > 0) {
                //     console.log(" ====== +++",response.html);
                //     // $("#propertyGrid").html(response.html);
                //     // $("#notFoundMessage").hide();
                // } else {
                //     $("#propertyGrid").html("");
                //     $("#notFoundMessage").show();
                // }
            },
            error: function (xhr) {
                console.error(
                    "Error fetching search results:",
                    xhr.responseText
                );
                $("#propertyGrid").html(
                    "<p>An error occurred while searching. Please try again.</p>"
                );
            },
        });
    });



    $("#submitContactForm").on("click", function (e) {
        var formData = new FormData($("#contactForm")[0]);
        e.preventDefault();
        $.ajax({
            url: "/submit-contact-us",
            type: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".send-btn").html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                );
                $(".send-btn").prop("disabled", true);
            },
            success: function (response) {
                if (response.success) {
                    $("#contactForm")[0].reset();
                    toastr.success("Form Submitted successfully!");
                    $(".send-btn").html(`Submit`);
                    $(".send-btn").prop("disabled", false);
                }
            },
            error: function (xhr) {
                $(".send-btn").html(`Submit`);
                $(".send-btn").prop("disabled", false);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $("#" + key).after(
                            '<div class="error-message" style="color:red;">' +
                            value[0] +
                            "</div>"
                        );
                    });
                    toastr.warning("Form Not Submitted");
                } else {
                    toastr.warning("Form Not Submitted");
                }
            },
        });
    });
});

$(document).ready(function () {
    const startYear = 1900;
    const currentYear = new Date().getFullYear();
    var selectedYear = $("#yearbuildvalue").val();
    var selectedRemodeledYear = $("#yearremodeledvalue").val();

    for (let year = currentYear; year >= startYear; year--) {
        if (year == selectedYear) {
            $("#year-select").append(new Option(year, year, true, true));
        } else {
            $("#year-select").append(new Option(year, year));
        }
    }

    for (let year = currentYear; year >= startYear; year--) {
        if (year == selectedRemodeledYear) {
            $("#year-remodeled").append(new Option(year, year, true, true));
        } else {
            $("#year-remodeled").append(new Option(year, year));
        }
    }
});

$(document).ready(function () {
    $(".summer_note").summernote();

    $("#add_row").on("click", function () {
        var html = "";
        html += '<div  id="remove">';
        html += '<div class="medicine_row_input">';

        html += '<input type="date" name="name[]">';
        html +=
            '<button type="button" id="removeRow" ><i class="fas fa-trash" aria-hidden="true"></i></button>';
        html += "</div>";
        html += "</div>";
        $("#medicine_row").append(html);
    });

    $(document).on("click", "#removeRow", function () {
        $(this).closest("#remove").remove();
    });
});

$(document).ready(function () {
    // $("#uploadImageForm").on("submit", function (e) {
    //     e.preventDefault();
    //     var formData = new FormData(this);
    //     $.ajax({
    //         url: "/upload-image",
    //         method: "POST",
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function (response) {
    //             toastr.success(response.success);
    //             $("#uploadImageForm")[0].reset();
    //         },
    //         error: function (xhr) {
    //             toastr.error("There is some error with Image Uploading.");
    //             var errorMessage =
    //                 '<div class="alert alert-danger">Failed to upload image. Please try again.</div>';
    //             $("#successMessage").html(errorMessage);
    //         },
    //     });
    // });
});

$(document).ready(function () {
    $(document).on("click", ".delete-gllry-img", function (e) {
        e.preventDefault();
        var galleryDetailId = $(this).data("id");
        var propertyId = $(this).data("value");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/delete-gallery-image/" + galleryDetailId,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: {
                        propertyId: propertyId,
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                "Deleted!",
                                "Your image has been deleted.",
                                "success"
                            );
                            location.reload();
                        } else {
                            Swal.fire(
                                "Error!",
                                "There was an issue deleting the image.",
                                "error"
                            );
                        }
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Error!",
                            "There was an issue deleting the image.",
                            "error"
                        );
                    },
                });
            }
        });
    });
});

$(document).on("click", ".ajax-pagination a", function (event) {
    event.preventDefault();
    var page = $(this).attr("href").split("page=")[1];

    fetchPage(page);
});

function fetchPage(page) {
    $.ajax({
        url: "?page=" + page,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $("#propertyGrid").html(response.html);
            $("#pagination").html(response.pagination);
        },
        error: function () {
            console.error("Failed to fetch data");
        },
    });
}

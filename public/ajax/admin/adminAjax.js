$(document).ready(function () {
    $(".toggle-status").on("change", function () {
        const imageId = $(this).data("id");
        const isActive = $(this).is(":checked") ? 1 : 0;

        $.ajax({
            url: `/admin/settings/slider-status/${imageId}`,
            type: "POST",
            data: {
                is_active: isActive,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                console.log(" Please Fix This ==>", data);
                if (data.success) {
                    toastr.success("Slider Status updated successfully!");
                }
            },
            error: function (xhr, status, error) {
                toastr.error("Slider Status Not Updated");
            },
        });
    });

    /*
    $(function () {
        try {
            $("#listofmanagers").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/resources/list-manager",
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "managername",
                        name: "managername",
                    },
                    { data: "status", name: "status" },
                    { data: "action", name: "action" },
                ],
            });
        } catch (err) {
            console.log("err", err);
        }
    });
    */

    /*
    $(function () {
        try {
            $("#add-admin-agents").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/administration/manage-my-agents",
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "username",
                        name: "username",
                    },
                    { data: "userloginid", name: "userloginid" },
                    { data: "edit", name: "edit" },
                ],
            });
        } catch (err) {
            console.log("err", err);
        }
    });
    */

    /*
    $(function () {
        try {
            $("#manage-source").DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: `/admin/administration/manage-source`,
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "sourcename",
                        name: "sourcename",
                    },
                    {
                        data: "actions",
                        name: "actions",
                    },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });
    */

    $(function () {
        try {
            $("#specialtable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/specials",
                columns: [
                    { data: "DT_RowIndex", name: "DT_RowIndex" },
                    { data: "propertyname", name: "propertyname" },
                    { data: "special", name: "special" },
                    { data: "date", name: "date" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    /*
    $(function () {
        try {
            $("#citymanagement").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/property/manage-city",
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "cityname",
                        name: "cityname",
                    },
                    {
                        data: "statename",
                        name: "statename",
                    },
                    {
                        data: "actions",
                        name: "actions",
                    },
                ],
            });
        } catch (err) {
            console.log("err", err);
        }
    });
    */

    // ajax embroidery
    $(function () {
        var table = $("#admin-order").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa-solid fa-chevron-right"></i>', // or '→'
                    previous: '<i class="fa-solid fa-chevron-left"></i>', // or '←'
                },
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{__('routes.admin-view-orders')}}",
                data: function (d) {
                    d.status_filter = $("#status-filter").val();
                    d.category_filter = $("#category-filter").val();
                },
            },
            columns: [
                {
                    data: "id",
                    name: "id",
                },
                {
                    data: "project_name",
                    name: "project_name",
                },
                {
                    data: "user",
                    name: "user",
                },
                {
                    data: "date",
                    name: "date",
                },
                {
                    data: "status",
                    name: "status",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ],
        });
        $("#status-filter, #category-filter").change(function () {
            table.ajax.reload();
        });
    });

    $(function () {
        try {
            $("#showalltable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/show-all",
                columns: [
                    { data: "firstname", name: "firstname" },
                    { data: "lastname", name: "lastname" },
                    { data: "emovedate", name: "emovedate" },
                    { data: "lmovedate", name: "lmovedate" },
                    { data: "probability", name: "probability" },
                    { data: "view", name: "view" },
                    { data: "edit", name: "edit" },
                    { data: "delete", name: "delete" },
                    { data: "status", name: "status" },
                    { data: "remainderdate", name: "remainderdate" },
                    { data: "admin", name: "admin" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    $(function () {
        try {
            $("#showdeadtable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/show-all",
                columns: [
                    { data: "sl", name: "sl" },
                    { data: "propertyname", name: "propertyname" },
                    { data: "special", name: "special" },
                    { data: "date", name: "date" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    /*
    $(function () {
        try {
            $("#UnassignedrentersTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/unassigned-renters",
                columns: [
                    { data: "CreatedOn", name: "CreatedOn" },
                    { data: "Name", name: "Name" },
                    { data: "probability", name: "probability" },
                    { data: "Bedroom", name: "Bedroom" },
                    { data: "Rent", name: "Rent" },
                    { data: "Reminder", name: "Reminder" },
                    { data: "Move", name: "Move" },
                    { data: "Area", name: "Area" },
                    { data: "Claim", name: "Claim" },
                    { data: "Edit", name: "Edit" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });
    */

    $(function () {
        try {
            $("#renterInfoUpdateHistory").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/client/renter-info-update-history",
                columns: [
                    { data: "selectbox", name: "selectbox" },
                    { data: "name", name: "name" },
                    { data: "adminname", name: "adminname" },
                    { data: "updateOn", name: "updateOn" },
                    { data: "delete", name: "delete" },
                    { data: "view", name: "view" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    $(document).on("click", ".property-delete-btn", function () {
        var id = $(this).data("id");
        console.log("checkId", id);
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/school-management/" + id,
                    method: "Post",
                    success: function (response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function () {
                        toastr.error(
                            "An error occurred while deleting the record."
                        );
                    },
                });
            }
        });
    });

    $(document).on("click", ".propertyDlt", function () {
        var id = $(this).data("id");
        var url = $(this).data("url");
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function () {
                        toastr.error(
                            "An error occurred while deleting the record."
                        );
                    },
                });
            }
        });
    });

    /*
    $(function () {
        const id = $("#favoritetab").data("id");
        try {
            $("#favorite-listing").DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: `/admin/client/favorite-listing/${id}`,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    { data: "propertyName", name: "propertyName" },
                    { data: "city", name: "city" },
                    { data: "state", name: "state" },
                    { data: "action", name: "action" },
                    { data: "notify", name: "notify" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });
    */

    $(".add-fav").click(function () {
        var id = $(this);
        var renterId = id.data("renter-id");
        var propertyId = id.data("property-id");
        $.ajax({
            url: "/admin/property/add-favorite",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                renterId: renterId,
                propertyId: propertyId,
            },
            success: function (response) {
                const favoriteIcon = $("#isfav");
                if (response.status == true) {
                    favoriteIcon.addClass("favorited");
                } else {
                    favoriteIcon.removeClass("favorited");
                }
            },
            error: function (xhr) {
                console.log("Error:", xhr);
            },
        });
    });

    $(function () {
        try {
            $("#callhistory").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/client/call-history",
                columns: [
                    { data: "selectall", name: "selectall" },
                    { data: "propertyname", name: "propertyname" },
                    { data: "caller", name: "caller" },
                    { data: "datetime", name: "datetime" },
                    { data: "recording", name: "recording" },
                    { data: "callduration", name: "callduration" },
                    { data: "direction", name: "direction" },
                    { data: "status", name: "status" },
                    { data: "actions", name: "actions" },
                ],
            });
        } catch (err) {
            console.log("Err in datatables", err);
        }
    });

    $("#select-state").on("change", function () {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: "/admin/cities/" + stateId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#select-city").empty();
                    $("#select-city").append(
                        '<option value="">Select City</option>'
                    );
                    $.each(data, function (key, value) {
                        $("#select-city").append(
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
            $("#select-city").empty();
            $("#select-city").append('<option value="">Select City</option>');
        }
    });

    $("#cityform").on("submit", function (event) {
        event.preventDefault();
        var stateId = $("#stateid").val().trim();
        var cityname = $("#cityname").val().trim();
        var cityrent = $("#cityrent").val().trim();
        var shortname = $("#shortname").val().trim();
        if (stateId === "" || cityname === "" || shortname === "") {
            event.preventDefault();
            alert("Please fill out all required fields.");
        }

        var formData = $(this).serialize();
        $.ajax({
            url: "/admin/property/add-cities",
            method: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                toastr.success(response.message);
            },
            error: function (response) {
                console.log("===>", response);
                toastr.error(response.responseJSON.error);
            },
        });
    });

    $("#username").select2({
        placeholder: "- SELECT USERNAME -",
        allowClear: true,
    });

    $("#openChatBtn").on("click", function () {
        alert("ddd");
        var propertyId = $(this).data("id");
        var renterId = $(this).data("renterid");
        $.ajax({
            url: "/admin/get-messages",
            type: "get",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                propertyId: propertyId,
                renterId: renterId,
            },
            success: function (response) {
                const favoriteIcon = $("#isfav");
                if (response.status == true) {
                    favoriteIcon.addClass("favorited");
                } else {
                    favoriteIcon.removeClass("favorited");
                }
            },
            error: function (xhr) {
                console.log("Error:", xhr);
            },
        });
        $("#offcanvasChat").addClass("open");
    });

    $("#closeChatBtn").on("click", function () {
        $("#offcanvasChat").removeClass("open");
    });

    $("#sendMessageBtn").on("click", function () {
        const messageText = $("#messageInput").val().trim();
        if (messageText) {
            const messageElem = $('<div class="message receiver"></div>').text(
                messageText
            );
            $(".chat-window").append(messageElem);
            $("#messageInput").val("").focus();
        }
    });
});

$(document).ready(function () {
    $(".state-checkbox").on("change", function () {
        var selectedStates = [];
        $(".state-checkbox:checked").each(function () {
            selectedStates.push($(this).val());
        });
        if (selectedStates.length === 0) {
            $("#city-section").empty();
            return;
        }
        $.ajax({
            url: `/admin/get-cities`,
            method: "POST",
            data: {
                stateIds: selectedStates,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $("#city-section").empty();
                $.each(response.cities, function (index, city) {
                    $("#city-section").append(
                        '<div class="col-md-2">' +
                        '<label class="ckbox">' +
                        '<input type="checkbox" value="' +
                        city.Id +
                        '" name="admincity[]">' +
                        '<span class="font-weight-bold">' +
                        city.CityName +
                        "</span>" +
                        "</label>" +
                        "</div>"
                    );
                });
            },
        });
    });

    loadSelectedStates();

    function loadSelectedStates() {
        var selectedStates = [];
        $(".edit-state-checkbox:checked").each(function () {
            selectedStates.push($(this).val());
        });

        if (selectedStates.length > 0) {
            fetchCities(selectedStates);
        }
    }

    function fetchCities(stateIds) {
        $.ajax({
            url: "/admin/get-cities",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                stateIds: stateIds,
            },
            success: function (response) {
                $("#city-section").empty();
                $.each(response.cities, function (index, city) {
                    $("#city-section").append(
                        '<div class="col-md-2">' +
                        '<label class="ckbox">' +
                        '<input type="checkbox" value="' +
                        city.id +
                        '">' +
                        '<span class="font-weight-bold">' +
                        city.CityName +
                        "</span>" +
                        "</label>" +
                        "</div>"
                    );
                });
            },
            error: function () {
                alert("Error retrieving cities.");
            },
        });
    }
});

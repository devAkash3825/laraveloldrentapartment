$(document).on("click", ".list_more_calendar", function () {
    if (
        $(this)
            .closest(".badge_text")
            .closest(".fc-event-main")
            .parent()
            .children("div")
            .hasClass("list_more_calendar--con")
    ) {
        $(".list_more_calendar--con").remove();
    } else {
        var post_id = $(this).data("edit-id");
        var reschedule_img_url = $(this).data("reschedule-img-url");
        var delete_url = $(this).data("delete-url");
        var delete_img_url = $(this).data("delete-img-url");
        var edit_img_url = $(this).data("editimag-url");
        var edit_title = $(this).data("edit-title");
        var edit_url = $(this).data("edit-url");
        var html =
            '<div class="list_more--con active list_more_calendar--con">' +
            '<a href="' +
            edit_url +
            '" title="' +
            edit_title +
            '" class="edit-post-link mtitle mr-1" data-postid = "' +
            post_id +
            '">' +
            '<img src="https://app.dotsimple.io/assets/images/On.svg">' +
            "Edit" +
            "</a>" +
            '<a href="javascript:void(0);" class="edit-post-link" data-postid = "' +
            post_id +
            '">' +
            '<img src="' +
            reschedule_img_url +
            '" alt="">' +
            "Reschedule" +
            "</a>" +
            '<a href="' +
            delete_url +
            '">' +
            '<img src="' +
            delete_img_url +
            '" alt="" style="margin-left:4px;">' +
            "Delete" +
            "</a>" +
            "</div>";
        $(this)
            .closest(".badge_text")
            .closest(".fc-event-main")
            .parent()
            .prepend(html);
    }
});
$(document).on("click", "#mylist_coll--btn", function () {
    $(".si__post--list").toggleClass("grid_view");
    $(this).toggleClass("active");
});
$(document).on("click", ".approvepostId", function () {
    var id = $(this).data("id");
    $(".postid").attr(
        "href",
        buildLink("calendar/queue/approve-rsspost/" + id + "/rss")
    );
    $("#approvepost").modal("show");
});
$(document).on("click", ".rejectpostId", function () {
    var id = $(this).data("id");
    $(".rejectid").attr(
        "href",
        buildLink("calendar/queue/reject-rsspost/" + id + "/rss")
    );
    $("#rejectpost").modal("show");
});
$(document).on("click", ".fc-prev-button", function () {
    console.log("today");
    $(".fc-today-button").show();
});
$(document).on("click", ".fc-next-button", function () {
    console.log("today");
    $(".fc-today-button").show();
});
$(document).on("click", ".fc-dayGridMonth-button", function (e) {
    // if(!$('.need_approve').hasClass('active')){
    //     $('.need_approve').addClass('d-none')
    // }
    // if(!$('.show_draft').hasClass('active')){
    //     $('.show_draft').addClass('d-none')
    // }

    pageLoader(true);
    $(".wrap_div").hide();
    $(".wrap_div").addClass("hidden");
    $(".wrap_div").removeClass("show");

    $("#list-view").hide();

    $(".fc-today-button").show();

    $(".fc-toolbar-title").show();

    $(".fc-prev-button").show();

    $(".fc-next-button").show();

    $(".fc-today-button").show();

    $("#calendar").css("height", "-webkit-fill-available");
    $("#mylist_coll--btn").css("display", "none");
    window.calendar.refetchEvents();
    pageLoaded();
});
$(document).on("click", ".fc-timeGridWeek-button", function (e) {
    // if(!$('.need_approve').hasClass('active')){
    //     $('.need_approve').addClass('d-none')
    // }
    // if(!$('.show_draft').hasClass('active')){
    //     $('.show_draft').addClass('d-none')
    // }
    pageLoader(true);
    $(".wrap_div").hide();
    $(".wrap_div").addClass("hidden");
    $(".wrap_div").removeClass("show");

    $("#list-view").hide();

    $(".fc-today-button").show();

    $(".fc-toolbar-title").show();

    $(".fc-prev-button").show();

    $(".fc-next-button").show();

    $(".fc-today-button").show();

    $("#calendar").css("height", "-webkit-fill-available");
    $("#mylist_coll--btn").css("display", "none");

    createPostButton();
    window.calendar.refetchEvents();
    pageLoaded();
});

$(document).on("click", ".fc-timeGridDay-button", function (e) {
    // if(!$('.need_approve').hasClass('active')){
    //     $('.need_approve').addClass('d-none')
    // }
    // if(!$('.show_draft').hasClass('active')){
    //     $('.show_draft').addClass('d-none')
    // }
    pageLoader(true);
    $(".wrap_div").hide();
    $(".wrap_div").addClass("hidden");
    $(".wrap_div").removeClass("show");

    $("#list-view").hide();

    $(".fc-today-button").show();

    $(".fc-toolbar-title").show();

    $(".fc-prev-button").show();

    $(".fc-next-button").show();

    $(".fc-today-button").show();

    $("#calendar").css("height", "-webkit-fill-available");
    $("#mylist_coll--btn").css("display", "none");

    createPostButton();
    window.calendar.refetchEvents();
    pageLoaded();
});
$(document).on("click", ".fc-listWeek-button", function (e) {
    // if($(this).hasClass('fc-button-active')){
    //     $('.need_approve').removeClass('d-none')
    //     $('.show_draft').removeClass('d-none')
    // }

    pageLoader(true);
    $(".wrap_div").hide();
    $(".wrap_div").addClass("hidden");
    $(".wrap_div").removeClass("show");

    $(".fc-today-button").hide();

    $(".fc-toolbar-title").hide();

    $(".fc-prev-button").hide();

    $(".fc-next-button").hide();

    $(".fc-listWeek-view").html("");

    $("#calendar").css("height", 62);

    $("#history-calendar").css("height", 62);

    $("#list-view").css("overflow-y", "scroll");
    $("#mylist_coll--btn").css("display", "none");

    getPosts();
    if ($(".schedule__modal__form input").is(":checked")) {
        $(".edit__media--btn").click();
    }
});
$(document).on("click", ".need_approve", function (e) {
    // $('.fc-dayGridMonth-button').hide();
    // $('.fc-timeGridWeek-button').hide();
    // $('.fc-timeGridDay-button').hide();
    // getPosts();
});
if ($("#calendar").length > 0 && !$("#calendar").hasClass("fc")) {
    var firstDay = Number(startDay);
    var view = calendarviewvalue;
    var menu = "dayGridMonth,timeGridWeek,timeGridDay,listWeek";
    pageLoader();
    var calendarEl = document.getElementById("calendar");
    if (window.location.href.includes("all")) {
        var url = buildLink("bulk/getevents?all=true");
    } else if (window.location.href.includes("failed")) {
        var url = buildLink("bulk/getevents?failed=true");
    } else if (window.location.href.includes("draft")) {
        var url = buildLink("bulk/getevents?draft=true");
        view = "listWeek";
    } else if (window.location.href.includes("need-to-approve")) {
        var url = buildLink("bulk/getevents?need-to-approve=true");
        view = "listWeek";
    } else if (window.location.href.includes("history")) {
        var url = buildLink("bulk/getevents?history=true");
    } else {
        var url = buildLink("bulk/getevents");
    }
    var flag = false;
    if (
        url == buildLink("bulk/getevents?draft=true") ||
        url == buildLink("bulk/getevents?need-to-approve=true")
    ) {
        var menu = "listWeek,nobutton";
    }
    window.calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: "UTC",
        height: "100%",
        locale: locale,
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: menu,
        },
        weekday: "long",
        buttonText: {
            today: today_text,
            month: month_text,
            week: week_text,
            day: day_text,
            list: list_text,
        },
        slotLabelFormat: {
            hour: "numeric",
            hour12: Is12Hours,
        },
        firstDay: firstDay,
        customButtons: {
            prev: {
                text: perv_text,
                click: function () {
                    calendar.prev();
                    createPostButton();
                },
            },
            next: {
                text: next_text,
                click: function () {
                    calendar.next();
                    createPostButton();
                },
            },
            today: {
                text: today_text,
                click: function () {
                    calendar.today();
                    createPostButton();
                },
            },
        },
        dayMaxEventRows: 2,
        //   views: {
        //     timeGrid: {
        //       dayMaxEventRows: 2
        //     }
        //   },
        moreLinkContent: function (args) {
            return "+" + args.num + " " + more_link_text;
        },
        allDayText: all_day,
        initialView: view,
        events: {
            url: url,
            method: "POST",
            extraParams: function () {
                $(".tooltip").remove();
                const data = new FormData($(".schedule__modal__form")[0]);
                let entries = Object.fromEntries(data.entries());
                if (data.getAll("val[category][]").length)
                    entries["val[category][]"] = data
                        .getAll("val[category][]")
                        .join(",");

                if (data.getAll("val[socialAccount][]").length)
                    entries["val[socialAccount][]"] = data.getAll(
                        "val[socialAccount][]"
                    );

                if (data.getAll("val[socialType][]").length)
                    entries["val[socialType][]"] =
                        data.getAll("val[socialType][]");

                return entries;
            },
            success: function () {
                if (
                    url == buildLink("bulk/getevents?draft=true") ||
                    url == buildLink("bulk/getevents?need-to-approve=true")
                ) {
                    if (flag == false) {
                        $(".fc-listWeek-button").trigger("click");
                        flag = true;
                    }
                }
            },
            failure: function () {
                // alert('there was an error while fetching events!');
            },
            // color: 'yellow',   // a non-ajax option
            // textColor: 'black' // a non-ajax option
        },
        viewDidMount: function (content, xhr) {
            $(".tooltip").remove();
            if (
                !$(".fc-header-toolbar .fc-toolbar-chunk:last")
                    .find("a")
                    .hasClass("list_view_coll--btn")
            ) {
                var content = $("<a href='javascript:void(0);'>")
                    .addClass("list_view_coll--btn")
                    .attr("id", "mylist_coll--btn")
                    .css("display", "none");

                var image = new Image();
                image.src = buildLink("assets/images/list_view_collasped.svg");
                image.className = "in-svg";

                $(image).appendTo(content);
                $(".fc-header-toolbar .fc-toolbar-chunk:last").prepend(content);
            }
            createPostButton();
        },

        eventDidMount: function (info) {
            $(".tooltip").remove();
            $(info.el).tooltip({
                id: info.event.id,
                title: info.event.extendedProps.title_html,
                placement: "top",
                trigger: "click",
                container: "body",
                html: true,
                customClass: "tooltip__custom-class_queue",
            });
            // }).on('shown.bs.tooltip', function () {
            //     $.ajax({
            //         method: "GET",
            //         url: buildLink('bulk/gettooltipdatabyid'),
            //         data: {id : info.event.id},
            //         success: function(response) {
            //             console.log(response);
            //             response = jQuery.parseJSON(response);
            //             console.log(response);
            //             $(".si_schedule").html(response.schedule_time);
            //             $(".editPostTxt").html(response.caption)

            //         }
            //     });
            // });
            $(".fc-timegrid-col-events").each(function () {
                if (
                    $(this).children(".fc-timegrid-event-harness-inset")
                        .length >= 1
                ) {
                    $(this).addClass("fc-timegrid-width-css");
                } else {
                    $(this).removeClass("fc-timegrid-width-css");
                }
            });
            $(".fc-daygrid-event-dot").each(function () {
                $(this).parent().parent().css("display", "none");
            });
            createPostButton();
        },
        eventContent: function (arg) {
            $(".tooltip").remove();
            if (arg.view.type == "dayGridMonth") {
                // if (!arg.event.extendedProps.for_monthly_daily) {
                let italicEl = document.createElement("div");

                // if (arg.event.extendedProps.postCount) {
                // var html = `<div class='badge_text d-flex align-items-center mt-1 ${arg.event.classNames}' style="line-height:21px; height:25px;"> <div class="badge_con"><p>${arg.event.title}</p><span> +${arg.event.extendedProps.postCount}</span></div></div>`;
                // } else {
                var html = `<div class='badge_text d-flex align-items-center mt-1 ${arg.event.classNames}' style="line-height:21px; height:25px;"> <div class="badge_con"><p class="si_title_${arg.event.id}">${arg.event.title}</p><div class="event_time si_id_${arg.event.id}">${arg.event.extendedProps.timeText}</div></div></div>`;
                // }

                italicEl.innerHTML = html;
                let arrayOfDomNodes = [italicEl];
                return { domNodes: arrayOfDomNodes };
                // }
            } else if (
                arg.view.type == "timeGridWeek" ||
                arg.view.type == "timeGridDay"
            ) {
                // if (arg.view.type == 'timeGridWeek' && !arg.event.extendedProps.for_monthly_daily) {

                let italicEl1 = document.createElement("div");
                if (arg.event.classNames == "scheduled") {
                    var html1 = `<div class="badge_text d-flex align-items-center mt-1 ${
                        arg.event.classNames
                    }" style="line-height:21px;display: block !important;">
                <p style="height:16px;">${
                    arg.event.extendedProps.all_data_title
                }</p>
                <div class="daily_event--con">
                <div class="ev_time">
                <span>${arg.event.extendedProps.timeText}</span>
                </div>
                <div class="d-none">
                ${arg.event.extendedProps.account}
                </div>

                <div class="edit-ev d-flex">
                <a href="javascript:void(0)" class="list_more_calendar" data-edit-id="${
                    arg.event.extendedProps.all_data_id
                }"
                data-reschedule-img-url="${
                    arg.event.extendedProps.reschedule_img_url
                }"
                data-delete-img-url="${arg.event.extendedProps.delete_img_url}"
                data-delete-url="${arg.event.extendedProps.deleteUrl}"
                data-editimag-url="https://app.dotsimple.io/assets/images/On.svg"
                data-edit-url="${buildLink(
                    "bulk/editpost/" + arg.event.extendedProps.all_data_id + ""
                )}"
                data-edit-title='${strings.edit_post}'>
                <img src="${
                    arg.event.extendedProps.list_more_img_url
                }" class="in-svg" alt="">
                </a>
                </div>

                </div>
                </div>`;
                } else if (arg.event.classNames == "approve") {
                    var html1 = `<div class="badge_text d-flex align-items-center mt-1 ${
                        arg.event.classNames
                    }" style="line-height:21px;display: block !important;">
                <p style="height:16px;">${
                    arg.event.extendedProps.all_data_title
                }</p>
                <div class="daily_event--con">
                <div class="ev_time">
                <span>${arg.event.extendedProps.timeText}</span>
                </div>
                <div class="d-none">
                ${arg.event.extendedProps.account}
                </div>

                <div class="edit-ev d-flex">
                <a href=${buildLink(
                    "bulk/editpost/" + arg.event.extendedProps.all_data_id + ""
                )} title='${
                        strings.edit_post
                    }' class='edit-post-link mtitle mr-1' data-postid = '${
                        arg.event.extendedProps.all_data_id
                    }'>
                <img src="https://i.ibb.co/n7JJ0HX/edit.png"></a>
                <a href="${arg.event.extendedProps.deleteUrl}" title='${
                        strings.delete_post
                    }' class='mtitle'>
                <img src="${arg.event.extendedProps.delete_img_url}"></a>
                </div>

                </div>
                </div>`;
                } else if (arg.event.classNames == "failed") {
                    var html1 = `<div class="badge_text d-flex align-items-center mt-1 ${
                        arg.event.classNames
                    }" style="line-height:21px;display: block !important;">
                <p style="height:16px;">${
                    arg.event.extendedProps.all_data_title
                }</p>
                <div class="daily_event--con">
                <div class="ev_time">
                <span>${arg.event.extendedProps.timeText}</span>
                </div>
                <div class="d-none">
                ${arg.event.extendedProps.account}
                </div>

                <div class="edit-ev">
                <a href=${buildLink(
                    "bulk/editpost/" + arg.event.extendedProps.all_data_id + ""
                )} title='${
                        strings.edit_post
                    }' class='edit-post-link mtitle' data-postid = '${
                        arg.event.extendedProps.all_data_id
                    }'>
                <img src="https://i.ibb.co/n7JJ0HX/edit.png"></a>
                </div>

                </div>
                </div>`;
                } else if (arg.event.classNames == "live") {
                    var html1 = `<div class="badge_text d-flex align-items-center mt-1 ${arg.event.classNames}" style="line-height:21px;display: block !important;">
                <p style="height:16px;">${arg.event.extendedProps.all_data_title}</p>
                <div class="daily_event--con">
                <div class="ev_time">
                <span>${arg.event.extendedProps.timeText}</span>
                </div>
                <div class="d-none">
                ${arg.event.extendedProps.account}
                </div>
                </div>
                </div>`;
                }

                italicEl1.innerHTML = html1;
                let arrayOfDomNodes1 = [italicEl1];
                return { domNodes: arrayOfDomNodes1 };
                //}
            } else if (arg.view.type == "listWeek") {
                pageLoader(true);

                $(".fc-today-button").hide();

                $(".fc-toolbar-title").hide();

                $(".fc-prev-button").hide();

                $(".fc-next-button").hide();

                $(".fc-listWeek-view").html("");

                $("#calendar").css("height", 62);

                $("#history-calendar").css("height", 62);

                $("#list-view").css("overflow-y", "scroll");
                $("#mylist_coll--btn").css("display", "none");

                getPosts();
                if ($(".schedule__modal__form input").is(":checked")) {
                    $(".edit__media--btn").click();
                }
                $(document).on("click", ".need_approve", function (e) {
                    // $('.fc-dayGridMonth-button').hide();
                    // $('.fc-timeGridWeek-button').hide();
                    // $('.fc-timeGridDay-button').hide();
                    // getPosts();
                });
            }
        },
        loading: function (bool) {
            if (bool) {
                // alert('I am populating the calendar with events');
            } else {
                pageLoaded();
            }
        },

        //   validRange: function(nowDate){
        //     return {start: nowDate} //to prevent anterior dates
        //   },
    });
    calendar.render();
    $(".fc-dayGridMonth-button").parent().addClass("wrap_div");
    $(".wrap_div").wrap("<div class='new-wrapper'></div>");
    $(".wrap_div").hide();
    $(".wrap_div").addClass("hidden");
    var html =
        '<button href="#" role="button" data-value="" class="select-dropdown__button"><span>SELECT ITEMS </span> <i class="zmdi zmdi-chevron-down"></i></button>';
    $(".new-wrapper").parent().append(html);
    $(".fc-" + view + "-button").trigger("click");
    $(".select-dropdown__button span").text(
        $(".fc-" + view + "-button").html()
    );
    $(".select-dropdown__button").on("click", function () {
        if ($(".wrap_div").hasClass("hidden")) {
            $(".wrap_div").show();
            $(".wrap_div").addClass("show");
            $(".wrap_div").removeClass("hidden");
        } else {
            $(".wrap_div").hide();
            $(".wrap_div").addClass("hidden");
            $(".wrap_div").removeClass("show");
        }
    });
    $(".wrap_div .fc-button-primary").on("click", function () {
        var itemValue = $(this).data("value");
        console.log(itemValue);
        $(".select-dropdown__button span")
            .text($(this).text())
            .parent()
            .attr("data-value", itemValue);
        $(".select-dropdown__list").toggleClass("active");
    });

    function triggerListWeek() {
        pageLoader(true);
        $(".fc-today-button").hide();

        $(".fc-toolbar-title").hide();

        $(".fc-prev-button").hide();

        $(".fc-next-button").hide();

        $(".fc-listWeek-view").html("");

        $("#calendar").css("height", 62);

        $("#history-calendar").css("height", 62);

        $("#list-view").css("overflow-y", "scroll");
        $("#mylist_coll--btn").css("display", "none");

        getPosts();
        if ($(".schedule__modal__form input").is(":checked")) {
            $(".edit__media--btn").click();
        }
    }
    pageLoaded();
}
function getPosts() {
    var url = buildLink("bulk/getallposts");
    if (window.location.href.includes("all")) {
        url = buildLink("bulk/getallposts?all=true");
    } else if (window.location.href.includes("failed")) {
        url = buildLink("bulk/getallposts?failed=true");
    } else if (window.location.href.includes("draft")) {
        url = buildLink("bulk/getallposts?draft=true");
    } else if (window.location.href.includes("need-to-approve")) {
        url = buildLink("bulk/getallposts?need-to-approve=true");
    } else if (window.location.href.includes("history")) {
        url = buildLink("bulk/getallposts?history=true");
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function (result) {
            if (result != 0) {
                var json = jQuery.parseJSON(result);
                $("#list-view").remove();
                $(".post-container").append(json.content);
                $("#list-view").show();
                reloadInit();
                pageLoaded();
            }
        },
    });
}

$(document).on("click", ".create-post-link", function (e) {
    let c_date = $(this).attr("data-date");

    pageLoader(true);

    $.ajax({
        url: buildLink("bulk/getaddpostform?date=" + c_date),
        //url: buildLink('bulk/getaddpostform'),
        type: "GET",
        success: function (result) {
            if (result != 0) {
                var json = jQuery.parseJSON(result);
                $(".add-post-modal-body").html("");
                $(".add-post-modal-body").prepend(json.content);
                $(".edit-post-modal-body").html("");
                $("#AddPostModal").modal("show");
                $("#AddPostModal").addClass("addpost__modal--popup");
                $(".add-Post-Model-Overlay").show();
                reloadInit();
                refereshPreview();
                pageLoaded();
                // reloadInit('notrender-calendar');
                // refereshPreview();
                // $('.datepicker-input-time').val(date);
            }
        },
    });
    pageLoaded();
});

$(document).on("click", ".si__add_media--btn .btn", function () {
    $(this).parents().find(".modal-content").addClass("post_overlay");
});
$(document).on(
    "click",
    ".si__cancel-back--btn, .si__add_media--btn .btn",
    function () {
        $(this).parents().find(".modal-content").removeClass("post_overlay");
    }
);

$(document).on("click", ".AddPostModalCloseBtn", function () {
    $("#AddPostModal").modal("hide");
    $(".add-Post-Model-Overlay").hide();
    $(".modal-backdrop").hide();

    reloadInit();
    refereshPreview();
});

$("body").on("shown.bs.modal", "#AddPostModal", function (e) {
    // $(".add-Post-form").trigger("reset");
    // $(".add-post-modal-body").html('');
    $(".add-Post-Model-Overlay").show();

    pageLoaded();
});

$("body").on("hidden.bs.modal", "#AddPostModal", function (e) {
    $(".add-Post-Model-Overlay").hide();
    $(".modal-backdrop").hide();

    reloadInit();
    refereshPreview();
});

$(document).on("click", ".edit-post-link", function (e) {
    pageLoader(true);

    //  $(".edit-post-modal").trigger("reset");

    var postId = $(this).data("postid");

    $.ajax({
        url: buildLink("bulk/getpostdata"),
        type: "POST",
        data: {
            postId: postId,
        },
        success: function (result) {
            if (result != 0) {
                var json = jQuery.parseJSON(result);
                $(".edit-post-modal-body").html("");
                $(".edit-post-modal-body").prepend(json.content);
                $(".add-post-modal-body").html("");
                $("#EditPostModal").modal("show");
                $("#EditPostModal").addClass("addpost__modal--popup");
                $(".edit-Post-Model-Overlay").show();
                reloadInit();
                finilizeSelectedAccounts();
                refereshPreview();
                var medias = getPostHasMedia();
                changePublishButtonColor(window.currentTypes, medias);
                pageLoaded();
            }
        },
    });
});

$(document).on("click", ".EditPostModalCloseBtn", function () {
    $("#EditPostModal").modal("hide");
    $(".edit-post-modal-body").html("");
    $(".edit-Post-Model-Overlay").hide();
});

$("body").on("shown.bs.modal", "#EditPostModal", function (e) {
    $(".edit-Post-Model-Overlay").show();

    pageLoaded();
});

$("body").on("hidden.bs.modal", "#EditPostModal", function (e) {
    //returnGotoDate();
    $(".edit-post-modal-body").html("");
    // reloadInit();
    // refereshPreview();
    $(".edit-Post-Model-Overlay").hide();
});

function createPostButton() {
    $(".fc-daygrid-day.fc-day-future").each(function () {
        if (!$(this).hasClass("fc-day-disabled")) {
            var date = $(this).data("date");
            var dateSplit = date.split("-");
            var month = parseInt(dateSplit[1]);
            var day = parseInt(dateSplit[2]);
            var year = dateSplit[0];
            date = month + "/" + day + "/" + year;
            if ($(this).find(".create-post-link").length < 1)
                $(this).append(
                    "<a href='" +
                        buildLink("newpost") +
                        "' title='" +
                        strings.create_new_post +
                        "' data-date='" +
                        date +
                        "' class='create-post-link mtitle' ><i class=\"las la-plus-circle\"></i></a>"
                );
        }
    });
    $(".fc-daygrid-day.fc-day-today").each(function () {
        if (!$(this).hasClass("fc-day-disabled")) {
            var date = $(this).data("date");
            var dateSplit = date.split("-");
            var month = parseInt(dateSplit[1]);
            var day = parseInt(dateSplit[2]);
            var year = dateSplit[0];
            date = month + "/" + day + "/" + year;
            if ($(this).find(".create-post-link").length < 1)
                $(this).append(
                    "<a href='" +
                        buildLink("newpost") +
                        "' title='" +
                        strings.create_new_post +
                        "' data-date='" +
                        date +
                        "' class='create-post-link mtitle' ><i class=\"las la-plus-circle\"></i></a>"
                );
        }
    });
    $(".fc-timegrid-slot-lane").each(function () {
        var date = $(".fc-daygrid-day").data("date");
        var time = $(this).data("time");
        if (date != undefined || date == "") {
            var dateSplit = date.split("-");
            var month = parseInt(dateSplit[1]);
            var day = parseInt(dateSplit[2]);
            var year = dateSplit[0];
            date = month + "/" + day + "/" + year;
            var asset_design_btn = "";
            if (has_permission_designer == 1) {
                asset_design_btn =
                    '<a href="' +
                    buildLink("studio") +
                    '">' +
                    create_designer +
                    "</a>";
            }
            var html =
                '<a href="' +
                buildLink("newpost") +
                '" data-date="' +
                date +
                '" data-time="' +
                time +
                '" class="create-post-popup" style="display:contents;" >' +
                '<i class="las la-plus-circle"></i>' +
                "</a>" +
                '<div class="list_more--con list_more_post--con">' +
                '<a href="' +
                buildLink("newpost") +
                '" data-date="' +
                date +
                '" data-time="' +
                time +
                '" class="create-post-link">' +
                create_post +
                "</a>" +
                asset_design_btn +
                "</div>";
            if ($(this).find(".create-post-link").length < 1)
                $(this).append(html);
        }
    });

    $(".create-post-link").each(function () {
        if ($(this).data("tippy") === undefined) {
            tippy(".mtitle", {
                animation: "shift-toward",
                arrow: true,
            });
        }
    });
    $(".edit-post-link").each(function () {
        if ($(this).data("tippy") === undefined) {
            tippy(".mtitle", {
                animation: "shift-toward",
                arrow: true,
            });
        }
    });
}
$(document).on("click", ".edit-post-txt", function () {
    if ($(".fc-button-active").hasClass("fc-listWeek-button")) {
        var queue_id = $(this).data("id");
        var editPostTxt = $(this).attr("data-caption");
    } else {
        var editPostTxt = $(".editPostTxt").html();
        var queue_id = $(".si_queue_id").html();
    }
    // alert(queue_id);
    $.ajax({
        url: buildLink("bulk/editpostAllCaption"),
        type: "POST",
        data: {
            // 'editPostTxtval':editPostTxtval,
            queue_id: queue_id,
        },
        success: function (result) {
            var r = jQuery.parseJSON(result);
            var resultCount = Object.keys(r).length;
            // $('.editPostTxtval')[0].emojioneArea.setText(editPostTxt)
            // $('.editPostTxtId').val(queue_id);
            $("#edit-post-txt-modal").modal("show");
            var accordionItem = $(".accordion-item"); // Assuming jQuery is used
            $(".accordion-item").hide();
            for (var i = 0; i < resultCount; i++) {
                var key = Object.keys(r)[i];
                if ($(".accordion-item").hasClass(key)) {
                    $("." + key).show();
                    $(".editPostTxtId").val(queue_id);
                    $(".typ" + key).val(key);
                    $(".txt" + key)[0].emojioneArea.setText(r[key]);
                    // alert(key);
                }
                // alert("check console");
                // var uniqueId = 'collapse_' + i;  // Generate a unique ID
                var uniqueId = key; // Generate a unique ID

                // var htmlToAppend = `
                //     <h2 class="accordion-header" id="heading_${i}">
                //         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#${uniqueId}" aria-expanded="true" aria-controls="${uniqueId}" onclick="toggleAccordion(this, '${uniqueId}')">${key}</button>
                //     </h2>
                //     <div id="${uniqueId}" class="accordion-collapse collapse show" aria-labelledby="heading_${i}" data-bs-parent="#accordionExample">
                //         <div class="accordion-body">
                //             <div class="col-md-8 si_edit_caption_emojione">
                //                 <a href="javascript:void(0);" id="render_emoji">
                //                     <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22"
                //                         fill="none" class=" in-svg replaced-svg">
                //                         <g clip-path="url(#clip0_51172_21370)">
                //                             <path
                //                                 d="M11.5 2C9.81927 2 8.17627 2.49827 6.77866 3.43184C5.38106 4.3654 4.29159 5.69234 3.64796 7.24495C3.00433 8.79756 2.83543 10.5061 3.16262 12.1547C3.48981 13.8033 4.29839 15.3178 5.48616 16.507C6.67394 17.6961 8.18759 18.5064 9.83578 18.8355C11.484 19.1646 13.1927 18.9976 14.7461 18.3558C16.2994 17.7139 17.6276 16.6259 18.5628 15.2294C19.4979 13.8329 19.9981 12.1904 20 10.5097C20.0013 9.39266 19.7824 8.28631 19.3558 7.25392C18.9292 6.22153 18.3033 5.28335 17.5138 4.49303C16.7244 3.7027 15.787 3.07572 14.7551 2.64795C13.7232 2.22018 12.6171 2 11.5 2ZM15.0117 6.45157C15.3042 6.46282 15.5867 6.56081 15.8234 6.73308C16.06 6.90536 16.24 7.14412 16.3406 7.41901C16.4411 7.69389 16.4576 7.99248 16.388 8.27677C16.3184 8.56107 16.1658 8.81824 15.9496 9.01555C15.7334 9.21287 15.4634 9.34143 15.174 9.38486C14.8845 9.4283 14.5887 9.38465 14.3241 9.25948C14.0595 9.1343 13.8381 8.93326 13.6881 8.68191C13.5381 8.43057 13.4663 8.14029 13.4817 7.848C13.5025 7.46103 13.6745 7.09773 13.9608 6.83648C14.247 6.57524 14.6245 6.43699 15.0117 6.45157ZM8.04293 6.45157C8.33514 6.45085 8.62098 6.53692 8.86421 6.69887C9.10744 6.86081 9.2971 7.09134 9.40915 7.36122C9.52119 7.63109 9.55057 7.92816 9.49356 8.21476C9.43656 8.50135 9.29572 8.76457 9.08893 8.97102C8.88213 9.17747 8.61869 9.31787 8.332 9.3744C8.04531 9.43094 7.74829 9.40107 7.4786 9.28858C7.20891 9.17609 6.9787 8.98604 6.81715 8.74255C6.65561 8.49905 6.57001 8.21307 6.57121 7.92086C6.57218 7.53094 6.72758 7.15729 7.0034 6.88169C7.27923 6.60609 7.65301 6.451 8.04293 6.45036V6.45157ZM13.9553 15.3839C13.3522 15.7537 12.6735 15.9827 11.9696 16.054C11.2657 16.1253 10.5549 16.0369 9.88985 15.7955C9.17875 15.5442 8.54216 15.1182 8.03849 14.5569C7.53481 13.9955 7.18018 13.3166 7.00714 12.5825C6.98657 12.4772 6.98952 12.3686 7.01579 12.2645C7.04206 12.1605 7.09099 12.0635 7.15909 11.9805C7.22719 11.8976 7.31278 11.8307 7.40973 11.7847C7.50668 11.7387 7.6126 11.7146 7.71993 11.7143H15.2546C15.3657 11.7149 15.4753 11.7406 15.5751 11.7895C15.675 11.8384 15.7625 11.9092 15.8311 11.9967C15.8998 12.0841 15.9478 12.1859 15.9716 12.2945C15.9954 12.4031 15.9944 12.5157 15.9686 12.6238C15.8375 13.1961 15.5914 13.7358 15.2453 14.21C14.8992 14.6843 14.4603 15.0832 13.9553 15.3826V15.3839Z"
                //                                 fill="#06152B"></path>
                //                         </g>
                //                         <defs>
                //                             <clipPath id="clip0_51172_21370">
                //                                 <rect width="17" height="17" fill="white" transform="translate(3 2)"></rect>
                //                             </clipPath>
                //                         </defs>
                //                     </svg>
                //                 </a>
                //             </div>
                //                 <input type="hidden" class="editPostTxtId" value="${queue_id}">
                //                 <textarea class="emojionearea editPostTxtval si_emoji_caption emoji-text ui-autocomplete-input" data-identifier="${uniqueId}" rows="10" cols="10" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" style="border: 1px solid #ccc;">${r[key]}</textarea>
                //         </div>
                //     </div>`;

                // Append the HTML code
                // accordionItem.append(htmlToAppend);
            }
        },
    });
});
$(document).on("click", ".edit-post-txt-sub", function () {
    var queue_id = $(".editPostTxtId").val();
    // alert(queue_id);
    var editedKeys = [];
    $(".captionType").each(function (index) {
        // alert(index + ': ' + $(this).val());
        var editedKey = $(this).val();
        // alert(editedKey);
        if (editedKey !== null && editedKey !== "") {
            editedKeys.push(editedKey);
        }
    });
    // console.log(editedKeys);

    var editedValues = [];
    $(".editPostTxtval").each(function (index) {
        // alert(index + ': ' + $(this).val());
        var editedValue = $(this).val();
        if (editedValue !== null && editedValue !== "") {
            editedValues.push(editedValue);
        }
    });
    // console.log(editedValues);

    var combinedData = {};
    // Assuming both arrays have the same length
    if (editedKeys.length === editedValues.length) {
        for (var i = 0; i < editedKeys.length; i++) {
            combinedData[editedKeys[i]] = editedValues[i];
        }

        console.log(combinedData);
    } else {
        console.error(
            "Arrays editedKeys and editedValues must have the same length"
        );
    }
    $.ajax({
        url: buildLink("bulk/editposttext"),
        type: "POST",
        data: {
            editPostTxtval: combinedData,
            queue_id: queue_id,
        },
        success: function (result) {
            console.log(result);
            $("#edit-post-txt-modal").modal("hide");
            $(".accordion-collapse").hide();
            // $(".accordion-item").html('');
            // console.log(result)
            $(".si_title_" + queue_id).html(result);
            if ($(".fc-button-active").hasClass("fc-timeGridWeek-button")) {
                $(".fc-timeGridWeek-button").trigger("click");
            } else if (
                $(".fc-button-active").hasClass("fc-timeGridDay-button")
            ) {
                $(".fc-timeGridDay-button").trigger("click");
            } else if (
                $(".fc-button-active").hasClass("fc-dayGridMonth-button")
            ) {
                $(".fc-dayGridMonth-button").trigger("click");
            } else if ($(".fc-button-active").hasClass("fc-listWeek-button")) {
                $(".fc-listWeek-button").trigger("click");
                // $(".si_list_caption_"+queue_id).html(result);
                // $(".si_edit_cap_"+queue_id).attr("data-caption",result);
            }
        },
    });
    // });
});
// js for calendar module
$(document).on("click", ".si_edit_publish_date", function () {
    if ($(".fc-button-active").hasClass("fc-listWeek-button")) {
        var queue_id = $(this).data("id");
        var s_date = $(this).attr("data-schedule");
    } else {
        var queue_id = $(".si_queue_id").html();
        var s_date = $(".si_schedule_date").html();
    }
    $("#si_id_queue").val(queue_id);
    $("#si_quick_edit_schedule_time").modal("show");
    $("#datetimepicker_editschedule").datetimepicker({
        format:
            time_format && time_format == 24
                ? "MM/DD/YYYY HH:mm"
                : "MM/DD/YYYY hh:mm A",
        inline: true,
        sideBySide: true,
        // minDate: minDate,
        defaultDate: s_date,
        locale: moment.locale(locale, {
            week: { dow: Number(startDay) },
        }),

        icons: {
            up: "bi bi-chevron-up",
            down: "bi bi-chevron-down",
            previous: "bi bi-chevron-left",
            next: "bi bi-chevron-right",
        },
    });
});
// js for calendar module
$(document).on("click", ".si_edit_submit", function () {
    var queue_id = $("#si_id_queue").val();
    var schedule_time = $("#datetimepicker_editschedule").val();
    $.ajax({
        url: buildLink("bulk/quickeditdate"),
        type: "POST",
        data: { queueid: queue_id, schedule_time: schedule_time },
        success: function (result) {
            console.log(result);
            $("#si_quick_edit_schedule_time").modal("hide");
            $(".si_id_" + queue_id).html(result);
            if ($(".fc-button-active").hasClass("fc-timeGridWeek-button")) {
                $(".fc-timeGridWeek-button").trigger("click");
            } else if (
                $(".fc-button-active").hasClass("fc-timeGridDay-button")
            ) {
                $(".fc-timeGridDay-button").trigger("click");
            } else if (
                $(".fc-button-active").hasClass("fc-dayGridMonth-button")
            ) {
                $(".fc-dayGridMonth-button").trigger("click");
            } else if ($(".fc-button-active").hasClass("fc-listWeek-button")) {
                $(".fc-listWeek-button").trigger("click");
                // $(".si_list_caption_"+queue_id).html(result);
                // $(".si_edit_publish_date_"+queue_id).attr("data-schedule",result);
            }
        },
    });
});
$("#AddPostModal").on("hide.bs.modal", function (e) {
    $(".add-post-modal-body").html("");
    $(".add-Post-Model-Overlay").hide();
    reloadInit();
    refereshPreview();
});

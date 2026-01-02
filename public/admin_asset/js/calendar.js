document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("fullCalendar");

  var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
          left: "prev",
          center: "title",
          right: "today next",
      },
      initialView: "dayGridMonth",
      events: function(fetchInfo, successCallback, failureCallback) {
          fetch('/admin/scheduled-dates')
              .then(response => response.json())
              .then(data => {
                  console.log("Server response:", data);
                  if (data && Array.isArray(data.data)) {
                      var events = data.data.map(item => ({
                          start: item.Reminder_date,
                          backgroundColor: 'red',
                          borderColor: 'black',
                          extendedProps: {
                            icon: item.icon || 'fa-solid fa-calendar',
                            toolbar: item.toolbar || ''
                        }     
                      }));
                      successCallback(events);
                  } else {
                      console.error("Unexpected data format:", data);
                      failureCallback("Data is not in the expected array format");
                  }
              })
              .catch(error => {
                  console.error("Error fetching dates: ", error);
                  failureCallback(error);
              });
      }
  });

  calendar.render();
});

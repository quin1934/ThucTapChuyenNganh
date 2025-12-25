document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    var eventsUrl = calendarEl
        ? calendarEl.getAttribute("data-events-url")
        : null;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "vi", // Chuyển sang tiếng Việt
        initialView: "dayGridMonth", // Chế độ xem tháng
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,listWeek", // Các nút chuyển chế độ xem
        },
        events: eventsUrl || "/admin/lich-xe", // Lấy dữ liệu từ Controller

        // Khi di chuột vào sự kiện (Optional: Hiển thị tooltip đơn giản)
        eventDidMount: function (info) {
            info.el.title =
                "Đơn: #" +
                info.event.id +
                "\nTừ: " +
                info.event.start.toLocaleString() +
                "\nĐến: " +
                (info.event.end ? info.event.end.toLocaleString() : "...");
        },
    });

    calendar.render();
});

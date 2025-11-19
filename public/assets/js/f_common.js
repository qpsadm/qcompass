"use-strict";

// hamburger open/close
const hamburgerBtn = $(".hamburger-btn");

hamburgerBtn.click(function () {
    $(this).toggleClass("active");
});

// calendar
window.onload = function () {
    var today = new Date();

    const month = (today.getMonth() + 1);
    const day = today.getDate();

    const monthText = $(".month");
    const dayText = $(".day");
    const weekText = $(".week");

    monthText.text(month);
    dayText.text(day);

    function getWeekDay(date) {
        var weekDay = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
        return weekDay[date.getDay()];
    }

    var dt = new Date(2020, 5 - 1, 5);
    week = getWeekDay(dt);
    weekText.text(week);

    const yyyy = today.getFullYear();
    const mm = ('0' + (today.getMonth() + 1)).slice(-2);
    const dd = ('0' + today.getDate()).slice(-2);

    $("#date").val(`${yyyy}-${mm}-${dd}`);
}

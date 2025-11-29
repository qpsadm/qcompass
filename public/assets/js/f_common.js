"use-strict";

// hamburger-menu open/close
const hamburgerBtn = $(".hamburger-btn");

hamburgerBtn.click(function () {
    $(this).next().slideToggle(300);
    $(this).toggleClass("active");
    $('body').toggleClass("no-scroll")
});


// accordion-menu open/close
const accordionMenu = $(".accordion-menu");
const menuTitle = $(".menu-title");

menuTitle.click(function () {
    $(this).next().slideToggle(300);
    accordionMenu.toggleClass("active");
});


// qa-accordion
const qaAccordion = $(".qa-accordion");
const questionContainer = $(".question-container");

questionContainer.click(function () {
    const parentAccordion = $(this).closest(".qa-accordion");
    const answer = $(this).next(".answer-container");

    // 他のアコーディオンを閉じる & active を外す
    qaAccordion.not(parentAccordion).removeClass("active")
        .find(".answer-container").slideUp(300);

    // 自分の回答をトグル
    answer.slideToggle(300);

    // 自分のアコーディオンだけ active をトグル
    parentAccordion.toggleClass("active");
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

    // 日報入力の報告日をデフォルト入力する
    const yyyy = today.getFullYear();
    const mm = ('0' + (today.getMonth() + 1)).slice(-2);
    const dd = ('0' + today.getDate()).slice(-2);

    $("#date").val(`${yyyy}-${mm}-${dd}`);
}

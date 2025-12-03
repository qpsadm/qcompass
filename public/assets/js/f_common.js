"use strict";

// ------------------------------
// ハンバーガーメニュー open/close
// ------------------------------
const hamburgerBtn = $(".hamburger-btn");

hamburgerBtn.click(function () {
    $(this).next().slideToggle(300);
    $(this).toggleClass("active");
    $("body").toggleClass("no-scroll");
});

// ------------------------------
// アコーディオンメニュー open/close
// ------------------------------
const accordionMenu = $(".accordion-menu");
const menuTitle = $(".menu-title");

menuTitle.click(function () {
    $(this).next().slideToggle(300);
    accordionMenu.toggleClass("active");
});

// ------------------------------
// QAアコーディオン
// ------------------------------
const qaAccordion = $(".qa-accordion");
const questionContainer = $(".question-container");

questionContainer.click(function () {
    const parentAccordion = $(this).closest(".qa-accordion");
    const answer = $(this).next(".answer-container");

    // 他のアコーディオンを閉じる & activeを外す
    qaAccordion.not(parentAccordion).removeClass("active")
        .find(".answer-container").slideUp(300);

    // 自分の回答をトグル
    answer.slideToggle(300);

    // 自分のアコーディオンだけ active をトグル
    parentAccordion.toggleClass("active");
});

// ------------------------------
// カレンダー・日報日付入力
// ------------------------------
window.onload = function () {

    // ★★ 今日の日付を1回だけ取得 ★★
    const today = new Date();

    const yyyy = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, "0");
    const day = String(today.getDate()).padStart(2, "0");

    // カレンダー表示
    $(".month").text(month);
    $(".day").text(day);

    // 曜日表示
    //const weekDayList = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
    // $(".week").text(weekDayList[today.getDay()]);

    // 日報入力用日付（#date）
    const dateInput = $("#date");
    if (!dateInput.val()) {
        dateInput.val(`${yyyy}-${month}-${day}`);
    }
};

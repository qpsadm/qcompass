"use strict";

// ハンバーガーメニュー open/close

const hamburgerBtn = $(".hamburger-btn");

hamburgerBtn.click(function () {
    $(this).next().slideToggle(300);
    $(this).toggleClass("active");
    $("body").toggleClass("no-scroll");
});

// アコーディオンメニュー open/close

const accordionMenu = $(".accordion-menu");
const menuTitle = $(".menu-title");

menuTitle.click(function () {
    $(this).next().slideToggle(300);
    $(this).closest(".accordion-menu").toggleClass("active");
});


// 質疑応答のアコーディオンメニュー open/close

const qaAccordion = $(".qa-accordion");
const questionContainer = $(".question-container");

questionContainer.click(function () {
    const parentAccordion = $(this).closest(".qa-accordion");
    const answer = $(this).next(".answer-container");

    qaAccordion.not(parentAccordion).removeClass("active")
        .find(".answer-container").slideUp(300);
    answer.slideToggle(300);
    parentAccordion.toggleClass("active");
});

// カレンダー・日報日付入力
// window.onload = function () {
$(function () {
    const today = new Date();
    const yyyy = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, "0");
    const day = String(today.getDate()).padStart(2, "0");

    $(".month").text(month);
    $(".day").text(day);

    const dateInput = $("#date");
    if (!dateInput.val()) {
        dateInput.val(`${yyyy}-${month}-${day}`);
    }
});

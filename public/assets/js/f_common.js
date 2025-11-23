"use-strict";

// hamburger open/close
const hamburgerBtn = $(".hamburger-btn");

hamburgerBtn.click(function () {
    $(this).toggleClass("active");
});

// accordion-menu open/close
const accordionMenu = $(".accordion-menu");
const clickArea = $(".click-area");

clickArea.click(function () {
    $(this).next().slideToggle(300);
    accordionMenu.toggleClass("active");
});

// accordion-menu open/close
// const accordionMenu = $(".accordion-menu");
// const questionArea = $(".question-area");
// const answerArea = $(".answer-area");

// questionArea.click(function () {
//     $(this).next().slideToggle(300);
//     answerArea.toggleClass("active");
//     // accordionMenu.toggleClass("active");
// });

const questionArea = $(".question-area");

questionArea.click(function () {
    const answer = $(this).next(".answer-area");

    // すでに開いている回答以外をすべて閉じる
    $(".answer-area").not(answer).slideUp(300);

    // 自分の回答部分だけトグル
    answer.slideToggle(300);
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

//ダウンロードファイルアイコンの判定
$(document).ready(function () {
    $("#fileInput a").each(function () {
        var href = $(this).attr("href").toLowerCase();

        // 一旦クラスをクリア（念のため）
        $(this).removeClass("file-pdf file-excel file-default");

        if (href.endsWith(".pdf")) {
            $(this).addClass("file-pdf");
        } else if (href.endsWith(".xlsx") || href.endsWith(".xls")) {
            $(this).addClass("file-excel");
        } else {
            $(this).addClass("file-default");
        }
    });
});

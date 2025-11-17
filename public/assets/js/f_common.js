"use-strict";

// hamburger open/close
const hamburgerBtn = $(".hamburger-btn");

hamburgerBtn.click(function () {
    $(this).toggleClass("active");
});

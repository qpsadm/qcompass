"use-strict";

const overlay = $(".overlay");
const modalProfile = $(".modal-profile")
const modalCustomize = $(".modal-customize")
const openBtnProfile = $(".open-btn-profile")
const openBtnCustomize = $(".open-btn-customize")
const closeBtn = $(".close-btn")

// プロフィールモーダル表示

openBtnProfile.on('click', function () {
    overlay.fadeIn(400);
    modalProfile.fadeIn(400);
    $('body').addClass("no-scroll")
});

// カスタマイズモーダル表示

openBtnCustomize.on('click', function () {
    overlay.fadeIn(400);
    modalCustomize.fadeIn(400);
    $('body').addClass("no-scroll")
});

// モーダル非表示

function closeModal() {
    overlay.fadeOut(400);
    modalProfile.fadeOut(400);
    modalCustomize.fadeOut(400);
    $('body').removeClass("no-scroll")
}

closeBtn.on("click", closeModal);

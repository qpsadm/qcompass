"use-strict";

const overlay = $(".overlay");
const modalProfile = $(".modal-profile")
const modalCustomize = $(".modal-customize")
const modalAvatar = $(".modal-avatar")
const openBtnProfile = $(".open-btn-profile")
const openBtnCustomize = $(".open-btn-customize")
const openBtnAvatar = $(".open-btn-avatar")
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

// アバターモーダル表示

openBtnAvatar.on('click', function () {
    overlay.fadeIn(400);
    modalAvatar.fadeIn(400);
    $('body').addClass("no-scroll")
});

// モーダル非表示

function closeModal() {
    overlay.fadeOut(400);
    modalProfile.fadeOut(400);
    modalCustomize.fadeOut(400);
    modalAvatar.fadeOut(400);
    $('body').removeClass("no-scroll")
}

closeBtn.on("click", closeModal);

// アバター選択画像のプレビュー

$(function () {
    const $fileInput = $('#fileInput');
    let $currentPreviewImg = null;
    let $currentPreviewLabel = null;

    $('.select-image').on('click', function () {
        const previewId = $(this).data('preview');

        $currentPreviewImg = $('#' + previewId);
        $currentPreviewLabel = $currentPreviewImg.closest('label');

        $fileInput.trigger('click');
    });

    $fileInput.on('change', function (e) {
        const file = e.target.files[0];
        if (!file || !$currentPreviewImg || !$currentPreviewLabel) return;

        const imageUrl = URL.createObjectURL(file);
        $currentPreviewImg.attr('src', imageUrl);

        $currentPreviewImg.removeClass('is-hidden');
        $currentPreviewLabel.removeClass('is-hidden');

        $(this).val('');
    });
});

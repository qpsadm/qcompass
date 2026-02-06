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

// メモ保存

$(function () {
    $('.img-container input[name="avatar_type"]').each(function () {
        if ($(this).is(':checked')) {
            $(`label[for="${this.id}"]`).addClass('selected');
        }
    });
    $('.img-container input[name="avatar_type"]').on('change', function () {
        $('.img-container label').removeClass('selected');
        $(`label[for="${this.id}"]`).addClass('selected');
    });
});

// カレンダー初期化

$(function () {
    const calendarEl = $('#calendar')[0];
    if (!calendarEl) return;

    const pendingEvents = window.pendingEvents || [];
    const submittedEvents = window.submittedEvents || [];

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ja',
        timeZone: 'Asia/Tokyo',
        height: 'auto',
        dayCellContent: arg => arg.date.getDate(),
        events: pendingEvents.concat(submittedEvents),

        eventContent: function (arg) {
            if (arg.event.extendedProps.isPending) {
                return { domNodes: [] };
            }

            const $img = $('<img>', {
                src: `${window.APP_URL}/assets/images/icon/f_icon_check.svg`,
                alt: '提出済'
            }).css({
                width: '40px',
                height: '40px',
                cursor: 'pointer',
                filter: 'var(--tag-filter)'
            });

            return { domNodes: [$img[0]] };
        },

        eventClick: function (info) {
            if (info.event.extendedProps.url) {
                window.location.href = info.event.extendedProps.url;
            }
        },

        dateClick: function (info) {
            const event = calendar.getEvents().find(e =>
                e.startStr === info.dateStr && e.extendedProps.url
            );
            if (event) {
                window.location.href = event.extendedProps.url;
            }
        },

        datesSet: function () {
            $('.fc-daygrid-day-frame').each(function () {
                const $frame = $(this);
                const date = $frame.parent().data('date');

                const hasEvent = calendar.getEvents().some(e =>
                    e.startStr === date && e.extendedProps.url
                );

                $frame.css('cursor', hasEvent ? 'pointer' : 'default');

                if (hasEvent) {
                    $frame
                        .off('mouseenter mouseleave')
                        .on('mouseenter', function () {
                            $frame.css('background-color', '#fff9c4');
                        })
                        .on('mouseleave', function () {
                            $frame.css('background-color', '');
                        });
                }
            });
        }
    });

    calendar.render();
});

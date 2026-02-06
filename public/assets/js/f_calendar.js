"use strict";

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    // 安全に参照（未定義でも空配列）
    const pendingEvents = window.pendingEvents || [];
    const submittedEvents = window.submittedEvents || [];

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ja',
        timeZone: 'Asia/Tokyo',
        height: 'auto',
        dayCellContent: arg => arg.date.getDate(),
        events: pendingEvents.concat(submittedEvents),
        eventContent: function(arg) {
            if (arg.event.extendedProps.isPending) return { domNodes: [] };

            const img = document.createElement('img');
            img.src = `${window.APP_URL}/assets/images/icon/f_icon_check.svg`;
            img.alt = "提出済";
            img.style.width = "40px";
            img.style.height = "40px";
            img.style.cursor = "pointer";
            img.style.filter = "var(--tag-filter)";
            return { domNodes: [img] };
        },
        eventClick: function(info) {
            if (info.event.extendedProps.url) {
                window.location.href = info.event.extendedProps.url;
            }
        },
        dateClick: function(info) {
            const event = calendar.getEvents().find(
                e => e.startStr === info.dateStr && e.extendedProps.url
            );
            if (event) window.location.href = event.extendedProps.url;
        },
        datesSet: function() {
            document.querySelectorAll('.fc-daygrid-day-frame').forEach(frame => {
                const date = frame.parentElement.getAttribute('data-date');
                const hasEvent = calendar.getEvents().some(
                    e => e.startStr === date && e.extendedProps.url
                );

                frame.style.cursor = hasEvent ? 'pointer' : 'default';

                if (hasEvent) {
                    frame.addEventListener('mouseenter', () => {
                        frame.style.backgroundColor = '#fff9c4';
                    });
                    frame.addEventListener('mouseleave', () => {
                        frame.style.backgroundColor = '';
                    });
                }
            });
        }
    });

    calendar.render();

    // メモ保存
    $('#memo-form').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), {
            _token: $('input[name="_token"]').val(),
            memo: $('#memo-textarea').val()
        })
        .done(() => $('#memo-success').fadeIn().delay(2000).fadeOut())
        .fail(() => alert('保存に失敗しました'));
    });

    // アバターハイライト
    $('.img-container input[name="avatar_type"]').each(function() {
        if ($(this).is(':checked')) {
            $(`label[for="${this.id}"]`).addClass('selected');
        }
    });
    $('.img-container input[name="avatar_type"]').on('change', function() {
        $('.img-container label').removeClass('selected');
        $(`label[for="${this.id}"]`).addClass('selected');
    });
});

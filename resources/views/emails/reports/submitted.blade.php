{{-- resources/views/emails/reports/submitted.blade.php --}}
@component('mail::message')
    # 日報提出通知

    {{ $report->user->name }} さんが日報を提出しました。

    **日付:** {{ $report->date }}
    **タイトル:** {{ $report->title }}

    @if ($report->content)
        **内容:**
        {{ $report->content }}
    @endif

    @if ($report->impression)
        **感想・気付き・質問:**
        {{ $report->impression }}
    @endif

    @if ($report->notice)
        **連絡事項:**
        {{ $report->notice }}
    @endif

    @component('mail::button', ['url' => route('admin.reports.index')])
        日報一覧を見る
    @endcomponent
@endcomponent

受信者各位：

本メールは、「QLIP Compass」システムより自動配信されています。

提出者: {{ $report->created_user_name }}
提出日: {{ $report->date }}

【日報内容】
{{ $report->content }}

【所感・気付き・質問】
{{ $report->impression }}

【連絡事項】
@if ($report->notice)
    {{ $report->notice }}
@else
    なし
@endif

※本メールは送信専用です。返信いただいても対応できませんのでご注意ください。

━━━━━━━━━━━━━━━━━━━━
QLIPプログラミングスクール
QLIP Compass 管理システム
━━━━━━━━━━━━━━━━━━━━

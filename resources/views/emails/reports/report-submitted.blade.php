報告名: {{ $report->title }}
報告者: {{ $report->created_user_name }}
受講日: {{ \Carbon\Carbon::parse($report->date)->format('Y年m月d日') }}

【受講内容】
{{ $report->content }}

【所感・気付き・質問】
{{ $report->impression }}

【連絡事項】
{{ $report->notice }}

※本メールは、「QLIP Compass」講習管理システムより自動配信されています。
返信いただいても対応できませんのでご注意ください。

━━━━━━━━━━━━━━━━━━━━
株式会社QLIPインターナショナル
「QLIP Compass」講習管理システム
━━━━━━━━━━━━━━━━━━━━

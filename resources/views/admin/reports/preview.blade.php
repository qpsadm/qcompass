@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-6">日報プレビュー</h1>

    <table class="w-full border-collapse">
        <tbody>
            <tr class="border-b">
                <th class="text-left px-4 py-2 w-1/3">講座</th>
                <td class="px-4 py-2">{{ $course->course_name ?? '-' }}</td>
            </tr>
            <tr class="border-b">
                <th class="text-left px-4 py-2">日付</th>
                <td class="px-4 py-2">{{ $report['date'] ?? '-' }}</td>
            </tr>
            <tr class="border-b">
                <th class="text-left px-4 py-2">タイトル</th>
                <td class="px-4 py-2">{{ $report['title'] ?? '-' }}</td>
            </tr>
            <tr class="border-b">
                <th class="text-left px-4 py-2">日報内容</th>
                <td class="px-4 py-2" style="white-space: pre-wrap;">{{ strip_tags($report['content'] ?? '-') }}</td>
            </tr>
            <tr class="border-b">
                <th class="text-left px-4 py-2">感想・気付き・質問</th>
                <td class="px-4 py-2" style="white-space: pre-wrap;">{{ strip_tags($report['impression'] ?? '-') }}</td>
            </tr>
            <tr>
                <th class="text-left px-4 py-2">連絡事項</th>
                <td class="px-4 py-2" style="white-space: pre-wrap;">{{ strip_tags($report['notice'] ?? '-') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <button onclick="window.close()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            閉じる
        </button>
    </div>
</div>
@endsection

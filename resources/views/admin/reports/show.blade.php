@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">日報詳細</h1>

    <table class="w-full table-auto border-collapse bg-white shadow rounded-lg">
        <tbody>
            <tr class="border-b">
                <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">講座</th>
                <td class="px-4 py-2">{{ $course->course_name ?? '-' }}</td>
            </tr>

            <tr class="border-b">
                <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">日付</th>
                <td class="px-4 py-2">{{ $report->date ?? '-' }}</td>
            </tr>

            <tr class="border-b">
                <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">タイトル</th>
                <td class="px-4 py-2">{{ $report->title ?? '-' }}</td>
            </tr>

            <tr class="border-b">
                <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">日報内容</th>
                <td class="px-4 py-2 whitespace-pre-wrap">{{ $report->content ?? '-' }}</td>
            </tr>

            <tr class="border-b">
                <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">感想・気付き・質問</th>
                <td class="px-4 py-2 whitespace-pre-wrap">{{ $report->impression ?? '-' }}</td>
            </tr>

            <tr>
                <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">連絡事項</th>
                <td class="px-4 py-2 whitespace-pre-wrap">{{ $report->notice ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.reports.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
            一覧に戻る
        </a>
    </div>
</div>
@endsection

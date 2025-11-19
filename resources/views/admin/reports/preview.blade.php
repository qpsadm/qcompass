@extends('layouts.app')
@section('content')
    <div class="container mx-auto p-6 max-w-3xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">日報プレビュー</h1>

            <p><strong>講座：</strong>{{ $course->course_name ?? '' }}</p>
            <p><strong>日付：</strong>{{ $report['date'] }}</p>
            <p><strong>タイトル：</strong>{{ $report['title'] }}</p>
            <p><strong>日報内容：</strong></p>
            <div class="border p-3 rounded mb-3">{{ $report['content'] }}</div>

            <p><strong>感想・気付き・質問：</strong></p>
            <div class="border p-3 rounded mb-3">{{ $report['impression'] }}</div>

            <p><strong>連絡事項：</strong></p>
            <div class="border p-3 rounded">{{ $report['notice'] ?? '-' }}</div>

            <div class="mt-6">
                <button onclick="window.close()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    閉じる
                </button>
            </div>
        </div>
    </div>
@endsection

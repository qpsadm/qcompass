@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">学習コンテンツ詳細</h1>

        @php
        $typeLabels = [
        'book' => '参考書籍',
        'site' => '参考サイト',
        'video' => 'IT資格',
        'article' => '制作品',
        ];

        $levelLabels = [
        1 => '初級',
        2 => '中級',
        3 => '上級',
        ];

        $tags = [
        1 => 'WEB制作',
        2 => 'WEBデザイン',
        3 => 'プログラミング',
        4 => 'OA',
        5 => 'その他',
        ];
        @endphp

        <div class="border p-4 rounded mb-6 space-y-3">
            <p><strong>種別:</strong> {{ $typeLabels[$learning->type] ?? $learning->type }}</p>
            <p><strong>タイトル:</strong> {{ $learning->title }}</p>
            <p><strong>説明:</strong> {{ $learning->description ?? 'なし' }}</p>
            <p><strong>レベル:</strong> {{ $levelLabels[$learning->level] ?? '未設定' }}</p>
            <p><strong>タグ:</strong> {{ $tags[$learning->tag_id] ?? '未設定' }}</p>
            <p><strong>訓練科名:</strong> {{ $learning->course_name ?? '未設定' }}</p>
            <p><strong>制作期間:</strong> {{ $learning->priod ?? '未設定' }}</p>
            <p><strong>表示フラグ:</strong> {{ $learning->is_show ? '公開' : '非公開' }}</p>
        </div>

        {{-- 画像表示 --}}
        @if($learning->image)
        <p><strong>画像:</strong><br>
            <img src="{{ asset('storage/' . $learning->image) }}" class="w-32 h-32 object-cover rounded mx-auto">
        </p>

        <a href="{{ asset('storage/' . $learning->image) }}" target="_blank"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-2 inline-block">
            画像を拡大表示
        </a>
        @endif


        <div class="flex gap-2">
            <a href="{{ route('admin.learnings.edit', $learning->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">編集</a>
            <a href="{{ route('admin.learnings.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">一覧に戻る</a>
        </div>
    </div>
</div>
@endsection

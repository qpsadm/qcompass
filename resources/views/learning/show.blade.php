@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ詳細</h1>

            @php
                $typeLabels = [
                    'book' => '本',
                    'site' => 'サイト',
                    'video' => '動画',
                    'article' => '記事',
                ];

                $levelLabels = [
                    1 => '初級',
                    2 => '中級',
                    3 => '上級',
                ];
            @endphp

            <div class="border p-4 rounded mb-4 space-y-2">
                <p><strong>種別:</strong> {{ $typeLabels[$learning->type] ?? $learning->type }}</p>
                <p><strong>タイトル:</strong> {{ $learning->title }}</p>
                <p><strong>説明:</strong> {{ $learning->description }}</p>
                <p><strong>画像:</strong>
                    @if ($learning->image)
                        <img src="{{ $learning->image }}" alt="" class="w-32 h-32 object-cover">
                    @else
                        なし
                    @endif
                </p>
                <p><strong>URL:</strong>
                    @if ($learning->url)
                        <a href="{{ $learning->url }}" target="_blank" class="text-blue-600 underline">{{ $learning->url }}</a>
                    @else
                        なし
                    @endif
                </p>
                <p><strong>レベル:</strong> {{ $levelLabels[$learning->level] ?? $learning->level }}</p>
                <p><strong>表示フラグ:</strong> {{ $learning->display_flag ? '公開' : '非公開' }}</p>
            </div>

            <div class="flex space-x-2">
                <a href="{{ route('admin.learnings.edit', $learning->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
                <a href="{{ route('admin.learnings.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
            </div>
        </div>
    </div>
@endsection

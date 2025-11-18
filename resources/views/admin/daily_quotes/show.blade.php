@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">今日の一言詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>ひとこと本文:</strong> {{ $DailyQuote->quote }}</p>
            <p><strong>発言者・出典:</strong> {{ $DailyQuote->author }}</p>
            <p><strong>表示日※特定の日に表示したい場合※:</strong> {{ $DailyQuote->display_date }}</p>
            <p><strong>表示/非表示:</strong> {{ $DailyQuote->is_show }}</p>
            <p><strong>削除日:</strong> {{ $DailyQuote->deleted_at }}</p>

        </div>
        <a href="{{ route('admin.daily_quotes.edit', $DailyQuote->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.daily_quotes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">今日の一言詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>quote:</strong> {{ $DailyQuote->quote }}</p>
        <p><strong>author:</strong> {{ $DailyQuote->author }}</p>
        <p><strong>display_date:</strong> {{ $DailyQuote->display_date }}</p>
        <p><strong>is_show:</strong> {{ $DailyQuote->is_show }}</p>
        <p><strong>deleted_at:</strong> {{ $DailyQuote->deleted_at }}</p>

    </div>
    <a href="{{ route('admin.daily_quotes.edit', $DailyQuote->id) }}"
        class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('admin.daily_quotes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection

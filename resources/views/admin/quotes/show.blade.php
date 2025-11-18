@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">名言詳細</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <p class="text-xl mb-4">“{{ $quote_text }}”</p>
        @if($author_text)
        <p class="text-gray-600 text-lg mb-4">— {{ $author_text }}</p>
        @endif

        {{-- モード切替 --}}
        <div class="flex gap-2 mb-4">
            <a href="{{ route('admin.quotes.show', $quote->id) }}?mode=normal"
                class="px-4 py-2 rounded {{ $mode=='normal' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                原文モード
            </a>
            <a href="{{ route('admin.quotes.show', $quote->id) }}?mode=random"
                class="px-4 py-2 rounded {{ $mode=='random' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                ランダムモード
            </a>

            @if($mode === 'random')
            {{-- もう一度生成 --}}
            <a href="{{ route('admin.quotes.show', $quote->id) }}?mode=random"
                class="px-4 py-2 rounded bg-yellow-400 text-white hover:bg-yellow-500">
                もう一度生成
            </a>
            @endif
        </div>
    </div>

    {{-- 戻るボタン --}}
    <a href="{{ route('admin.quotes.index') }}"
        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">一覧に戻る</a>
</div>
@endsection

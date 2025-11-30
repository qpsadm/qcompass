@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">名言一覧</h1>

    @foreach ($quotes as $quote)
    <div class="p-4 mb-4 border rounded-lg bg-white shadow">
        <p class="text-lg font-semibold">{{ $quote->quote_full }}</p>
        <p class="text-gray-600">— {{ $quote->author_full ?? '作者不明' }}</p>
    </div>
    @endforeach
</div>
@endsection

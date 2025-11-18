@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">{{ isset($quote) ? '編集' : '新規登録' }}</h1>

    <form action="{{ isset($quote) ? route('admin.quotes.update', $quote->id) : route('admin.quotes.store') }}" method="POST">
        @csrf
        @if(isset($quote)) @method('PUT') @endif

        <label class="block mt-2">原文名言</label>
        <input type="text" name="quote_full" class="w-full border px-2 py-1" value="{{ old('quote_full', $quote->quote_full ?? '') }}" required>

        <label class="block mt-2">原作者名</label>
        <input type="text" name="author_full" class="w-full border px-2 py-1" value="{{ old('author_full', $quote->author_full ?? '') }}">

        <h3 class="mt-4 font-bold">名言パーツ</h3>
        @foreach(['A','B','C'] as $part)
        <label class="block mt-1">{{ $part }}</label>
        <input type="text" name="quote_parts[{{ $part }}]" class="w-full border px-2 py-1" value="{{ old('quote_parts.'.$part, $quote->quoteParts->where('part_type',$part)->first()->text ?? '') }}" required>
        @endforeach

        <h3 class="mt-4 font-bold">作者パーツ</h3>
        @foreach(['A','B'] as $part)
        <label class="block mt-1">{{ $part }}</label>
        <input type="text" name="author_parts[{{ $part }}]" class="w-full border px-2 py-1" value="{{ old('author_parts.'.$part, $quote->authorParts->where('part_type',$part)->first()->text ?? '') }}" required>
        @endforeach

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-4">{{ isset($quote) ? '更新' : '登録' }}</button>
    </form>
</div>
@endsection

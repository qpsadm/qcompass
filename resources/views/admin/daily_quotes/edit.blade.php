@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">今日の一言編集</h1>
    <form action="{{ route('admin.daily_quotes.update', $DailyQuote->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block font-medium mb-1">quote</label>
            <input type="text" name="quote" value="{{ old('quote', $DailyQuote->quote ?? '') }}"
                class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">author</label>
            <input type="text" name="author" value="{{ old('author', $DailyQuote->author ?? '') }}"
                class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">display_date</label>
            <input type="text" name="display_date" value="{{ old('display_date', $DailyQuote->display_date ?? '') }}"
                class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">is_show</label>
            <input type="text" name="is_show" value="{{ old('is_show', $DailyQuote->is_show ?? '') }}"
                class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">deleted_at</label>
            <input type="text" name="deleted_at" value="{{ old('deleted_at', $DailyQuote->deleted_at ?? '') }}"
                class="border px-2 py-1 w-full rounded">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>
@endsection

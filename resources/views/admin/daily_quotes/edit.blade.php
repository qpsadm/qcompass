@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 pb-24 max-w-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">今日の一言編集</h1>

        <form action="{{ route('admin.daily_quotes.update', $DailyQuote->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf
            @method('PUT')

            <!-- quote -->
            <div>
                <label for="quote" class="block text-gray-700 font-semibold mb-2">ひとこと本文</label>
                <input type="text" name="quote" id="quote" value="{{ old('quote', $DailyQuote->quote) }}"
                    class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- author -->
            <div>
                <label for="author" class="block text-gray-700 font-semibold mb-2">発言者・出典</label>
                <input type="text" name="author" id="author" value="{{ old('author', $DailyQuote->author) }}"
                    class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- display_date（date に統一） -->
            <div>
                <label for="display_date" class="block text-gray-700 font-semibold mb-2">表示日※特定の日に表示したい場合※</label>
                <input type="date" name="display_date" id="display_date"
                    value="{{ old('display_date', optional($DailyQuote->display_date)->format('Y-m-d')) }}"
                    class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- is_show（select に統一） -->
            <div>
                <label for="is_show" class="block text-gray-700 font-semibold mb-2">表示/非表示</label>
                <select name="is_show" id="is_show"
                    class="w-full border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="1" {{ old('is_show', $DailyQuote->is_show) == 1 ? 'selected' : '' }}>表示</option>
                    <option value="0" {{ old('is_show', $DailyQuote->is_show) == 0 ? 'selected' : '' }}>非表示</option>
                </select>
            </div>

            <!-- deleted_at（hidden に統一） -->
            <input type="hidden" name="deleted_at" value="{{ old('deleted_at', $DailyQuote->deleted_at) }}">

            <div class="flex gap-2 mt-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                    更新
                </button>
                <a href="{{ route('admin.daily_quotes.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

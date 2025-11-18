@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-xl bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">今日の一言 作成</h1>

        <form action="{{ route('admin.daily_quotes.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- quote -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">ひとこと本文</label>
                <input type="text" name="quote" value="{{ old('quote', $DailyQuote->quote ?? '') }}" required
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                @error('quote')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- author -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">発言者・出典</label>
                <input type="text" name="author" value="{{ old('author', $DailyQuote->author ?? '') }}" required
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                @error('author')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- display_date（null 許容） -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">表示日※特定の日に表示したい場合※</label>
                <input type="date" name="display_date"
                    value="{{ old('display_date', isset($DailyQuote->display_date) ? optional($DailyQuote->display_date)->format('Y-m-d') : '') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                @error('display_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- is_show -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">表示/非表示</label>
                <select name="is_show"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="1" {{ old('is_show', $DailyQuote->is_show ?? 1) == 1 ? 'selected' : '' }}>表示
                    </option>
                    <option value="0" {{ old('is_show', $DailyQuote->is_show ?? 1) == 0 ? 'selected' : '' }}>非表示
                    </option>
                </select>

                @error('is_show')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- deleted_at（原則入力不要 → hiddenに変更） -->
            <input type="hidden" name="deleted_at" value="{{ old('deleted_at', $DailyQuote->deleted_at ?? '') }}">

            <!-- ボタン -->
            <div class="flex items-center gap-3 mt-4">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                    保存
                </button>

                <a href="{{ route('admin.daily_quotes.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

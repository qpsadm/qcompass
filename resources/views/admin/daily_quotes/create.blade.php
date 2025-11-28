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
            <div class="mb-4" x-data="{ is_show: {{ old('is_show', $JobOffer->is_show ?? 0) }} }">
                <span class="font-medium mr-2">表示フラグ</span>
                <div class="flex gap-2">
                    <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                        <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                        公開
                    </label>

                    <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                        <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                        非公開
                    </label>
                </div>
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

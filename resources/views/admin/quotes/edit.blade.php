@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen" x-data="{ deleteOpen: false }">

        <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">

            <!-- ヘッダー -->
            <div class="mb-6">
                {{-- <a href="{{ route('admin.quotes.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                ← 名言一覧に戻る
            </a> --}}
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ isset($quote) ? '名言 編集' : '名言 新規登録' }}
                </h1>
            </div>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- フォーム -->
            <form action="{{ isset($quote) ? route('admin.quotes.update', $quote->id) : route('admin.quotes.store') }}"
                method="POST">
                @csrf
                @isset($quote)
                    @method('PUT')
                @endisset

                <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-sm">
                    <tbody>

                        <!-- 原文名言 -->
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                原文名言
                                <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                    必須
                                </span>
                            </th>
                            <td class="px-4 py-3">
                                <input type="text" name="quote_full"
                                    value="{{ old('quote_full', $quote->quote_full ?? '') }}" required
                                    class="border rounded px-3 py-2 w-full
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                        </tr>

                        <!-- 原作者名 -->
                        <tr class="border-b">
                            <th class="px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                原作者名
                                <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                    必須
                                </span>
                            </th>
                            <td class="px-4 py-3">
                                <input type="text" name="author_full"
                                    value="{{ old('author_full', $quote->author_full ?? '') }}" required
                                    class="border rounded px-3 py-2 w-96
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>
                        </tr>

                        <!-- 名言パーツ 見出し -->
                        {{-- <tr class="bg-gray-50">
                            <th colspan="2" class="px-4 py-3 font-semibold text-gray-700">
                                名言パーツ
                            </th>
                        </tr>

                        @foreach (['A', 'B', 'C'] as $part)
                            <tr class="border-b">
                                <th class="px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                    パーツ {{ $part }}
                                    <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                        必須
                                    </span>
                                </th>
                                <td class="px-4 py-3">
                                    <input type="text" name="quote_parts[{{ $part }}]"
                                        value="{{ old('quote_parts.' . $part, optional($quote->quoteParts->where('part_type', $part)->first())->text ?? '') }}"
                                        required
                                        class="border rounded px-3 py-2 w-full
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </td>
                            </tr>
                        @endforeach --}}

                        <!-- 作者パーツ 見出し -->
                        {{-- <tr class="bg-gray-50">
                            <th colspan="2" class="px-4 py-3 font-semibold text-gray-700">
                                作者パーツ
                            </th>
                        </tr>

                        @foreach (['A', 'B', 'C'] as $part)
                            <tr class="border-b">
                                <th class="px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                    パーツ {{ $part }}
                                    <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                        必須
                                    </span>
                                </th>
                                <td class="px-4 py-3">
                                    <input type="text" name="author_parts[{{ $part }}]"
                                        value="{{ old('author_parts.' . $part, optional($quote->authorParts->where('part_type', $part)->first())->text ?? '') }}"
                                        required
                                        class="border rounded px-3 py-2 w-full
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </td>
                            </tr>
                        @endforeach --}}

                    </tbody>
                </table>

                <!-- 操作ボタン -->
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="save bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                        {{ isset($quote) ? '更新する' : '登録する' }}
                    </button>

                    <a href="{{ route('admin.quotes.index') }}"
                        class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>

            @isset($quote)
                <!-- 危険操作ゾーン -->
                <div class="mt-10 pt-6 border-t border-red-200">
                    <h2 class="text-red-600 font-semibold mb-2">⚠ 危険な操作</h2>
                    <p class="text-sm text-gray-600 mb-4">
                        この名言を削除すると、元に戻すことはできません。
                    </p>
                    <button @click="deleteOpen = true" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                        削除する
                    </button>
                </div>
            @endisset
        </div>

        <!-- 削除確認モーダル -->
        @isset($quote)
            <div x-show="deleteOpen" x-cloak x-transition.opacity
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div x-show="deleteOpen" x-transition.scale class="bg-white rounded-2xl p-6 w-full max-w-sm">
                    <h3 class="text-lg font-semibold text-center mb-3">削除確認</h3>
                    <p class="text-center text-gray-700 mb-5">
                        「<span class="font-semibold">{{ $quote->quote_full }}</span>」を削除しますか？
                        <br><span class="text-sm text-red-600">※ この操作は取り消せません</span>
                    </p>

                    <div class="flex justify-center gap-4">
                        <button @click="deleteOpen = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            キャンセル
                        </button>

                        <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                削除する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endisset

        <style>
            [x-cloak] {
                display: none !important
            }
        </style>
    </div>
@endsection

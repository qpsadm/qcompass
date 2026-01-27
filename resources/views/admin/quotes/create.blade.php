@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen">

    <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">

        <!-- ヘッダー -->
        <div class="mb-6">
            <a href="{{ route('admin.quotes.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                ← 名言一覧に戻る
            </a>
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
        <form
            action="{{ isset($quote) ? route('admin.quotes.update', $quote->id) : route('admin.quotes.store') }}"
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
                            <input type="text"
                                name="quote_full"
                                value="{{ old('quote_full', $quote->quote_full ?? '') }}"
                                required
                                class="border rounded px-3 py-2 w-full
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </td>
                    </tr>

                    <!-- 原作者名 -->
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                            原作者名
                            <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                必須
                            </span>
                        </th>
                        <td class="px-4 py-3">
                            <input type="text"
                                name="author_full"
                                value="{{ old('author_full', $quote->author_full ?? '') }}"
                                required
                                class="border rounded px-3 py-2 w-96
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </td>
                    </tr>

                    <!-- セクション：名言パーツ -->
                    <tr class="bg-gray-50">
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
                            <input type="text"
                                name="quote_parts[{{ $part }}]"
                                value="{{ old(
                                        'quote_parts.' . $part,
                                        isset($quote)
                                            ? optional($quote->quoteParts->where('part_type', $part)->first())->text
                                            : ''
                                   ) }}"
                                required
                                class="border rounded px-3 py-2 w-full
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </td>
                    </tr>
                    @endforeach

                    <!-- セクション：作者パーツ -->
                    <tr class="bg-gray-50">
                        <th colspan="2" class="px-4 py-3 font-semibold text-gray-700">
                            作者パーツ
                        </th>
                    </tr>

                    @foreach (['A', 'B', 'C'] as $part)
                    @php
                    $authorValue = old(
                    'author_parts.' . $part,
                    isset($quote)
                    ? optional($quote->authorParts->where('part_type', $part)->first())->text
                    : ''
                    );
                    @endphp
                    <tr class="border-b">
                        <th class="px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                            パーツ {{ $part }}
                            <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                必須
                            </span>
                        </th>
                        <td class="px-4 py-3">
                            <input type="text"
                                name="author_parts[{{ $part }}]"
                                value="{{ $authorValue }}"
                                required
                                class="border rounded px-3 py-2 w-full
                                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            <!-- 操作ボタン -->
            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    {{ isset($quote) ? '更新する' : '登録する' }}
                </button>

                <a href="{{ route('admin.quotes.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>

    </div>
</div>
@endsection

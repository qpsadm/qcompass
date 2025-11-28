@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6 text-center">講座種類作成</h1>

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

        <form action="{{ route('admin.levels.store') }}" method="POST">
            @csrf
            <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-md">
                <tbody>
                    {{-- レベルコード --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">レベルコード
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="code" value="{{ old('code') }}" placeholder="例: L01" required
                                class="w-64 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 種類名 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">種類名
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-64 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 表示/非表示 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示フラグ</th>
                        <td class="px-4 py-2" x-data="{ is_show: {{ old('is_show', $division->is_show ?? 1) }} }">
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
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    保存する
                </button>
                <a href="{{ route('admin.levels.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

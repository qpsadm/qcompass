@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6 text-center">講座種類編集</h1>

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

        <form action="{{ route('admin.levels.update', $Level->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-md">
                <tbody>
                    {{-- レベルコード --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                            レベルコード
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="code" value="{{ old('code', $Level->code) }}" required
                                class="w-64 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 種類 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                            種類
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="name" value="{{ old('name', $Level->name) }}" required
                                class="w-64 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 表示設定 --}}
                    <tr>
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示設定</th>
                        <td class="px-4 py-2">
                            <label class="inline-flex items-center gap-2">
                                <input type="hidden" name="is_show" value="0">
                                <input type="checkbox" name="is_show" value="1"
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    {{ old('is_show', $Level->is_show) == 1 ? 'checked' : '' }}>
                                <span class="text-gray-700 font-medium">表示する</span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- ボタン --}}
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    更新
                </button>
                <a href="{{ route('admin.levels.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

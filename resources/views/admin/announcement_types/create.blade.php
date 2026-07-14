@extends('layouts.app')

@section('content')
    <div class="container mx-auto min-h-screen p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">
            <h1 class="text-2xl font-bold mb-4">
                お知らせカテゴリ 作成
            </h1>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.announcement_types.store') }}">
                @csrf

                <table class="w-full table-auto border-collapse">
                    <tbody>
                        {{-- カテゴリ名 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium w-1/4">
                                カテゴリ名
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">
                                    必須
                                </span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="type_name" value="{{ old('type_name') }}"
                                    class="border rounded px-3 py-2 w-full" required>

                            </td>
                        </tr>

                        {{-- 表示フラグ --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                表示状態
                            </th>
                            <td class="px-4 py-2" x-data="{ is_show: {{ old('is_show', 1) }} }">
                                <div class="flex gap-2">
                                    <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                                        class="px-4 py-2 rounded-full cursor-pointer transition">
                                        <input type="radio" name="is_show" value="1" class="hidden"
                                            x-model="is_show">
                                        公開
                                    </label>

                                    <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                                        class="px-4 py-2 rounded-full cursor-pointer transition">
                                        <input type="radio" name="is_show" value="0" class="hidden"
                                            x-model="is_show">
                                        非公開
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- ボタン --}}
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                        保存
                    </button>

                    <a href="{{ route('admin.announcement_types.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

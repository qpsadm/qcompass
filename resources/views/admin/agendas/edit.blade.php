@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">アジェンダ編集</h1>

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

        <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full table-auto border-collapse">
                <tbody>

                    {{-- アジェンダ名 --}}
                    <tr class="border-b">
                        <th class="w-60 px-4 py-2 bg-gray-100 text-right font-medium">
                            アジェンダ名
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="agenda_name"
                                value="{{ old('agenda_name', $agenda->agenda_name) }}"
                                class="border rounded px-3 py-2 w-full" required>
                        </td>
                    </tr>

                    {{-- カテゴリ --}}
                    <tr class="border-b">
                        <th class="w-60 px-4 py-2 bg-gray-100 text-right font-medium">
                            カテゴリ
                        </th>
                        <td class="px-4 py-2">
                            <select name="category_id"
                                class="border rounded px-3 py-2 w-80">
                                <option value="">選択してください</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat['id'] }}"
                                    {{ old('category_id', $agenda->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>
                                    {{ $cat['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    {{-- 表示フラグ --}}
                    <tr class="border-b">
                        <th class="w-60 px-4 py-2 bg-gray-100 text-right font-medium">
                            表示フラグ
                        </th>
                        <td class="px-4 py-2" x-data="{ is_show: {{ old('is_show', $agenda->is_show ?? 0) }} }">
                            <div class="flex gap-2">
                                <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer transition">
                                    <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                                    公開
                                </label>

                                <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer transition">
                                    <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                                    非公開
                                </label>
                            </div>
                        </td>
                    </tr>

                    {{-- 承認状態 --}}
                    <tr class="border-b">
                        <th class="w-60 px-4 py-2 bg-gray-100 text-right font-medium">
                            承認状態
                        </th>
                        <td class="px-4 py-2">
                            <select name="status"
                                class="border rounded px-3 py-2 w-60" required>
                                <option value="yes"
                                    {{ old('status', $agenda->status) == 'yes' ? 'selected' : '' }}>
                                    承認済み
                                </option>
                                <option value="no"
                                    {{ old('status', $agenda->status) == 'no' ? 'selected' : '' }}>
                                    下書き
                                </option>
                            </select>
                        </td>
                    </tr>

                    {{-- 内容 --}}
                    <tr class="border-b">
                        <th class="w-60 px-4 py-2 bg-gray-100 text-right font-medium">
                            内容・概要
                        </th>
                        <td class="px-4 py-2">
                            <textarea name="content"
                                id="agenda-content"
                                class="border rounded px-3 py-2 w-full">
                            {{ old('content', $agenda->content ?? '') }}
                            </textarea>
                        </td>
                    </tr>

                </tbody>
            </table>

            {{-- ファイル追加ボタン --}}
            <div class="mt-6">
                <a href="{{ route('admin.files.create', [
                        'type' => 'agenda',
                        'targetId' => $agenda->id,
                        'return' => route('admin.agendas.edit', $agenda->id),
                    ]) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    ファイル追加
                </a>
            </div>

            {{-- ボタン --}}
            <div class="flex gap-3 mt-6">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                    更新
                </button>

                <a href="{{ route('admin.agendas.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('agenda-content', {
            language: 'ja',
            allowedContent: true,
            height: '70vh'
        });
    </script>

    <style>
        .cke_notifications_area {
            display: none !important;
        }
    </style>
</div>
@endsection

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

                <table class="w-full table-auto border-collapse" style="max-width: 1280px;">
                    <tbody>

                        {{-- アジェンダ名 --}}
                        <tr class="border-b">
                            <th class="w-40 px-4 py-2 bg-gray-100 text-right font-medium">
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
                            <th class="w-40 px-4 py-2 bg-gray-100 text-right font-medium">
                                カテゴリ
                            </th>
                            <td class="px-4 py-2">
                                <select name="category_id" class="border rounded px-3 py-2 w-80">
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
                            <th class="w-40 px-4 py-2 bg-gray-100 text-right font-medium">
                                表示フラグ
                            </th>

                            <td class="px-4 py-2" x-data="{ is_show: {{ old('is_show', $agenda->is_show ?? 1) }} }">
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

                        {{-- 承認状態 --}}
                        <tr class="border-b">
                            <th class="w-40 px-4 py-2 bg-gray-100 text-right font-medium">
                                承認状態
                            </th>
                            <td class="px-4 py-2">
                                <select name="status" class="border rounded px-3 py-2 w-60" required>
                                    <option value="yes" {{ old('status', $agenda->status) == 'yes' ? 'selected' : '' }}>
                                        承認済み
                                    </option>
                                    <option value="draft"
                                        {{ old('status', $agenda->status) == 'draft' ? 'selected' : '' }}>
                                        下書き
                                    </option>
                                </select>
                            </td>
                        </tr>

                        {{-- 内容 --}}
                        <tr class="border-b">
                            <th class="w-40 px-4 py-2 bg-gray-100 text-right font-medium">
                                内容・概要
                            </th>
                            <td class="px-4 py-2">
                                <textarea name="content" id="agenda-content" class="border rounded px-3 py-2 w-full">
                            {{ old('content', $agenda->content ?? '') }}
                            </textarea>
                            </td>
                        </tr>

                    </tbody>
                </table>

                {{-- 画像一覧 --}}
                @if (isset($agenda) && $agenda->id && $agenda->files->isNotEmpty())
                    <div class="mt-6 bg-gray-50 p-4 rounded">
                        <h2 class="text-lg font-semibold mb-2">登録済みファイル一覧</h2>
                        <table class="w-full table-auto border-collapse border" style="max-width:900px;">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-3 py-2 w16">No</th>
                                    <th class="border px-3 py-2 ">ファイル名</th>
                                    <th class="border px-3 py-2 w20">サイズ</th>
                                    <th class="border px-3 py-2 w20">プレビュー</th>
                                    <th class="border px-3 py-2 w20">URLコピー</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agenda->files as $key => $file)
                                    @php
                                        // typeパラメータを渡す
                                        $previewUrl = route('admin.files.preview', [
                                            'type' => 'agenda',
                                            'id' => $file->id,
                                        ]);
                                        // ファイルのURLを取得 fukushima 2026-06-03
                                        $url = asset('storage/files/' . $file->file_name);
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-3 py-2 text-center">{{ $key + 1 }}</td>
                                        <td class="border px-3 py-2">{{ $file->file_name }}</td>
                                        <td class="border px-3 py-2">{{ number_format($file->file_size / 1024, 2) }} KB
                                        </td>
                                        <td class="border px-3 py-2  text-center">
                                            @if (Str::startsWith($file->file_type, 'image/'))
                                                <a href="{{ $previewUrl }}" target="_blank">
                                                    <img src="{{ $previewUrl }}" class="w-20 object-cover rounded"
                                                        alt="プレビュー">
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="border px-3 py-2  text-center">
                                            @php

                                            @endphp
                                            {{-- <button type="button"
                                                class="bg-gray-200 px-2 py-1 rounded text-sm hover:bg-gray-300"
                                                onclick="navigator.clipboard.writeText('{{ $url }}').then(() => { alert('URLをコピーしました'); });">
                                                URLコピー
                                            </button> --}}
                                            <button type="button"
                                                class="bg-gray-200 px-2 py-1 rounded text-sm hover:bg-gray-300"
                                                onclick="navigator.clipboard.writeText('{{ $url }}')">
                                                URLコピー
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

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
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
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
                height: '35vh'
            });
        </script>

        <style>
            .cke_notifications_area {
                display: none !important;
            }
        </style>
    </div>
@endsection

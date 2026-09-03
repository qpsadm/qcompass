@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">お知らせの編集</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif


        <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}">
            @csrf
            @method('PUT')

            @include('admin.announcements.form', [
                'announcement' => $announcement,
                'types' => $types,
                'courses' => $courses,
            ])

            {{-- 画像一覧 --}}
            @if (isset($announcement) && $announcement->id && $announcement->files->isNotEmpty())
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
                            @foreach ($announcement->files as $key => $file)
                                @php
                                    // typeパラメータを渡す
                                    $previewUrl = route('admin.files.preview', [
                                        'type' => 'announcement',
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
                    'type' => 'announcement',
                    'targetId' => $announcement->id,
                    'return' => route('admin.announcements.edit', $announcement->id),
                ]) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    ファイル追加
                </a>
            </div>

            <button class="save bg-blue-600 text-white px-4 py-2 rounded">更新</button>
            <a href="{{ route('admin.announcements.index') }}"
                class="back bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                一覧に戻る
            </a>
        </form>
    </div>
@endsection

@extends('layouts.app')

@php
    $typeMap = [
        'announcement' => 'お知らせ',
        'agenda' => 'アジェンダ',
    ];

    $japaneseTitle = $typeMap[strtolower($type)] ?? ucfirst($type);
@endphp

@section('content')
    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">{{ $japaneseTitle }} ファイル一覧</h1>
        <div class="mb-4">
            <a href="{{ route('admin.files.create', ['type' => $type, 'targetId' => $targetId]) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                新規作成
            </a>
        </div>

        @if ($files->isEmpty())
            <p>ファイルはまだ登録されていません。</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">ファイル名</th>
                        <th class="border px-4 py-2">説明</th>
                        <th class="border px-4 py-2">作成日</th>
                        <th class="border px-4 py-2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td class="border px-4 py-2">{{ $file->id }}</td>
                            <td class="border px-4 py-2">{{ $file->file_name }}</td>
                            <td class="border px-4 py-2">{{ $file->description }}</td>
                            <td class="border px-4 py-2">{{ $file->created_at }}</td>
                            <td class="border px-4 py-2 flex gap-2">

                                <a href="{{ route('admin.files.preview', ['type' => $type, 'id' => $file->id]) }}"
                                    class="text-blue-500 underline" target="_blank">プレビュー</a>

                                <a href="{{ route('admin.files.edit', ['type' => $type, 'id' => $file->id]) }}"
                                    class="text-green-500 underline">編集</a>

                                <form action="{{ route('admin.files.destroy', ['type' => $type, 'id' => $file->id]) }}"
                                    method="POST" onsubmit="return confirm('本当に削除しますか？');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 underline">削除</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection

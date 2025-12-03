{{-- @extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">資格一覧</h1>

        @php
            $levelLabels = [
                1 => '初級',
                2 => '上級',
            ];
        @endphp

        <a href="{{ route('admin.certifications.create') }}"
            class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">資格名</th>
                    <th class="border px-2 py-1">資格レベル</th>
                    <th class="border px-2 py-1">説明・備考</th>
                    <th class="border px-2 py-1">参照URL</th>
                    <th class="border px-2 py-1">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certifications as $certification)
                    <tr>
                        <td class="border px-2 py-1">{{ $certification->id }}</td>
                        <td class="border px-2 py-1">{{ $certification->name }}</td>
                        <td class="border px-2 py-1">{{ $levelLabels[$certification->level] ?? $certification->level }}</td>
                        <td class="border px-2 py-1">{{ $certification->description }}</td>
                        <td class="border px-2 py-1">
                            @if ($certification->url)
                                <a href="{{ $certification->url }}" target="_blank" class="text-blue-600 underline">リンク</a>
                            @else
                                なし
                            @endif
                        </td>
                        <td class="border px-2 py-1">
                            <a href="{{ route('admin.certifications.edit', $certification->id) }}"
                                class="text-blue-600">編集</a>

                            <form action="{{ route('admin.certifications.destroy', $certification->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 ml-2" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- タイトル --}}
        <h1 class="text-2xl font-bold mb-4">資格詳細: {{ $certification->name }}</h1>

        @php
            // 資格一覧にあったレベルラベルの定義を移植
            $levelLabels = [
                1 => '初級',
                2 => '上級',
            ];
            $levelName = $levelLabels[$certification->level] ?? $certification->level;
        @endphp

        {{-- メタ情報 (ID, レベル) --}}
        <div class="text-gray-500 mb-4 text-sm">
            <span>ID: {{ $certification->id }}</span> /
            <span>資格レベル: {{ $levelName }}</span> /
            <span>作成日: {{ $certification->created_at->format('Y-m-d') }}</span>
        </div>

        {{-- 詳細情報（テーブル形式で表示） --}}
        <div class="bg-gray-100 p-4 rounded mb-4">
            <table class="w-full text-left">
                <tbody>
                    <tr>
                        <th class="py-2 pr-4 w-1/4 font-semibold border-b">資格名</th>
                        <td class="py-2 border-b">{{ $certification->name }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 pr-4 font-semibold border-b">資格レベル</th>
                        <td class="py-2 border-b">{{ $levelName }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 pr-4 font-semibold border-b">説明・備考</th>
                        <td class="py-2 border-b">{!! nl2br(e($certification->description)) !!}</td>
                    </tr>
                    <tr>
                        <th class="py-2 pr-4 font-semibold">参照URL</th>
                        <td class="py-2">
                            @if ($certification->url)
                                <a href="{{ $certification->url }}" target="_blank"
                                    class="text-blue-600 hover:underline break-all">{{ $certification->url }}</a>
                            @else
                                なし
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- アクションボタン --}}
        <div class="flex gap-3">
            {{-- 一覧に戻るボタン (お知らせ詳細のルート名 admin.announcements.index を置き換え) --}}
            <a href="{{ route('admin.certifications.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>

            {{-- 編集ボタン (お知らせ詳細のルート名 admin.announcements.edit を置き換え) --}}
            @if(isset($certification->id))
            <a href="{{ route('admin.certifications.edit', $certification->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">編集</a>
            @endif

            {{-- 削除ボタン (資格一覧のコードを移植) --}}
            <form action="{{ route('admin.certifications.destroy', $certification->id) }}" method="POST"
                class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded"
                    onclick="return confirm('この資格情報を削除しますか？')">削除</button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">学習コンテンツ一覧</h1>

        @php
            $typeLabels = [
                'book' => '1. 本',
                'site' => '2. サイト',
                'video' => '3. 動画',
                'article' => '4. 記事',
            ];
        @endphp

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">種類</th>
                    <th class="border px-2 py-1">タイトル</th>
                    <th class="border px-2 py-1">URL</th>
                    <th class="border px-2 py-1">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($learnings as $learning)
                    <tr>
                        <td class="border px-2 py-1">{{ $learning->id }}</td>
                        <td class="border px-2 py-1">{{ $typeLabels[$learning->type] ?? $learning->type }}</td>
                        <td class="border px-2 py-1">{{ $learning->name }}</td>
                        <td class="border px-2 py-1">{{ $learning->url }}</td>
                        <td class="border px-2 py-1">
                            <a href="{{ route('learning.edit', $learning->id) }}" class="text-blue-600">編集</a>
                            <form action="{{ route('learning.destroy', $learning->id) }}" method="POST" class="inline">
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
@endsection

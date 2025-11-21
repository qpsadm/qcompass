@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">資格一覧</h1>

        @php
            $levelLabels = [
                1 => '初級',
                2 => '上級',
            ];
        @endphp

        <a href="{{ route('admin.learnings.create') }}"
            class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">資格名</th>
                    <th class="border px-2 py-1">資格レベル</th>
                    <th class="border px-2 py-1">説明・備考</th>
                    <th class="border px-2 py-1">参照URL</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($learnings as $learning)
                    <tr>
                        <td class="border px-2 py-1">{{ $learning->id }}</td>
                        <td class="border px-2 py-1">{{ $typeLabels[$learning->type] ?? $learning->type }}</td>
                        <td class="border px-2 py-1">{{ $learning->title }}</td>
                        <td class="border px-2 py-1">{{ $learning->description }}</td>
                        <td class="border px-2 py-1">
                            @if ($learning->image)
                                <img src="{{ $learning->image }}" alt="" class="w-16 h-16 object-cover">
                            @endif
                        </td>
                        <td class="border px-2 py-1">
                            @if ($learning->url)
                                <a href="{{ $learning->url }}" target="_blank" class="text-blue-600 underline">リンク</a>
                            @endif
                        </td>
                        <td class="border px-2 py-1">{{ $levelLabels[$learning->level] ?? $learning->level }}</td>
                        <td class="border px-2 py-1">{{ $learning->display_flag ? '公開' : '非公開' }}</td>
                        <td class="border px-2 py-1">
                            <a href="{{ route('admin.learnings.edit', $learning->id) }}" class="text-blue-600">編集</a>

                            <form action="{{ route('admin.learnings.destroy', $learning->id) }}" method="POST"
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
@endsection

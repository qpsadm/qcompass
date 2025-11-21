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
                        <a href="{{ route('admin.certifications.edit', $certification->id) }}" class="text-blue-600">編集</a>

                        <form action="{{ route('admin.certifications.destroy', $certification->id) }}" method="POST" class="inline">
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

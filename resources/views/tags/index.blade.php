@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tag一覧</h1>
    <a href="{{ route('tags.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>code</th>
<th class='border px-4 py-2'>name</th>
<th class='border px-4 py-2'>tag_type</th>
<th class='border px-4 py-2'>theme_color</th>
<th class='border px-4 py-2'>description</th>
<th class='border px-4 py-2'>deleted_at</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $Tag)
            <tr>
                <td class='border px-4 py-2'>{{ $Tag->code }}</td>
<td class='border px-4 py-2'>{{ $Tag->name }}</td>
<td class='border px-4 py-2'>{{ $Tag->tag_type }}</td>
<td class='border px-4 py-2'>{{ $Tag->theme_color }}</td>
<td class='border px-4 py-2'>{{ $Tag->description }}</td>
<td class='border px-4 py-2'>{{ $Tag->deleted_at }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('tags.show', $Tag->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('tags.edit', $Tag->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('tags.destroy', $Tag->id) }}" method="POST" class="inline-block ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
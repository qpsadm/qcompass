@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Organizer一覧</h1>
    <a href="{{ route('organizer.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>name</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organizer as $Organizer)
            <tr>
                <td class='border px-4 py-2'>{{ $Organizer->name }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('organizer.show', $Organizer->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('organizer.edit', $Organizer->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('organizer.destroy', $Organizer->id) }}" method="POST" class="inline-block ml-2">
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
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Question一覧</h1>
    <a href="{{ route('questions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>asker_id</th>
<th class='border px-4 py-2'>agenda_id</th>
<th class='border px-4 py-2'>course_id</th>
<th class='border px-4 py-2'>title</th>
<th class='border px-4 py-2'>responder_id</th>
<th class='border px-4 py-2'>content</th>
<th class='border px-4 py-2'>answer</th>
<th class='border px-4 py-2'>is_show</th>
<th class='border px-4 py-2'>deleted_at</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $Question)
            <tr>
                <td class='border px-4 py-2'>{{ $Question->asker_id }}</td>
<td class='border px-4 py-2'>{{ $Question->agenda_id }}</td>
<td class='border px-4 py-2'>{{ $Question->course_id }}</td>
<td class='border px-4 py-2'>{{ $Question->title }}</td>
<td class='border px-4 py-2'>{{ $Question->responder_id }}</td>
<td class='border px-4 py-2'>{{ $Question->content }}</td>
<td class='border px-4 py-2'>{{ $Question->answer }}</td>
<td class='border px-4 py-2'>{{ $Question->is_show }}</td>
<td class='border px-4 py-2'>{{ $Question->deleted_at }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('questions.show', $Question->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('questions.edit', $Question->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('questions.destroy', $Question->id) }}" method="POST" class="inline-block ml-2">
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
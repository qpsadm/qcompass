@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Quiz一覧</h1>
    <a href="{{ route('quizzes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>code</th>
<th class='border px-4 py-2'>title</th>
<th class='border px-4 py-2'>description</th>
<th class='border px-4 py-2'>course_id</th>
<th class='border px-4 py-2'>agenda_id</th>
<th class='border px-4 py-2'>type</th>
<th class='border px-4 py-2'>time_limit</th>
<th class='border px-4 py-2'>total_score</th>
<th class='border px-4 py-2'>passing_score</th>
<th class='border px-4 py-2'>random_order</th>
<th class='border px-4 py-2'>active_from</th>
<th class='border px-4 py-2'>active_to</th>
<th class='border px-4 py-2'>created_by</th>
<th class='border px-4 py-2'>deleted_at</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes as $Quiz)
            <tr>
                <td class='border px-4 py-2'>{{ $Quiz->code }}</td>
<td class='border px-4 py-2'>{{ $Quiz->title }}</td>
<td class='border px-4 py-2'>{{ $Quiz->description }}</td>
<td class='border px-4 py-2'>{{ $Quiz->course_id }}</td>
<td class='border px-4 py-2'>{{ $Quiz->agenda_id }}</td>
<td class='border px-4 py-2'>{{ $Quiz->type }}</td>
<td class='border px-4 py-2'>{{ $Quiz->time_limit }}</td>
<td class='border px-4 py-2'>{{ $Quiz->total_score }}</td>
<td class='border px-4 py-2'>{{ $Quiz->passing_score }}</td>
<td class='border px-4 py-2'>{{ $Quiz->random_order }}</td>
<td class='border px-4 py-2'>{{ $Quiz->active_from }}</td>
<td class='border px-4 py-2'>{{ $Quiz->active_to }}</td>
<td class='border px-4 py-2'>{{ $Quiz->created_by }}</td>
<td class='border px-4 py-2'>{{ $Quiz->deleted_at }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('quizzes.show', $Quiz->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('quizzes.edit', $Quiz->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('quizzes.destroy', $Quiz->id) }}" method="POST" class="inline-block ml-2">
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
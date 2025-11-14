@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">QuestionChoice一覧</h1>
    <a href="{{ route('question_choices.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>question_id</th>
<th class='border px-4 py-2'>choice_text</th>
<th class='border px-4 py-2'>is_correct</th>
<th class='border px-4 py-2'>order</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($question_choices as $QuestionChoice)
            <tr>
                <td class='border px-4 py-2'>{{ $QuestionChoice->question_id }}</td>
<td class='border px-4 py-2'>{{ $QuestionChoice->choice_text }}</td>
<td class='border px-4 py-2'>{{ $QuestionChoice->is_correct }}</td>
<td class='border px-4 py-2'>{{ $QuestionChoice->order }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('question_choices.show', $QuestionChoice->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('question_choices.edit', $QuestionChoice->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('question_choices.destroy', $QuestionChoice->id) }}" method="POST" class="inline-block ml-2">
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
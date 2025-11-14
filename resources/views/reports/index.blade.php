@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Report一覧</h1>
    <a href="{{ route('reports.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>user_id</th>
<th class='border px-4 py-2'>course_id</th>
<th class='border px-4 py-2'>date</th>
<th class='border px-4 py-2'>title</th>
<th class='border px-4 py-2'>content</th>
<th class='border px-4 py-2'>impression</th>
<th class='border px-4 py-2'>notice</th>
<th class='border px-4 py-2'>created_user_id</th>
<th class='border px-4 py-2'>updated_user_id</th>
<th class='border px-4 py-2'>deleted_at</th>
<th class='border px-4 py-2'>deleted_user_id</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $Report)
            <tr>
                <td class='border px-4 py-2'>{{ $Report->user_id }}</td>
<td class='border px-4 py-2'>{{ $Report->course_id }}</td>
<td class='border px-4 py-2'>{{ $Report->date }}</td>
<td class='border px-4 py-2'>{{ $Report->title }}</td>
<td class='border px-4 py-2'>{{ $Report->content }}</td>
<td class='border px-4 py-2'>{{ $Report->impression }}</td>
<td class='border px-4 py-2'>{{ $Report->notice }}</td>
<td class='border px-4 py-2'>{{ $Report->created_user_id }}</td>
<td class='border px-4 py-2'>{{ $Report->updated_user_id }}</td>
<td class='border px-4 py-2'>{{ $Report->deleted_at }}</td>
<td class='border px-4 py-2'>{{ $Report->deleted_user_id }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('reports.show', $Report->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('reports.edit', $Report->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('reports.destroy', $Report->id) }}" method="POST" class="inline-block ml-2">
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
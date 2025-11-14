@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Agenda一覧</h1>
    <a href="{{ route('agendas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>agenda_name</th>
<th class='border px-4 py-2'>category_id</th>
<th class='border px-4 py-2'>description</th>
<th class='border px-4 py-2'>is_show</th>
<th class='border px-4 py-2'>user_id</th>
<th class='border px-4 py-2'>accept</th>
<th class='border px-4 py-2'>created_user_id</th>
<th class='border px-4 py-2'>updated_user_id</th>
<th class='border px-4 py-2'>deleted_at</th>
<th class='border px-4 py-2'>deleted_user_id</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agendas as $Agenda)
            <tr>
                <td class='border px-4 py-2'>{{ $Agenda->agenda_name }}</td>
<td class='border px-4 py-2'>{{ $Agenda->category_id }}</td>
<td class='border px-4 py-2'>{{ $Agenda->description }}</td>
<td class='border px-4 py-2'>{{ $Agenda->is_show }}</td>
<td class='border px-4 py-2'>{{ $Agenda->user_id }}</td>
<td class='border px-4 py-2'>{{ $Agenda->accept }}</td>
<td class='border px-4 py-2'>{{ $Agenda->created_user_id }}</td>
<td class='border px-4 py-2'>{{ $Agenda->updated_user_id }}</td>
<td class='border px-4 py-2'>{{ $Agenda->deleted_at }}</td>
<td class='border px-4 py-2'>{{ $Agenda->deleted_user_id }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('agendas.show', $Agenda->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('agendas.edit', $Agenda->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('agendas.destroy', $Agenda->id) }}" method="POST" class="inline-block ml-2">
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
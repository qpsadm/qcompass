@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">        <h1 class="text-2xl font-bold mb-4">講座アジェンダ一覧</h1>
        <a href="{{ route('course_agendas.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>講座ID</th>
                    <th class='border px-4 py-2'>アジェンダID</th>
                    <th class='border px-4 py-2'>並び順</th>
                    <th class='border px-4 py-2'>備考</th>
                    <th class='border px-4 py-2'>削除日</th>

                    <th class='border px-4 py-2'>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course_agendas as $CourseAgenda)
                    <tr>
                        <td class='border px-4 py-2'>{{ $CourseAgenda->course_id }}</td>
                        <td class='border px-4 py-2'>{{ $CourseAgenda->agenda_id }}</td>
                        <td class='border px-4 py-2'>{{ $CourseAgenda->order_no }}</td>
                        <td class='border px-4 py-2'>{{ $CourseAgenda->note }}</td>
                        <td class='border px-4 py-2'>{{ $CourseAgenda->deleted_at }}</td>

                        <td class='border px-4 py-2'>
                            <a href="{{ route('course_agendas.show', $CourseAgenda->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('course_agendas.edit', $CourseAgenda->id) }}"
                                class="text-blue-600 ml-2">編集</a>
                            <form action="{{ route('course_agendas.destroy', $CourseAgenda->id) }}" method="POST"
                                class="inline-block ml-2">
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

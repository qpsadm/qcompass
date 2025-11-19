@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">    <h1 class="text-2xl font-bold mb-4">講座アジェンダ詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>講座ID:</strong> {{ $CourseAgenda->course_id }}</p>
<p><strong>アジェンダID:</strong> {{ $CourseAgenda->agenda_id }}</p>
<p><strong>並び順:</strong> {{ $CourseAgenda->order_no }}</p>
<p><strong>備考:</strong> {{ $CourseAgenda->note }}</p>
<p><strong>削除日:</strong> {{ $CourseAgenda->deleted_at }}</p>

    </div>
    <a href="{{ route('course_agendas.edit', $CourseAgenda->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('course_agendas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">CourseAgenda詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>course_id:</strong> {{ $CourseAgenda->course_id }}</p>
<p><strong>agenda_id:</strong> {{ $CourseAgenda->agenda_id }}</p>
<p><strong>order_no:</strong> {{ $CourseAgenda->order_no }}</p>
<p><strong>note:</strong> {{ $CourseAgenda->note }}</p>
<p><strong>deleted_at:</strong> {{ $CourseAgenda->deleted_at }}</p>

    </div>
    <a href="{{ route('course_agendas.edit', $CourseAgenda->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('course_agendas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection
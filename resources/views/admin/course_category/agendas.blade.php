@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">{{ $course->course_name }} のアジェンダ一覧</h1>

    @foreach ($course->categories as $category)
    <h2 class="font-semibold mt-6 text-lg border-b pb-1">{{ $category->name }}</h2>

    @if ($category->agendas->count())
    <ul class="mt-2 space-y-1">
        @foreach ($category->agendas as $agenda)
        <li class="p-2 bg-gray-100 rounded">
            <a href="{{ route('admin.agendas.preview', $agenda->id) }}" target="_blank" class="text-blue-600 hover:underline">
                {{ $agenda->agenda_name }}
            </a>
        </li>
        @endforeach
    </ul>
    @else
    <p class="text-gray-400 mt-2">アジェンダなし</p>
    @endif
    @endforeach
</div>
@endsection

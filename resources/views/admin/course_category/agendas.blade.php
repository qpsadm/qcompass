@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

        {{-- タイトルと戻るボタン --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">{{ $course->course_name }} のアジェンダ一覧</h1>
            <a href="{{ url()->previous() }}"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>戻る</span>
            </a>
        </div>

        @foreach ($course->categories as $category)
            <div class="mt-6">
                <h2 class="font-semibold text-lg border-b border-gray-300 pb-1">{{ $category->name }}</h2>

                @if ($category->agendas->count())
                    <ul class="mt-2 space-y-2">
                        @foreach ($category->agendas as $agenda)
                            <li class="p-3 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100 transition">
                                <a href="{{ route('admin.agendas.preview', $agenda->id) }}" target="_blank"
                                    class="text-blue-600 hover:underline font-medium">
                                    {{ $agenda->agenda_name }}
                                </a>
                                <div class="text-xs text-gray-500 mt-1">
                                    状態: {{ $agenda->status === 'yes' ? '承認済み' : '下書き' }} |
                                    表示: {{ $agenda->is_show ? '表示' : '非表示' }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400 mt-2 italic">アジェンダなし</p>
                @endif
            </div>
        @endforeach

    </div>
@endsection

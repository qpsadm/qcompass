@extends('layouts.f_layout')

@section('main-content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">クイズ一覧</h1>

    @forelse($quizzes as $quiz)
    <div class="p-4 border rounded mb-4 shadow">
        <h2 class="font-semibold text-lg">{{ $quiz->title }}</h2>
        <p class="text-gray-600">{{ $quiz->description }}</p>
        <p class="text-sm text-gray-500">
            問題数: {{ $quiz->questions_count }}
        </p>
        <a href="{{ route('user.quizzes.show', $quiz->id) }}"
            class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            開始する
        </a>
    </div>
    @empty
    <p>表示できるクイズはありません</p>
    @endforelse
</div>
@endsection

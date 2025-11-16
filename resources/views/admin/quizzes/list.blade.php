@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">クイズ一覧</h1>

    <ul>
        @foreach ($quizzes as $quiz)
        <li>{{ $quiz->title }}</li>
        @endforeach
    </ul>
</div>
@endsection

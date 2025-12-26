@extends('layouts.f_layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }}</h1>
    <p class="mb-4">{{ $quiz->description }}</p>

    <form action="{{ route('user.quizzes.submit', $quiz) }}" method="POST">
        @csrf
        @foreach($questions as $q)
        <div class="mb-4 p-4 border rounded">
            <p class="font-semibold">{{ $loop->iteration }}. {{ $q->question_text }}</p>

            @if($q->question_type === 'text')
            <input type="text" name="answers[{{ $q->id }}]" class="border rounded w-full p-2" />
            @elseif($q->question_type === 'single')
            @foreach($q->choices as $choice)
            <label class="block">
                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $choice->id }}">
                {{ $choice->choice_text }}
            </label>
            @endforeach
            @elseif($q->question_type === 'multi')
            @foreach($q->choices as $choice)
            <label class="block">
                <input type="checkbox" name="answers[{{ $q->id }}][]" value="{{ $choice->id }}">
                {{ $choice->choice_text }}
            </label>
            @endforeach
            @endif
        </div>
        @endforeach

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">回答送信</button>
    </form>
</div>
@endsection

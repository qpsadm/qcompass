@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-start justify-center bg-gray-100 pt-10">
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 w-full max-w-xl">
            <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }}</h1>

            <form action="{{ route('user.quizzes.submit', $quiz->id) }}" method="POST">
                @csrf

                @foreach ($questions as $q)
                    <div class="mb-4">
                        <p class="font-bold">{{ $q->question_text }} ({{ $q->score }}点)</p>

                        @if ($q->question_type === 'text')
                            <input type="text" name="answers[{{ $q->id }}]" class="border p-2 w-full">
                        @else
                            @foreach ($q->choices as $choice)
                                <label class="block">
                                    <input type="{{ $q->question_type === 'multi' ? 'checkbox' : 'radio' }}"
                                        name="answers[{{ $q->id }}]{{ $q->question_type === 'multi' ? '[]' : '' }}"
                                        value="{{ $choice->id }}">
                                    {{ $choice->choice_text }}
                                </label>
                            @endforeach
                        @endif
                    </div>
                @endforeach

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">回答する</button>
            </form>
        </div>
    @endsection

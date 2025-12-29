@extends('layouts.f_layout')

@section('main-content')

<div class="container mx-auto p-4 max-w-3xl">

    {{-- クイズ情報 --}}
    <h1 class="text-2xl font-bold mb-2">{{ $quiz->title }}</h1>
    <p class="text-gray-600 mb-6">{{ $quiz->description }}</p>

    <form method="POST" action="{{ route('user.quizzes.submit', $quiz) }}">
        @csrf

        @foreach ($questions as $index => $question)
        <div class="mb-6 p-4 border rounded shadow-sm">
            {{-- 問題番号 --}}
            <h2 class="font-semibold mb-3">
                問題 {{ $index + 1 }}（{{ $question->score }}点）
            </h2>

            {{-- 問題文 --}}
            <p class="mb-4">{{ $question->question_text }}</p>

            {{-- 単一選択 --}}
            @if ($question->type === 'single')
            @foreach ($question->choices as $choice)
            <label class="block mb-2">
                <input type="radio"
                    name="answers[{{ $question->id }}]"
                    value="{{ $choice->id }}"
                    class="mr-2">
                {{ $choice->choice_text }}
            </label>
            @endforeach

            {{-- 複数選択 --}}
            @elseif ($question->type === 'multi')
            @foreach ($question->choices as $choice)
            <label class="block mb-2">
                <input type="checkbox"
                    name="answers[{{ $question->id }}][]"
                    value="{{ $choice->id }}"
                    class="mr-2">
                {{ $choice->choice_text }}
            </label>
            @endforeach

            {{-- 記述式 --}}
            @elseif ($question->type === 'text')
            <textarea
                name="answers[{{ $question->id }}]"
                rows="3"
                class="w-full border rounded p-2"
                placeholder="回答を入力してください"></textarea>
            @endif
        </div>
        @endforeach

        {{-- 送信 --}}
        <div class="text-center mt-8">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                回答を送信
            </button>
        </div>

        <a href="{{ route('user.quizzes.index') }}"
            class="inline-block mb-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            ← クイズ一覧に戻る
        </a>
    </form>

</div>
@endsection

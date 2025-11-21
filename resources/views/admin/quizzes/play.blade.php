@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">クイズプレイ: {{ $quiz->title }}</h1>

        @if($questions->isEmpty())
        <p class="text-gray-600">まだ問題が登録されていません。</p>
        @else
        <form action="#" method="POST">
            @csrf
            @foreach ($questions as $index => $question)
            <div class="mb-6 border-b pb-4">
                <p class="font-semibold mb-2">Q{{ $index + 1 }}: {{ $question->question_text }}</p>

                @if($question->question_type === 'text')
                <input type="text" name="answers[{{ $question->id }}]"
                    class="border px-3 py-2 w-full rounded mb-2">
                @else
                @foreach($question->choices as $choice)
                <label class="block mb-1">
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}">
                    {{ $choice->choice_text }}
                </label>
                @endforeach
                @endif
            </div>
            @endforeach

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                提出
            </button>
        </form>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.quizzes.index') }}" class="text-gray-600 hover:underline">
                クイズ一覧に戻る
            </a>
        </div>
    </div>
</div>
@endsection

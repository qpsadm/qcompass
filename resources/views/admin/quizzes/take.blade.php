@extends('layouts.app')

@section('content')
<h1>{{ $quiz->title }}</h1>
<form method="POST" action="{{ route('admin.quizzes.submit', $quiz) }}">
    @csrf

    @foreach($questions as $q)
    <div>
        <p>{{ $loop->iteration }}. {{ $q->question_text }}</p>
        @if($q->question_type == 'text')
        <input type="text" name="answers[{{ $q->id }}]">
        @elseif($q->question_type == 'single' || $q->question_type == 'multiple')
        @foreach($q->choices as $choice)
        <label>
            <input type="{{ $q->question_type=='single'?'radio':'checkbox' }}"
                name="answers[{{ $q->id }}][]"
                value="{{ $choice->id }}">
            {{ $choice->choice_text }}
        </label><br>
        @endforeach
        @elseif($q->question_type == 'boolean')
        <label><input type="radio" name="answers[{{ $q->id }}][]" value="1"> 正しい</label>
        <label><input type="radio" name="answers[{{ $q->id }}][]" value="0"> 間違い</label>
        @endif
    </div>
    @endforeach

    <button type="submit">提出</button>
</form>
@endsection

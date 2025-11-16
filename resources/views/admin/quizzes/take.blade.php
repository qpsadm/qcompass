<form method="POST" action="{{ url('quizzes/'.$quiz->id.'/submit') }}">
    @csrf
    @foreach($questions as $question)
    <div>
        <p>{{ $question->question_text }}</p>
        @foreach($question->choices as $choice)
        <label>
            <input type="{{ $question->question_type=='multiple' ? 'checkbox' : 'radio' }}"
                name="answers[{{ $question->id }}]{{ $question->question_type=='multiple' ? '[]' : '' }}"
                value="{{ $choice->id }}">
            {{ $choice->choice_text }}
        </label>
        @endforeach
    </div>
    @endforeach
    <button type="submit">提出</button>
</form>

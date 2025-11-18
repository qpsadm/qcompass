@extends('layouts.app')
@section('content')
<h1>クイズ編集: {{ $quiz->title }}</h1>

<a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}">新しい問題を追加</a>
<a href="{{ route('admin.quizzes.quiz_questions.index', $quiz->id) }}">問題一覧</a>

<form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $quiz->title }}" required>
    <select name="course_id">
        <option value="">コース選択</option>
        @foreach($courses as $course)
        <option value="{{ $course->id }}" @selected($quiz->course_id==$course->id)>{{ $course->name }}</option>
        @endforeach
    </select>
    <select name="type" required>
        <option value="1" @selected($quiz->type==1)>試験</option>
        <option value="2" @selected($quiz->type==2)>アンケート</option>
        <option value="3" @selected($quiz->type==3)>練習</option>
    </select>
    <button type="submit">保存</button>
</form>
@endsection

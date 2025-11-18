@extends('layouts.app')
@section('content')
<h1>クイズ作成</h1>

<form action="{{ route('admin.quizzes.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="タイトル" required>
    <select name="course_id">
        <option value="">コース選択</option>
        @foreach($courses as $course)
        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
        @endforeach
    </select>
    <select name="type" required>
        <option value="1">試験</option>
        <option value="2">アンケート</option>
        <option value="3">練習</option>
    </select>
    <button type="submit">作成</button>
</form>
@endsection

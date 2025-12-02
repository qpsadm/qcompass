@extends('layouts.f_layout')

@section('main-content')
<div class="container">
    <h2>受講講座情報</h2>

    <div class="course-detail">
        <h3>{{ $course->course_name }}</h3>
        <p>{{ $course->description }}</p>
<a href="{{$course->plan_path }}">リンク</a>

        <p>開始日: {{ $course->start_date ?? '---' }}</p>
        <p>終了日: {{ $course->end_date ?? '---' }}</p>
    </div>
</div>
@endsection

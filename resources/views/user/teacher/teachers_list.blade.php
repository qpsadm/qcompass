@extends('layouts.f_layout')

@section('title', '講師一覧')

@section('main-content')
<div class="container">

    <div class="page-title">
        <h2>講師一覧</h2>
    </div>

    @if ($teachers->isEmpty())
    <p>あなたの講座に担当の先生はいません。</p>
    @else
    <ul class="teacher-list">
        @foreach ($teachers as $teacher)
        <li class="teacher-item">
            <a href="{{ route('user.teacher.teachers_info', $teacher->id) }}">
                <div class="teacher-name">{{ $teacher->name }}</div>
                <div class="teacher-division">
                    所属：{{ $teacher->division->name ?? '未設定' }}
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    @endif

</div>
@endsection

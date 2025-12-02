@extends('layouts.f_layout')

@section('main-content')
<div class="container">

    <div class="page-title">
        <h2>先生詳細</h2>
    </div>

    <div class="teacher-detail">

        <p><strong>氏名：</strong> {{ $teacher->name }}</p>
        <p><strong>フリガナ：</strong> {{ $teacher->furigana }}</p>
        <p><strong>ローマ字：</strong> {{ $teacher->roman_name }}</p>
        <p><strong>ユーザーコード：</strong> {{ $teacher->code }}</p>
        <p><strong>メールアドレス：</strong> {{ $teacher->email }}</p>
        <p><strong>所属部署：</strong> {{ $teacher->division->name ?? '未設定' }}</p>
        <hr>

        <a href="{{ route('user.teacher.teachers_list') }}" class="btn btn-secondary">
            一覧に戻る
        </a>
    </div>

</div>
@endsection

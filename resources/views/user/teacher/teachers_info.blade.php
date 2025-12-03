@extends('layouts.f_layout')

@section('title', '講師紹介')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_course.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="講師紹介（{{ $teacher->name }}）" />

        <div class="teacher-detail">

            <div class="teacher-profile">
                <div class="profile-left">
                    <div class="teacher-image">
                        <img src="{{ asset('storage/' . $teacher->detail->avatar_path) }}" alt="avatar">
                    </div>
                    <div class="teacher-name">
                        <p>{{ $teacher->name }}<br>（{{ $teacher->furigana }}）</p>
                    </div>
                </div>

                {!! $teacher->detail->bio !!}

            </div>

            <x-f_btn_list :prevBtn="false" :nextBtn="false" :listBtn="true"
                listUrl="{{ route('user.teacher.teachers_list') }}" listLabel="一覧へ" />

            <x-f_bread_crumbs />

        </div>

    </div>
@endsection

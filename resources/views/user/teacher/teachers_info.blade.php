@extends('layouts.f_layout')

@section('title', '講師紹介')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_course.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="講師紹介（{{ $teacher->name }}先生）" />

        <div class="teacher-detail">

            <div class="teacher-profile">
                <div class="profile-left">
                    <div class="teacher-image">
                        <img src="{{-- {{ $teacher->detail->avatar_path }} --}}https://qlip-programming.com/jobtrain/wp-content/uploads/2025/07/fukushima-Masakiyo-Fukushima-402x400.jpg" alt="">
                    </div>
                    <div class="teacher-name">
                        <p>{{ $teacher->name }}（{{ $teacher->furigana }}）先生</p>
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

@extends('layouts.f_layout')

@section('title', '講師一覧')

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="講師一覧" />

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

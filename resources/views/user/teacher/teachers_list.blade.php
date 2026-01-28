@extends('layouts.f_layout')

@section('title', '講師一覧')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_course.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="講師一覧" />

        <!-- コンテンツ一覧 -->
        <div class="teacher-list">
            @if ($teachers->isEmpty())
                <p>あなたの講座に担当の先生はいません。</p>
            @else
                <ul>
                    @foreach ($teachers as $index => $teacher)
                        <li>
                            <a href="{{ route('user.teacher.teachers_info', $teacher->id) }}">
                                <p>{{ $teacher->name }}（{{ $teacher->furigana }}）先生</p>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- ページネーション -->
                <div>
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>

        <!-- ボタンリスト -->
        <x-f_btn_list :prevBtn="false" :nextBtn="false" :listBtn="true" listUrl="{{ route('user.top') }}"
            listLabel="トップへもどる" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection

@extends('layouts.f_layout')

@section('title', '講座情報')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_course.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="講座情報" />

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div
            class="page-content
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">

            <table>
                <tr>
                    <td class="table-title">
                        <p>講座名</p>
                    </td>
                    <td class="table-text">
                        <h3>{{ $course->course_name }}</h3>
                    </td>
                </tr>
                <tr>
                    <td class="table-title">
                        <p>概要</p>
                    </td>
                    <td class="table-text">
                        <p>{!! nl2br(e($course->description)) !!}</p>
                    </td>
                </tr>
                <tr>
                    <td class="table-title">
                        <p>開始日</p>
                    </td>
                    <td class="table-text">
                        <p>{{ $course->start_date ?? '---' }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="table-title">
                        <p>終了日</p>
                    </td>
                    <td class="table-text">
                        <p>{{ $course->end_date ?? '---' }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="table-title">
                        <p>日別計画表</p>
                    </td>
                    <td class="table-text"><a href="{{ asset('storage/' . $course->plan_path) }}"
                            target="_blank">日別計画表を開く</a>
                </tr>
                <tr>
                    <td class="table-title">
                        <p>パンフレット</p>
                    </td>
                    <td class="table-text"><a href="{{ asset('storage/' . $course->flier_path) }}"
                            target="_blank">パンフレットを開く</a></td>
                </tr>
            </table>
        </div>

        <!-- ボタンリスト -->
        <x-f_btn_list :prevBtn="false" :nextBtn="false" :listBtn="true" listUrl="{{ route('user.news.news_list') }}"
            listLabel="トップへもどる" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection

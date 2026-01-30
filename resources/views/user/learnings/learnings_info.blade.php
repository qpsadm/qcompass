@extends('layouts.f_layout')

@section('title', '制作品紹介 -' . $learning->title)

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_learnings.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="制作品紹介 - {{ $learning->title }}" />

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div
            class="info-container
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">

            @if ($learning->image)
                <img src="{{ asset('storage/' . $learning->image) }}" class="learning-img">
            @endif

            <table class="info-table">
                <tr>
                    <td class="title">
                        <p>作成者</p>
                    </td>
                    <td class="text">{{ $learning->course_name }}</td>
                </tr>
                <tr>
                    <td class="title">
                        <p>作成日時</p>
                    </td>
                    <td class="text">{{ $learning->priod }}</td>
                </tr>
                <tr>
                    <td class="title">
                        <p>作品紹介</p>
                    </td>
                    <td class="text">{!! nl2br(e($learning->description)) !!}</td>
                </tr>
                <tr>
                    <td class="title">
                        <p>サイトURL</p>
                    </td>
                    <td class="text url"><a href="{{ $learning->url }}" target="_blank">{{ $learning->url }}</a></td>
                </tr>
            </table>
        </div>

        <!-- ボタンリスト -->
        <div class="btn-list">
            <ul>
                <li class="short-btn">
                    @if ($prevLearning)
                        <a href="{{ route('user.learnings.learnings_info', ['learning' => $prevLearning->id, 'type' => $typeId]) }}">前へ</a>
                    @endif
                </li>
                <li class="default-btn">
                    <a href="{{ $typeId ? route('user.learnings.learnings_by_type', ['type' => $typeId]) : route('user.learnings.learnings_list') }}">
                        一覧へもどる
                    </a>
                </li>
                <li class="short-btn">
                    @if ($nextLearning)
                        <a href="{{ route('user.learnings.learnings_info', ['learning' => $nextLearning->id, 'type' => $typeId]) }}">次へ</a>
                    @endif
                </li>
            </ul>
        </div>

        <!-- パンくずリスト -->
        <div class="bread-crumbs">
            {{ Breadcrumbs::render('auto') }}
        </div>

    </div>
@endsection

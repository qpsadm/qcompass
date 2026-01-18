@extends('layouts.f_layout')

@section('title', '制作品紹介 -' . $learning->title)

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_learnings.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="制作品紹介 - {{ $learning->title }}" />

        <div class="info-container">

            @if ($learning->image)
                <img src="{{ asset('storage/' . $learning->image) }}" class="learning-img">
            @endif

            <table class="info-table">
                <tr>
                    <td class="title"><p>作成者</p></td>
                    <td class="text">{{ $learning->course_name }}</td>
                </tr>
                <tr>
                    <td class="title"><p>作成日時</p></td>
                    <td class="text">{{ $learning->priod }}</td>
                </tr>
                <tr>
                    <td class="title"><p>作品紹介</p></td>
                    <td class="text">{!! nl2br(e($learning->description)) !!}</td>
                </tr>
                <tr>
                    <td class="title"><p>サイトURL</p></td>
                    <td class="text url"><a href="{{ $learning->url }}" target="_blank">{{ $learning->url }}</a></td>
                </tr>
            </table>
        </div>

        <div class="flex justify-between mt-6">
            <div>
                @if ($prevLearning)
                    <a href="{{ route('user.learnings.learnings_info', ['learning' => $prevLearning->id, 'type' => $typeId]) }}"
                        class="btn btn-primary">前へ</a>
                @endif
            </div>

            <div>
                <a href="{{ $typeId ? route('user.learnings.learnings_by_type', ['type' => $typeId]) : route('user.learnings.learnings_list') }}"
                    class="btn btn-secondary">
                    {{ $breadcrumbTitle ?? '一覧' }}に戻る
                </a>
            </div>

            <div>
                @if ($nextLearning)
                    <a href="{{ route('user.learnings.learnings_info', ['learning' => $nextLearning->id, 'type' => $typeId]) }}"
                        class="btn btn-primary">次へ</a>
                @endif
            </div>
        </div>
        <div class="bread-crumbs">
            {{ Breadcrumbs::render('auto') }}
        </div>
    </div>
@endsection

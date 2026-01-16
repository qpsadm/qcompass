@extends('layouts.f_layout')

@section('title', $breadcrumbTitle)

@section('main-content')
<div class="container">

    <x-f_page_title :search="false" title="{{ $learning->title }}" />

    <div class="page-content my-4">
        <div>{!! $learning->description !!}</div>
    </div>

    <div class="flex justify-between mt-6">
        <div>
            @if($prevLearning)
            <a href="{{ route('user.learnings.learnings_info', ['learning' => $prevLearning->id, 'type' => $type]) }}" class="btn btn-primary">前へ</a>
            @endif
        </div>

        <div>
            <a href="{{ $type ? route('user.learnings.learnings_by_type', ['type' => $type]) : route('user.learnings.learnings_list') }}" class="btn btn-secondary">
                {{ $breadcrumbTitle ?? '一覧' }}に戻る
            </a>
        </div>

        <div>
            @if($nextLearning)
            <a href="{{ route('user.learnings.learnings_info', ['learning' => $nextLearning->id, 'type' => $type]) }}" class="btn btn-primary">次へ</a>
            @endif
        </div>
    </div>
    <div class="bread-crumbs">
        {{ Breadcrumbs::render('auto') }}
    </div>
</div>
@endsection

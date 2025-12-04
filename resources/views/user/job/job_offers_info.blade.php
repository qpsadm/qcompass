@extends('layouts.f_layout')

@section('title', $job->title)

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
<div class="container">

    {{-- ページタイトル --}}
    <x-f_page_title :search="false" title="{{ $job->title }}" />

    {{-- 求人内容 --}}
    <div class="page-content
        @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
        <div>{!! $job->description !!}</div>

        {{-- PDFダウンロード --}}
        @if ($job->file_path)
        <div class="mt-4">
            <a href="{{ asset('storage/job_offers/' . basename($job->file_path)) }}" target="_blank"
                class="btn btn-primary">
                PDF を開く
            </a>
        </div>
        @endif
    </div>

    {{-- 前後ボタン --}}
    @php
    $prevUrl = $prevJob ? route('user.job.job_offers_info', $prevJob->id) : null;
    $nextUrl = $nextJob ? route('user.job.job_offers_info', $nextJob->id) : null;
    @endphp

    <x-f_btn_list
        :prevBtn="(bool)$prevJob"
        :nextBtn="(bool)$nextJob"
        :prevUrl="$prevUrl"
        :nextUrl="$nextUrl"
        :listBtn="true"
        listUrl="{{ url('user/job') }}"
        listLabel="一覧へもどる" />

    {{-- パンくず --}}
    <x-f_bread_crumbs />

</div>
@endsection

@extends('layouts.f_layout')

@section('title', $jobOffer->title)

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
<div class="container">

    {{-- ページタイトル --}}
    <x-f_page_title :search="false" title="{{ $jobOffer->title }}" />

    {{-- 求人内容 --}}
    <div class="page-content
        @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
        <div>{!! $jobOffer->description !!}</div>

        {{-- PDFダウンロード --}}
        @if ($jobOffer->file_path)
        <div class="mt-4">
            <a href="{{ asset('storage/job_offers/' . basename($jobOffer->file_path)) }}" target="_blank"
                class="btn btn-primary">
                PDF を開く
            </a>
        </div>
        @endif
    </div>

    {{-- 前後ボタン --}}
    @php
    $prevUrl = $prevJob ? route('user.job.job_offers_info', ['jobOffer' => $prevJob->id]) : null;
    $nextUrl = $nextJob ? route('user.job.job_offers_info', ['jobOffer' => $nextJob->id]) : null;
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

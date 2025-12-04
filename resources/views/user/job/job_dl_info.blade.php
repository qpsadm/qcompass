@extends('layouts.f_layout')

@section('title', $agenda->agenda_name)

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
<div class="container">

    @php
    $prevUrl = $prevAgenda ? route('user.job.job_dl_info', ['id' => $prevAgenda->id]) : null;
    $nextUrl = $nextAgenda ? route('user.job.job_dl_info', ['id' => $nextAgenda->id]) : null;
    @endphp

    <x-f_page_title :search="false" title="{{ $agenda->agenda_name }}" />

    <div class="page-content
        @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">
        <div>{!! $agenda->content !!}</div>
    </div>

    <x-f_btn_list
        :prevBtn="(bool)$prevAgenda"
        :nextBtn="(bool)$nextAgenda"
        :prevUrl="$prevUrl"
        :nextUrl="$nextUrl"
        :listBtn="true"
        listUrl="{{ url('user/job') }}"
        listLabel="一覧へもどる" />

    <x-f_bread_crumbs />
</div>
@endsection

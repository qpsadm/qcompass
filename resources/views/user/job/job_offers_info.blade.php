@extends('layouts.f_layout')


@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection


@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="{{ $job->title }}" />


        <div class="page-content">
            <div>{!! nl2br(e($job->description)) !!}</div>


            @if ($job->file_path)
                <div class="mt-4">
                    <a href="{{ asset($job->file_path) }}" target="_blank" class="btn btn-primary">
                        PDF を開く
                    </a>
                </div>
            @endif
        </div>


        <x-f_btn_list :prevBtn="false" :listBtn="true" :nextBtn="false" listUrl="{{ url('user/job') }}"
            listLabel="一覧画面へ" />


        <x-f_bread_crumbs />
    </div>
@endsection

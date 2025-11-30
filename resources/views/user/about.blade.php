@extends('layouts.f_layout')

@section('title', '本サイトについて')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection


@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="本サイトについて" />

        <x-f_btn_list :prevBtn="false" :listBtn="true" :nextBtn="false" listUrl="{{ route('user.top') }}"
            listLabel="トップへもどる" />

        <x-f_bread_crumbs />
    </div>
@endsection

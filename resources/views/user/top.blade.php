@extends('layouts.f_layout')

@section('title', 'トップページ')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_top.css') }}">
@endsection

@section('main-content')
<div class="container">
    <div class="kv">
        <video id="kv-video" loop autoplay muted></video>
    </div>

    <div class="section-box">
        <div class="box-title">
            <h2>全体のお知らせ</h2>
        </div>
        <div class="box-content">
            <x-f_content_list
                :items="$globalAnnouncements" :is-news="true" />
            <div class="more-btn">
                <a href="{{ route('user.news.main_news') }}">more</a>
            </div>
        </div>
    </div>

    <div class="section-box">
        <div class="box-title">
            <h2>本講座のお知らせ</h2>
        </div>
        <div class="box-content">
            <x-f_content_list
                :items="$courseAnnouncements " :is-news="true" />
            <div class="more-btn">
                <a href="{{ route('user.news.my_news') }}">more</a>
            </div>
        </div>
    </div>

    <div class="section-box">
        <div class="box-title">
            <h2>最新の求人情報</h2>
        </div>
        <div class="box-content">
            <x-f_content_list
                :items="$jobs"
                link-route="user.job.job_offers_info"
                param-name="id" :is-news="false" />
            <div class="more-btn">
                <a href="{{ route('user.job.job_offers_list') }}">more</a>
            </div>
        </div>
    </div>

    <div class="section-flex">

        <div class="section-box facebook">
            <div class="box-title">
                <h2>Facebook</h2>
            </div>
            <div class="facebook-container">
            <iframe
                src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fqlipwebprogrammer&tabs=timeline&width=330&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                width="330" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                allowfullscreen="true"
                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>
        </div>

        <div class="section-box agenda">
            <div class="box-title">
                <h2>最新のアジェンダ</h2>
            </div>
            <div class="box-content">
                <x-f_content_list
                    :items="$agendas"
                    title-field="agenda_name"
                    link-route="user.agenda.info"
                    param-name="id"
                    :is-news="false" />
                <div class="more-btn">
                    <a href="{{ route('user.agenda.agendas_list') }}">more</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('code-page-js')
<script src="../assets/js/f_top.js"></script>
@endsection

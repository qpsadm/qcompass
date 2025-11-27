@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_top.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <div class="kv">
            <video src="../assets/images/f_kvmovie_sample.mp4" loop autoplay muted
                poster="../assets/images/f_thumbnail_sample.jpeg"></video>
        </div>

        <div class="section-box">
            <div class="box-title">
                <h2>全体のお知らせ</h2>
            </div>
            <div class="box-content">
                <x-f_content_list :items="$announcements" />
                <div class="more-btn">
                    <a href="news/news_list_main.html">more</a>
                </div>
            </div>
        </div>

        <div class="section-box">
            <div class="box-title">
                <h2>本講座のお知らせ</h2>
            </div>
            <div class="box-content">
                <x-f_content_list :items="$announcements" />
                <div class="more-btn">
                    <a href="news/news_list_websys.html">more</a>
                </div>
            </div>
        </div>

        <div class="section-box">
            <div class="box-title">
                <h2>最新の求人情報</h2>
            </div>
            <div class="box-content">
                <x-f_content_list :items="$announcements" />
                <div class="more-btn">
                    <a href="support/support_offer_list.html">more</a>
                </div>
            </div>
        </div>

        <div class="section-flex">

            <div class="section-box facebook">
                <div class="box-title">
                    <h2>Facebook</h2>
                </div>
                <iframe
                    src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fqlipwebprogrammer&tabs=timeline&width=330&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                    width="330" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                    allowfullscreen="true"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>

            <div class="section-box agenda">
                <div class="box-title">
                    <h2>最新のアジェンダ</h2>
                </div>
                <div class="box-content">
                    <x-f_content_list :items="$announcements" />
                    <div class="more-btn">
                        <a href="agenda/agenda_list.html">more</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection

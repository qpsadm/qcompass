@extends('layouts.f_layout')

@section('title', '講師紹介')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_course.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="講師紹介（{{ $teacher->name }}先生）" />

        <div class="teacher-detail">

            <div class="teacher-profile">
                <div class="profile-left">
                    <div class="teacher-image">
                        <img src="{{ $teacher->avatar_path }}" alt="">
                    </div>
                    <div class="teacher-name">
                        <p>{{ $teacher->name }}（{{ $teacher->furigana }}）先生</p>
                    </div>
                </div>

                {{ $teacher->detail->bio }}

                <div class="profile-right">
                    <div class="teacher-data">
                        <h3>担当科目</h3>
                        <p>主に、Web関連各種講座において、CMSによるWebサイトの構築演習（WordPress）、LaravelによるWebアプリ作成、Webマーケティング概論、システム開発の品質管理、WEB制作の企画・設計、WEB制作実習、制作プレゼンテーションを担当しています。
                        </p>
                    </div>
                    <div class="teacher-data">
                        <h3>訓練生へ向けて一言</h3>
                        <p>「一期一会」のご縁を大切に、共に学ぶ時間を実りあるものにしましょう。予習・復習・練習を怠らず、焦らず一歩ずつ着実に進んでいきましょう。</p>
                    </div>
                    <div class="teacher-data-flex">
                        <h3>出身地</h3>
                        <span>/</span>
                        <p>中国　福建省</p>
                    </div>
                    <div class="teacher-data-flex">
                        <h3>趣味</h3>
                        <span>/</span>
                        <p>登山・家庭菜園</p>
                    </div>
                    <div class="teacher-data-flex">
                        <h3>座右の銘</h3>
                        <span>/</span>
                        <p>インタビューお願いします。</p>
                    </div>
                </div>

                <div class="teacher-data">
                    <h3>自己紹介</h3>
                    <p>私は中国出身で、現在は日本国籍を取得しております。これまで中国と日本の両国で働いた経験があり、両国の文化や商習慣に精通しております。中国の大学では電子工学を専攻し、卒業後は別の大学で講師として 12
                        年間、教育に携わってまいりました。その後、日本に渡り、情報技術やプログラミングを学び、システム開発の分野へ転身しました。システム開発のキャリアは 15
                        年以上におよび、生産管理、在庫管理、販売管理、電子カルテ、Web サイト、Web アプリケーションなど、さまざまなシステムやアプリの開発および開発管理に従事してまいりました。
                        また、2010
                        年以降はシステム開発に取り組む傍ら、求職者支援訓練において講師としても活動しております。これまで培ってきた知識と経験を活かし、より多くの方々のお役に立てるよう努めてまいります。どうぞよろしくお願いいたします。
                    </p>
                </div>

            </div>

            <x-f_btn_list :prevBtn="false" :nextBtn="false" :listBtn="true"
                listUrl="{{ route('user.teacher.teachers_list') }}" listLabel="一覧へ" />

            <x-f_bread_crumbs />

        </div>

    </div>
@endsection

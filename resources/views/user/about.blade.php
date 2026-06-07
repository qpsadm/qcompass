@extends('layouts.f_layout')

@section('title', '本サイトについて')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームなし） -->
        <x-f_page_title :search="false" title="本サイトについて" />

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div
            class="page-content
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">

            <section>
                <h2>１．『QLIP Compass』について</h2>
                <p>『QLIP Compass』は、国の求職者支援制度に基づき、QLIPプログラミングスクールが運営する「WEBシステム開発実践科
                    第10期」のチーム『道（タオ）』が、WEB制作実習のテーマとして制作したWEBアプリケーションです（以下「本サイト」といいます）。</p>
                <p>QLIPプログラミングスクールでは、これまで「QLIP講習会管理システム」を活用して求職者支援訓練の各種講座を運営してきました。この従来のシステムは、訓練生と講師陣をつなぎ、学習支援から就職活動、さらには修了後のキャリア形成までを幅広くサポートするオンライン求職者支援訓練の管理システムでした。
                </p>
                <p>長年の利用を経てシステムの刷新（リニューアル）の必要性が高まったことから、この課題を契機として、本サイトの制作が実習テーマに採用されました。</p>

                <section>
                    <h3>『QLIP Compass』の主な機能と特徴</h3>
                    <p>本サイトは、求職者支援訓練に関わる講座情報、アジェンダ、各種お知らせ、就職支援、学習サポート、訓練生情報、受講生の日報などを一元的に管理し、関連情報の作成・共有・公開を円滑にすることを目的としています。これにより、学習支援から就職相談まで幅広いサポートを可能にし、運営および管理業務の効率化を図ります。
                    </p>
                    <p>また、日々の学習に関する情報、訓練スケジュール、日報、質疑応答など多くの機能を備えています。さらに、QLIPのFacebookとも連携しており、他の訓練生の活動を閲覧できるため、学習意欲の維持やキャリア形成の参考にもつながります。
                    </p>
                </section>
            </section>

            <section style="margin-top: 60px;">
                <h2>２．制作チーム『道（タオ）』について</h2>
                <div style="margin-bottom: 20px;">
                    <img src="{{ asset('assets/images/f_about.png') }}" alt="チームの集合写真のイラスト"
                        style="width: 70%; height: auto; max-width: 100%;">
                </div>
                <p>本サイトは、20代から60代までの幅広い世代で構成された8名のチーム『道（タオ）』によって制作されました。プログラミングを本格的に学ぶのは初めてのメンバーも多く、当初は不安もありましたが、講師陣の丁寧な指導と仲間同士の励まし合いを通じて確かな技術と知識を習得し、日々の制作に取り組みました。
                </p>
                <p>訓練生の皆さまが快適に利用できるようにとの思いを込め、チーム一丸となってこの『QLIP Compass』を完成させました。</p>


                <section>
                    <h3>本サイトのキービジュアルについて</h3>
                    <p>授業に励む皆さまの心をやさしく癒すことを目的として、徳島の豊かな自然風景をビジュアルに取り入れました。心地よい映像に触れることで、学びの時間がいっそう快適に、よりスムーズに進むことを願っています。
                    </p>
                    <p>また、在校生の参考となり、モチベーション向上にもつながるよう、先輩である修了生の作品も取り入れています。</p>
                </section>

                <section>
                    <h3>キャラクターについて</h3>
                    <p>再就職や転職を目指して新たな分野に挑戦し、訓練に励む皆さんを応援するキャラクターです。「これから大きく成長していく未来のプロフェッショナルたち」という意味を込め、温かみのある「たまご」をモチーフに生まれました。
                    </p>
                </section>
            </section>
        </div>

        <!-- ボタンリスト -->
        <x-f_btn_list :prevBtn="false" :nextBtn="false" :listBtn="true" listUrl="{{ route('user.top') }}"
            listLabel="トップへもどる" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection

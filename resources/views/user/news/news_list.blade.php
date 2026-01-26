@extends('layouts.f_layout')

@section('title', '新着情報一覧')

@section('main-content')
<div class="container">

    <!-- ページタイトル（検索フォームあり） -->
    <x-f_page_title
        title="新着情報一覧"
        :search="true"
        :searchAction="route('user.news.news_list')"
        searchName="search"
        searchPlaceholder="キーワード検索" />

    <!-- カテゴリ一覧 -->
    <x-f_category_list type="news" :category="$category ?? 'all'" />

    <!-- 登録情報の件数判定 -->
    @if($announcements->isEmpty())
    <div>
        <p>該当する新着情報はありません</p>
    </div>
    @else
    <!-- コンテンツ一覧 -->
    <x-f_content_list :items="$announcements" :is-news="true" />
    @endif

    <!-- ページネーション -->
    <x-f_pagination :paginator="$announcements" />

    <!-- パンくずリスト -->
    <x-f_bread_crumbs />

</div>
@endsection

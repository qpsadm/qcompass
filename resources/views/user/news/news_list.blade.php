@extends('layouts.f_layout')

@section('title', '新着情報一覧')

@section('main-content')
<div class="container">
    {{-- ページタイトル + 検索フォーム --}}
    <x-f_page_title
        title="新着情報一覧"
        :search="true"
        :searchAction="route('user.news.news_list')"
        searchName="search"
        searchPlaceholder="キーワード検索"
    />

    <x-f_category_list type="news" :category="$category ?? 'all'" />

    <x-f_content_list :items="$announcements" :is-news="true" />

    <x-f_pagination :paginator="$announcements" />
    <x-f_bread_crumbs />
</div>
@endsection

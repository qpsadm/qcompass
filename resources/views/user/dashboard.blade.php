@extends('layouts.f_layout');

@section('title', '新着情報一覧 | QLIP-Compass');

@section('main-content')
    <div class="container">
        <x-f_page_title :search="true" title="新着情報一覧" />

        <x-f_category_list />

        <x-f_content_list :items="$announcements" />

        <x-f_pagination />

        <x-f_bread_crumbs />
    </div>
@endsection

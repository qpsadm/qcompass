@extends('layouts.f_layout')

@section('main-content')
    <div class="container">
        <x-f_page_title :search="true" title="就職支援" />
        <x-f_category_list />

        <x-f_content_list :items="$announcements" />

        <x-f_pagination />
        <x-f_bread_crumbs />
    </div>
@endsection

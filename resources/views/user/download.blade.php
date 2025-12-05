@extends('layouts.f_layout')

@section('title', $agenda->agenda_name)

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
<div class="container">

    <x-f_page_title :search="false" title="{{ $agenda->agenda_name }}" />

    {{-- <p>カテゴリーID: {{ $agenda->category_id }}</p> --}}

    <div class="page-content
@switch(session('settings.fontsize', 2))
@case(1)@break
@case(2) font-medium @break
@case(3) font-large @break
@endswitch">
        <div>{!! $agenda->content !!}</div>
    </div>

    <x-f_btn_list
        :prevBtn="false"
        :nextBtn="false"
        :prevUrl="NULL"
        :nextUrl="NULL"
        :listBtn="true"
        listUrl="{{ url('user/top') }}"
        listLabel="トップへもどる" />

    <x-f_bread_crumbs />
</div>
@endsection

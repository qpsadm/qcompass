@extends('layouts.f_layout')

@section('title', $agenda->agenda_name)

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
<div class="container">


    @php

    $prevUrl = $prevAgenda ? route('user.agenda.info', ['id' => $prevAgenda->id]) : null;
    $nextUrl = $nextAgenda ? route('user.agenda.info', ['id' => $nextAgenda->id]) : null;
    @endphp
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


    {{-- <div class="page-content">
            {!! $agenda->content !!}
        </div> --}}
    {{-- <p>ステータス: {{ $agenda->status }}</p>
    <p>表示フラグ: {{ $agenda->is_show }}</p> --}}
    {{-- <p>{{ $agenda->created_at->format('Y/m/d') }}</p> --}}

    {{-- <a href="{{ route('user.agendas.my') }}" class="text-blue-600 hover:underline">一覧に戻る</a> --}}

    <x-f_btn_list
        :prevBtn="(bool)$prevAgenda"
        :nextBtn="(bool)$nextAgenda"
        :prevUrl="$prevUrl"
        :nextUrl="$nextUrl"
        :listBtn="true"
        listUrl="{{ url('user/agendas') }}"
        listLabel="一覧へ" />

    <x-f_bread_crumbs />
</div>
@endsection

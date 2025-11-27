@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_editor.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ $agenda->agenda_name }}</h1>

        <p>カテゴリーID: {{ $agenda->category_id }}</p>
        <p>講座ID: {{ $agenda->content }}</p>
        <p>ステータス: {{ $agenda->status }}</p>
        <p>表示フラグ: {{ $agenda->is_show }}</p>

        <a href="{{ route('user.agendas.my') }}" class="text-blue-600 hover:underline">一覧に戻る</a>
    </div>
@endsection

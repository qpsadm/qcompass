@extends('layouts.app')

@section('content')
    <h1>{{ $announcement->title }}</h1>
    <p>講座: {{ $announcement->course?->name ?? '全講座' }}</p>
    <p>カテゴリー: {{ $announcement->type?->name ?? '未分類' }}</p>
    <div>{!! $announcement->content !!}</div>
@endsection

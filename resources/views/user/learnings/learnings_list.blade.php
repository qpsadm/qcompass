@extends('layouts.f_layout')

@section('title', '学習支援一覧')

@section('main-content')
<div class="container">

    {{-- パンくず --}}
    <x-f_breadcrumb
        :items="[
            ['label' => 'TOP', 'url' => route('user.top')],
            ['label' => '学習支援']
        ]" />

    {{-- ページタイトル --}}
    <x-f_page_title :search="true" title="学習支援一覧" />

    {{-- タイプ切替ボタン --}}
    <div class="mb-4 space-x-2">
        <a href="{{ route('user.learnings.learnings_list') }}" class="btn btn-secondary">すべて</a>
        @for ($i = 1; $i <= 4; $i++)
            <a href="{{ route('user.learnings.learnings_by_type', ['type' => $i]) }}" class="btn btn-secondary">
            @switch($i)
            @case(1) 参考書籍 @break
            @case(2) 参考サイト @break
            @case(3) IT資格 @break
            @case(4) 製作品 @break
            @endswitch
            </a>
            @endfor
    </div>

    {{-- リスト --}}
    <ul>
        @foreach($learnings as $learning)
        <li>
            <a href="{{ route('user.learnings.learnings_info', ['learning' => $learning->id]) }}">
                {{ $learning->title }}
            </a>
        </li>
        @endforeach
    </ul>

</div>
@endsection

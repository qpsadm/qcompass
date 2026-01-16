@extends('layouts.f_layout')

@section('title', '学習支援一覧')

@section('main-content')
    <div class="container">

        {{-- ページタイトル --}}
        <x-f_page_title :search="true" title="学習支援一覧" />

        {{-- タイプ切替ボタン --}}
        <div class="category-menu">
            <ul>
                <li>
                    <a href="{{ route('user.learnings.learnings_list') }}">すべて</a>
                </li>
                @for ($i = 1; $i <= 4; $i++)
                    <li>
                        <a href="{{ route('user.learnings.learnings_by_type', ['type' => $i]) }}">
                            @switch($i)
                                @case(1)
                                    参考書籍
                                @break

                                @case(2)
                                    参考サイト
                                @break

                                @case(3)
                                    IT資格
                                @break

                                @case(4)
                                    製作品
                                @break
                            @endswitch
                        </a>
                    </li>
                @endfor
            </ul>
        </div>

        {{-- リスト --}}
        <div class="list-container">
            <ul>
                @foreach ($learnings as $learning)
                    <li>
                        <a href="{{ route('user.learnings.learnings_info', ['learning' => $learning->id]) }}">
                            {{ $learning->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- パンくず --}}
        <x-f_breadcrumb :items="[['label' => 'TOP', 'url' => route('user.top')], ['label' => '学習支援']]" />
    </div>
@endsection

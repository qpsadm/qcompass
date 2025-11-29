@props(['type' => 'news', 'tags' => []])

@if($type === 'news')
{{-- ニュースはカテゴリータブを表示 --}}
@php
$categories = [
'all' => 'ALL',
'main' => '訓練校に関するお知らせ',
'my' => '本講座に関するお知らせ',
];

$routes = [
'all' => route('user.news.news_list', ['category' => 'all']),
'main' => route('user.news.main_news'),
'my' => route('user.news.my_news'),
];

$currentCategory = request('category', 'all');
@endphp

<div class="category-menu">
    <ul>
        @foreach ($categories as $key => $label)
        <li class="{{ $currentCategory === $key ? 'active' : '' }}">
            <a href="{{ $routes[$key] }}">{{ $label }}</a>
        </li>
        @endforeach
    </ul>
</div>
@endif

@if($type === 'question' && count($tags))
{{-- 質疑応答はタグだけ表示 --}}
<div class="category-menu">
    <ul>
        {{-- ALL --}}
        <li class="{{ request('tag') === null ? 'active' : '' }}">
            <a href="{{ route('user.question.questions_list') }}">
                ALL
            </a>
        </li>

        {{-- タグ一覧 --}}
        @foreach($tags as $tag)
        <li class="{{ request('tag') == $tag->id ? 'active' : '' }}">
            <a href="{{ route('user.question.questions_list', ['tag' => $tag->id]) }}">
                {{ $tag->name }}
            </a>
        </li>
        @endforeach
    </ul>
</div>

@endif

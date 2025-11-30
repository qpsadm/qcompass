@props(['type' => 'news', 'tags' => [], 'category' => 'all'])

@if($type === 'news')
@php
$categories = [
'all' => 'ALL',
'main' => '訓練校に関するお知らせ',
'my' => '本講座に関するお知らせ',
];

// タブごとのリンク
$routes = [
'all' => route('user.news.news_list', ['category' => 'all']),
'main' => route('user.news.main_news'),
'my' => route('user.news.my_news'),
];

$currentCategory = $category ?? 'all'; // ここでコントローラーから渡された category を使う
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
<div class="category-menu">
    <ul>
        <li class="{{ request('tag') === null ? 'active' : '' }}">
            <a href="{{ route('user.question.questions_list') }}">ALL</a>
        </li>
        @foreach($tags as $tag)
        <li class="{{ request('tag') == $tag->id ? 'active' : '' }}">
            <a href="{{ route('user.question.questions_list', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
        </li>
        @endforeach
    </ul>
</div>
@endif

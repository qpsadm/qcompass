@props(['type' => 'news', 'category' => 'all'])

@php
$currentCategory = $category;

$categories = [
'all' => 'ALL',
'main' => $type === 'news' ? '訓練校に関するお知らせ' : '訓練校に関するお知らせ',
'my' => $type === 'news' ? '本講座に関するお知らせ' : '本講座に関するお知らせ',
];

$routes = [
'all' => $type === 'news'
? route('user.news.news_list')
: route('user.question.questions_list', ['category' => 'all']),
'main' => $type === 'news'
? route('user.news.main_news')
: route('user.question.questions_list', ['category' => 'main']),
'my' => $type === 'news'
? route('user.news.my_news')
: route('user.question.questions_list', ['category' => 'my']),
];
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

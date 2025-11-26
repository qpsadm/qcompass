@php
$currentCategory = $category ?? 'all';
@endphp

<div class="category-menu">
    <ul>
        <li class="{{ $currentCategory === 'all' ? 'active' : '' }}">
            <a href="{{ route('user.news.news_list') }}">ALL</a>
        </li>
        <li class="{{ $currentCategory === 'main' ? 'active' : '' }}">
            <a href="{{ route('user.news.main_news') }}">訓練校に関するお知らせ</a>
        </li>
        <li class="{{ $currentCategory === 'my' ? 'active' : '' }}">
            <a href="{{ route('user.news.my_news') }}">本講座に関するお知らせ</a>
        </li>
    </ul>
</div>

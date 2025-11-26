@php
// 現在のカテゴリを URL パラメータやルートから取得
$currentCategory = request()->query('category') ?? 'all';
@endphp

<div class="category-menu">
    <ul>
        <li class="{{ $currentCategory === 'all' ? 'active' : '' }}">
            <a href="{{ route('user.news.news_list', ['category' => 'all']) }}">ALL</a>
        </li>
        <li class="{{ $currentCategory === 'main' ? 'active' : '' }}">
            <a href="{{ route('user.news.news_list', ['category' => 'main']) }}">訓練校に関するお知らせ</a>
        </li>
        <li class="{{ $currentCategory === 'websys' ? 'active' : '' }}">
            <a href="{{ route('user.news.news_list', ['category' => 'websys']) }}">本講座に関するお知らせ</a>
        </li>
    </ul>
</div>

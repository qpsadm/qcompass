@php
    // デフォルト値
    $type = $type ?? 'news'; // 'news' or 'question'
    $currentCategory = $category ?? 'all';
@endphp

<div class="category-menu">
    <ul>
        {{-- ALL --}}
        <li class="{{ $currentCategory === 'all' ? 'active' : '' }}">
            <a href="{{ $type === 'news'
                ? route('user.news.news_list')
                : route('user.question.questions_list')
            }}">
                ALL
            </a>
        </li>

        {{-- カテゴリー1 --}}
        <li class="{{ $currentCategory === 'main' ? 'active' : '' }}">
            <a href="{{ $type === 'news'
                ? route('user.news.main_news')
                : route('user.question.main_questions')   {{-- ← 質疑応答用のルートを用意 --}}
            }}">
                {{ $type === 'news' ? '訓練校に関するお知らせ' : 'カテゴリー1' }}
            </a>
        </li>

        {{-- カテゴリー2 --}}
        <li class="{{ $currentCategory === 'my' ? 'active' : '' }}">
            <a href="{{ $type === 'news'
                ? route('user.news.my_news')
                : route('user.question.my_questions')     {{-- ← 質疑応答用のルート --}}
            }}">
                {{ $type === 'news' ? '本講座に関するお知らせ' : 'カテゴリー2' }}
            </a>
        </li>
    </ul>
</div>

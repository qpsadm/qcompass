@props([
'categories' => collect(),
'selectedCategoryId' => null,

// 🔑 必須：カテゴリクリック時のURL生成
// fn(null) → ALL
// fn($category) → 個別カテゴリ
'routeFunction',

'showAllLink' => true,
'allLabel' => 'All',
])

<div class="accordion-menu {{ ($selectedCategoryId !== null) ? 'active' : '' }}">
    <div class="menu-title">
        <div class="title"><span>カテゴリ</span></div>
        <div class="accordion-btn"><span></span></div>
    </div>

    <div class="menu-content" style="{{ ($selectedCategoryId !== null) ? 'display:block;' : 'display:none;' }}">
        <ul>

            {{-- ===== ALL ===== --}}
            @if($showAllLink)
            <li class="{{ $selectedCategoryId === null ? 'active' : '' }}">
                <a href="{{ $routeFunction(null) }}">
                    {{ $allLabel }}
                </a>
            </li>
            @endif

            {{-- ===== 個別カテゴリ ===== --}}
            @foreach($categories as $category)
            @php
            $count =
            $category->agenda_count
            ?? $category->quiz_count
            ?? $category->quizzes_count
            ?? 0;

            // ✅ 0件は表示しない
            if ((int)$count === 0) {
            continue;
            }

            $isActive = ((int)$category->id === (int)$selectedCategoryId);
            $url = $routeFunction($category);
            @endphp

            <li class="{{ $isActive ? 'active' : '' }}">
                <a href="{{ $url }}">
                    {{ $category->name }}

                    @if($count !== null)
                    <span class="ml-1 text-sm text-gray-500">
                        （{{ $count }}）
                    </span>
                    @endif
                </a>
            </li>
            @endforeach

        </ul>
    </div>
</div>

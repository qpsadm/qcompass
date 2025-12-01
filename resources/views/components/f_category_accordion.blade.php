<div class="accordion-menu {{ ($selectedCategoryId !== null) ? 'active' : '' }}">
    <div class="menu-title">
        <div class="title"><span>カテゴリ</span></div>
        <div class="accordion-btn"><span></span></div>
    </div>

    <div class="menu-content" style="{{ ($selectedCategoryId !== null) ? 'display:block;' : 'display:none;' }}">
        <ul>
            {{-- 全てのアジェンダ --}}
            <li class="{{ ($selectedCategoryId === null) ? 'active' : '' }}">
                <a href="{{ route('user.agenda.agendas_list', ['search' => $search ?? null]) }}">
                    All
                </a>
            </li>

            {{-- 個別カテゴリー --}}
            @foreach($categories as $category)
            <li class="{{ ((int)$category->id === (int)$selectedCategoryId) ? 'active' : '' }}">
                <a href="{{ route('user.agenda.agendas_list', ['category_id' => $category->id, 'search' => $search ?? null]) }}">
                    {{ $category->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

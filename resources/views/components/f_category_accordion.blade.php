<div class="accordion-menu">
    <div class="menu-title">
        <div class="title"><span>カテゴリ</span></div>
        <div class="accordion-btn"><span></span></div>
    </div>

    <div class="menu-content" style="display:block;">
        <ul>
            {{-- 全てのアジェンダ --}}
            <li class="{{ ($selectedCategoryId === null) ? 'active' : '' }}">
                <a href="{{ route('user.agenda.agendas_list', ['search' => $search ?? null]) }}">
                    All
                </a>
            </li>

            {{-- 個別カテゴリー --}}
            @foreach($categories as $category)
            <li class="{{ ($category->id == $selectedCategoryId) ? 'active' : '' }}">
                <a href="{{ route('user.agenda.agendas_list', ['category_id' => $category->id, 'search' => $search ?? null]) }}">
                    {{ $category->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="accordion-menu">

    <div class="menu-title">
        <div class="title">
            <span>カテゴリ</span>
        </div>
        <div class="accordion-btn">
            <span></span>
        </div>
    </div>

    <div class="menu-content">
        <ul>
            @foreach ($categories as $category)
            <li>
                <a href="{{ route('user.agenda.agenda_by_category', ['category_id' => $category->id]) }}">
                    {{ $category->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

</div>

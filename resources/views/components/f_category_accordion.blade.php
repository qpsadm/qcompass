<div class="accordion-menu">
    <div class="menu-title">
        <div class="title"><span>カテゴリ</span></div>
        <div class="accordion-btn"><span></span></div>
    </div>

    <div class="menu-content">
        <ul>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const links = document.querySelectorAll('.menu-content a');
        const storageKey = 'selectedCategory';

        // ページ読み込み時に選択状態を復元
        const selectedId = localStorage.getItem(storageKey);
        if (selectedId) {
            links.forEach(link => {
                if (link.dataset.id === selectedId) {
                    link.classList.add('active'); // CSSでハイライト
                }
            });
        }

        // クリックで選択状態を保存
        links.forEach(link => {
            link.addEventListener('click', () => {
                localStorage.setItem(storageKey, link.dataset.id);
            });
        });
    });
</script>

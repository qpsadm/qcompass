<div class="accordion-menu">
    @foreach ($categories as $category)
        <div class="menu-title">
            <div class="title">
                <span>{{ $category->name }}</span>
            </div>
            <div class="accordion-btn">
                <span></span>
            </div>
        </div>
        @if ($category->children->count() > 0)
            <div class="menu-content">
                <ul>
                    @foreach ($category->children as $child)
                        <li><a href="#">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
</div>

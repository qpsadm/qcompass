{{-- <div class="accordion-menu">
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
            <li><a href="">電話対応スキル</a></li>
            <li><a href="">パソコン基礎演習</a></li>
            <li><a href="">情報技術概論</a></li>
            <li><a href="">Javaプログラミング</a></li>
            <li><a href="">HTML&CSSの基本</a></li>
            <li><a href="">プロトタイプデザイン演習</a></li>
            <li><a href="">HTML&CSSの演習</a></li>
            <li><a href="">WEBコンテンツ制作</a></li>
            <li><a href="">JavaScriptプログラミングの演習</a></li>
            <li><a href="">WEBページ制作実習</a></li>
            <li><a href="">データベース演習</a></li>
            <li><a href="">PHPアプリ制作演習</a></li>
            <li><a href="">LaravelによるWebアプリ制作</a></li>
            <li><a href="">Webマーケティング概論</a></li>
            <li><a href="">システム開発の品質管理</a></li>
            <li><a href="">WEBアプリの企画・設計</a></li>
            <li><a href="">WEBアプリの制作実習</a></li>
            <li><a href="">制作発表プレゼンテーション</a></li>
            <li><a href="">面接対応</a></li>
            <li><a href="">就職支援</a></li>
            <li><a href="">職業人講話</a></li>
        </ul>
    </div>
</div> --}}

<div class="accordion-menu">

    <div class="menu-title">
        <div class="title">
            <span>カテゴリ</span>
        </div>
        <div class="accordion-btn">
            <span></span>
        </div>
    </div>
    @foreach ($categories as $category)
        @if ($category->children->count() > 0)
            <div class="menu-content">
                <ul>
                    <span>{{ $category->name }}</span>
                    @foreach ($category->children as $child)
                        <li><a href="#">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
</div>

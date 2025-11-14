{{-- フッターのサブビュー --}}
<hr>
<footer class="center">
    <div class="flex">
        <p class="margin"><a href="{{ route('game') }}">ゲーム</a></p>
        <p class="margin"><a href="{{ route('dictionary') }}">辞書</a></p>
        <p class="margin"><a href="{{ route('ranking') }}">ランキング</a></p>
        <p class="margin"><a href="{{ route('myscore') }}">マイスコア</a></p>
        <p class="margin"><a href="{{ route('knowhow') }}">知っトク情報</a></p>
        <div>
            <p class="margin"><a href="{{ url('about') }}">アバウト</a></p>
            <p class="margin"><a href="{{ route('article') }}">更新情報</a></p>
        </div>
        <div>
            <p class="margin"><a href="{{ route('contact') }}">問い合わせ</a></p>
            <p class="margin"><a href="{{ url('terms') }}">利用規約</a></p>
            <p class="margin"><a href="{{ route('privacypolicy') }}">個人情報保護方針</a></p>
        </div>
    </div>
</footer>

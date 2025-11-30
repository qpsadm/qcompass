<footer>
    <div class="footer-container">
        <div class="footer-info">
            <div class="footer-logo">
                <a href="{{ route('user.top') }}"><img src="{{ asset('assets/images/f_footer-logo.svg') }}"
                        alt="コンパスロゴホワイト"></a>
            </div>
            <div class="footer-company-info">
                <p>株式会社QLIPインターナショナル<br>QLIPプログラミングスクール</p>
                <p>〒 770-0832<br>徳島県徳島市寺島本町東3丁目12-8  K1ビル5F・6F</p>
                <p>TEL : 088-676-3151   FAX : 088-676-3152</p>
            </div>
            <div class="footer-sns-icons">
                <a href="https://www.facebook.com/qlipwebprogrammer" target="_blank"><img src="{{ asset('assets/images/icon/f_icon_facebook.png') }}" alt="facebookアイコン"></a>
                <a href="https://www.instagram.com/qlipdesign" target="_blank"><img src="{{ asset('assets/images/icon/f_icon_instagram.svg') }}" alt="instagramアイコン"></a>
            </div>
        </div>
        <div>
            <ul class="footer-menu-list">
                <li><a href="{{-- {{ route('user.courses.courses_info') }} --}}">講座情報</a></li>
                <li><a href="{{-- {{ route('user.teachers.teachers_list') }} --}}">講師紹介</a></li>
                <li><a href="{{-- {{ route('user.link_info') }} --}}">ダウンロード</a></li>
                <li><a href="{{-- {{ route('user.contact_create') }} --}}">お問い合わせ</a></li>
                <li><a href="{{ url('user/about') }}">本サイトについて</a></li>
                <li><a href="{{ url('user/rule') }}">受講規則</a></li>
                <li><a href="{{ url('user/privacy') }}">利用規約</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        <p>© 2025 qlip-compass. All rights reserved.</p>
    </div>
</footer>

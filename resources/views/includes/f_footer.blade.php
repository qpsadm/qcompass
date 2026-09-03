<footer>
    <div class="footer-container">
        <div class="footer-info">
            <div class="footer-logo">
                <a href="{{ route('user.top') }}"><img src="{{ asset('assets/images/logo_star_white.svg') }}"
                        alt="コンパスロゴホワイト"></a>
            </div>
            <div class="footer-company-info">
                <p>株式会社QLIPインターナショナル<br>QLIPプログラミングスクール</p>
                <p>〒 770-0832<br>徳島県徳島市寺島本町東3丁目12-8  K1ビル5F・6F</p>
                <p>TEL : 088-676-3151   FAX : 088-676-3152</p>
            </div>
            <div class="footer-sns-icons">
                <a href="https://www.facebook.com/qlipwebprogrammer" target="_blank"><img
                        src="{{ asset('assets/images/icon/f_icon_facebook.png') }}" alt="facebookアイコン"></a>
                <a href="https://www.instagram.com/qlipdesign" target="_blank"><img
                        src="{{ asset('assets/images/icon/f_icon_instagram.svg') }}" alt="instagramアイコン"></a>
            </div>
        </div>
        <div>
            <ul class="footer-menu-list">
                <li><a class="footer-menu" href="{{ route('user.course.courses_info') }}">
                        <img src="{{ asset('assets/images/icon/f_icon_agenda.svg') }}" alt="f_icon_agenda.svg"
                            style="filter: brightness(0) invert(1);">
                        <span>講座情報</span>
                    </a></li>
                <li><a class="footer-menu" href="{{ route('user.teacher.teachers_list') }}">
                        <img src="{{ asset('assets/images/icon/f_icon_agenda.svg') }}" alt="f_icon_agenda.svg"
                            style="filter: brightness(0) invert(1);">
                        <span>講師紹介</span>
                    </a></li>

                {{-- ダウンロード機能を無効させた　福島　2026-06-08 --}}
                {{-- <li><a href="{{ url('user/agenda/13') }}">ダウンロード</a></li>
                <li>
                    @php
                        $downloadAgenda = \App\Models\Agenda::where('category_id', 53)->first();
                    @endphp

                    @if ($downloadAgenda)
                        <a href="{{ route('user.download', $downloadAgenda->id) }}">ダウンロード</a>
                    @endif
                </li> --}}

                <li><a class="footer-menu" href="{{ url('user/rule') }}">
                        <img src="{{ asset('assets/images/icon/f_icon_agenda.svg') }}" alt="f_icon_agenda.svg"
                            style="filter: brightness(0) invert(1);">
                        <span>職業訓練受講規則</span>
                    </a></li>

                <li><a class="footer-menu" href="{{ url('user/about') }}">
                        <img src="{{ asset('assets/images/icon/f_icon_agenda.svg') }}" alt="f_icon_agenda.svg"
                            style="filter: brightness(0) invert(1);">
                        <span>本サイトについて</span>
                    </a></li>
                <li><a class="footer-menu" href="{{ url('user/privacy') }}">
                        <img src="{{ asset('assets/images/icon/f_icon_agenda.svg') }}" alt="f_icon_agenda.svg"
                            style="filter: brightness(0) invert(1);">
                        <span>利用規約・プライバシーポリシー</span>
                    </a></li>

            </ul>
        </div>
    </div>
    <div class="copyright">
        <p>Copyright© 株式会社QLIPプログラミングスクール</p>
    </div>
</footer>

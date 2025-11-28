@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <x-f_page_title :search="true" title="日報入力フォーム" />

        <div class="form-content">
            <p>本講座をスムーズに進めるために、日々の報告・連絡・相談が欠かせないと思います。<br>
                日報は報告・連絡・相談に一番有効な手段の1つとして、ぜひ最初のうちから日報提出の良い習慣を身に付けられるように頑張ってください。</p>
            <form class="report-form" action="" method="POST">
                @csrf
                <div class="form-item">
                    <div class="item-label">
                        <label for="name">氏名</label>
                        <span class="required">必須</span>
                    </div>
                    <input type="text" id="name" value="クリップ　太郎" required readonly>
                </div>
                <div class="form-item">
                    <div class="item-label">
                        <label for="mail">メールアドレス</label>
                        <span class="required">必須</span>
                    </div>
                    <input type="email" id="mail" value="user@domain.com" required readonly>
                </div>
                <div class="form-item">
                    <div class="item-label">
                        <label for="date">報告日</label>
                        <span class="required">必須</span>
                    </div>
                    <input type="date" id="date" placeholder="date" required>
                </div>
                <div class="form-item">
                    <div class="item-label">
                        <label for="daily-report-input">日報</label>
                        <span class="required">必須</span>
                    </div>
                    <textarea name="daily_report" id="daily-report-input" rows="6" placeholder="本日の講習で学んだ内容や報告したい内容をご記入ください。"
                        required></textarea>
                </div>
                <div class="form-item">
                    <div class="item-label">
                        <label for="impression">感想・気づき・質問</label>
                        <span class="required">必須</span>
                    </div>
                    <textarea name="impression" id="impression" rows="6" placeholder="本日の講習で良かったと思ったこと、反省点または気づいたこと等をご記入ください。"
                        required></textarea>
                </div>
                <div class="form-item">
                    <div class="item-label">
                        <label for="message">連絡事項</label>
                    </div>
                    <textarea name="message" id="message" rows="6" placeholder="個人情報が変更された時に、また前もって分かったお休みなどの連絡事項をご記入ください。"></textarea>
                </div>

                <div class="privacy-policy">
                    <p>【個人情報保護方針】</p>
                    <p>下記のリンクから【個人情報保護方針】を確認してください。</p>
                    <p><a href="{{-- {{ routr('user.privacy') }} --}}" target="_blank">個人情報保護方針を確認する</a></p>
                </div>

                <button type="submit" class="privacy-policy-button">個人情報保護方針に同意して送信</button>
            </form>

        </div>
        <x-f_bread_crumbs />
    </div>
@endsection

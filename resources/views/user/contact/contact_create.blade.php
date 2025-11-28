@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="お問い合わせフォーム" />

        <div class="form-content">
            <p>本講座はシステムエンジニア、Javaプログラマー、Webクリエーターなどに就職することを目標とし、今後さまざまな企業で要求される基礎的なIT技術は勿論のこと、Javaプログラミング、Webサイトの制作などのより高度な技能を実践的なカリキュラムを通して習得できます。
            </p>

            <form class="report-form" action="" method="POST">
                @csrf
                <div class="form-item">
                    <div class="item-label">
                        <label for="name">氏名</label>
                        <span class="required">必須</span>
                    </div>
                    <input type="text" id="name" name="name" placeholder="クリップ　太郎" required>
                </div>
                <div class="form-item">
                    <div class="item-label">
                        <label for="mail">メールアドレス</label>
                        <span class="required">必須</span>
                    </div>
                    <input type="email" id="mail" name="email" placeholder="user@domain.com" required>
                </div>

                <div class="form-item">
                    <div class="item-label">
                        <label for="daily-report-input">お問い合わせ内容</label>
                        <span class="required">必須</span>
                    </div>
                    <textarea name="contact" id="daily-report-input" rows="6" placeholder="お問い合わせ内容をご記入ください。" required></textarea>
                </div>


                <div class="privacy-policy">
                    <p>【個人情報保護方針】</p>
                    <p>下記のリンクから【個人情報保護方針】を確認してください。</p>
                    <p><a href="{{-- {{ routr('user.privacy') }} --}}" target="_blank">個人情報保護方針を確認する</a></p>
                </div>

                <button type="submit" class="privacy-policy-button">確認画面へ</button>
            </form>
        </div>
        <x-f_bread_crumbs />
    </div>
@endsection

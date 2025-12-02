@extends('layouts.f_layout')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
<div class="container">
    <x-f_page_title :search="false" title="日報入力フォーム" />

    <div class="form-content
@switch(session('settings.fontsize', 2))
@case(1)@break
@case(2) font-medium @break
@case(3) font-large @break
@endswitch">
        <div class="description-text">
            <p>本講座をスムーズに進めるために、日々の報告・連絡・相談が欠かせないと思います。<br>
                日報は報告・連絡・相談に一番有効な手段の1つとして、ぜひ最初のうちから日報提出の良い習慣を身に付けられるように頑張ってください。</p>
        </div>

        <form class="report-form" action="{{ route('user.reports_confirm') }}" method="POST">
            @csrf
            {{-- 講座ID（hidden） --}}
            @if (!empty($course))
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            @endif
            {{-- 氏名・メール --}}
            <div class="form-item">
                <div class="item-label">
                    <label for="name">氏名</label>
                    <span class="required">必須</span>
                </div>
                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="form-item">
                <div class="item-label">
                    <label for="mail">メールアドレス</label>
                    <span class="required">必須</span>
                </div>
                <input type="email" id="mail" name="email" value="{{ Auth::user()->email }}" readonly>
            </div>

            {{-- 報告日 --}}
            <div class="form-item">
                <div class="item-label">
                    <label for="date">報告日</label>
                    <span class="required">必須</span>
                </div>
                <input type="date" id="date" name="date" value="{{ $date ?? date('Y-m-d') }}" required>
            </div>

            {{-- 日報内容 --}}
            <div class="form-item">
                <div class="item-label">
                    <label for="daily-report-input">日報</label>
                    <span class="required">必須</span>
                </div>
                <textarea name="daily_report" id="daily-report-input" rows="6" placeholder="本日の講習で学んだ内容や報告したい内容をご記入ください。"
                    required></textarea>
            </div>

            {{-- 感想・気づき・質問 --}}
            <div class="form-item">
                <div class="item-label">
                    <label for="impression">感想・気づき・質問</label>
                    <span class="required">必須</span>
                </div>
                <textarea name="impression" id="impression" rows="6" placeholder="本日の講習で良かったこと、反省点または気づいたこと等をご記入ください。" required></textarea>
            </div>

            {{-- 連絡事項 --}}
            <div class="form-item">
                <div class="item-label">
                    <label for="message">連絡事項</label>
                </div>
                <textarea name="message" id="message" rows="6" placeholder="個人情報変更やお休みなどの連絡事項をご記入ください。"></textarea>
            </div>

            {{-- 個人情報保護方針 --}}
            <div class="privacy-policy">
                <p>【個人情報保護方針】</p>
                <p>下記のリンクから【個人情報保護方針】を確認してください。</p>
                <p><a href="#" target="_blank">個人情報保護方針を確認する</a></p>
            </div>

            <button type="submit" class="form-btn">個人情報保護方針に同意して送信</button>
        </form>

    </div>
    <x-f_bread_crumbs />
</div>
@endsection

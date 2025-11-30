@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="日報入力フォーム（確認画面）" />

        <div class="form-content">
            <div class="description-text">
                <p>本講座をスムーズに進めるために、日々の報告・連絡・相談が欠かせないと思います。<br>
                    日報は報告・連絡・相談に一番有効な手段の1つとして、ぜひ最初のうちから日報提出の良い習慣を身に付けられるように頑張ってください。</p>
            </div>

            <form class="form-confirm" action="{{ route('user.reports_store') }}" method="POST">
                @csrf

                <input type="hidden" name="course_id" value="{{ $courses->first()->id }}">
                <input type="hidden" name="name" value="{{ $inputs['name'] }}">
                <input type="hidden" name="email" value="{{ $inputs['email'] }}">
                <input type="hidden" name="date" value="{{ $inputs['date'] }}">
                <input type="hidden" name="daily_report" value="{{ $inputs['daily_report'] }}">
                <input type="hidden" name="impression" value="{{ $inputs['impression'] }}">
                <input type="hidden" name="message" value="{{ $inputs['message'] ?? '' }}">

                {{-- 講座ID（hidden） --}}
                {{-- @if (!empty($courses))
                    <input type="hidden" name="course_id" value="{{ $courses->first()->id }}">
                @endif --}}
                {{-- 氏名・メール --}}
                <div class="confirm-item">
                    <div class="item-label">
                        <label for="name">氏名</label>
                    </div>
                    <p>{{ $inputs['name'] }}</p>
                </div>
                <div class="confirm-item">
                    <div class="item-label">
                        <label for="mail">メールアドレス</label>
                    </div>
                    <p>{{ $inputs['email'] }}</p>
                </div>

                {{-- 報告日 --}}
                <div class="confirm-item">
                    <div class="item-label">
                        <label for="date">報告日</label>
                    </div>
                    <p>{{ $inputs['date'] }}</p>
                </div>

                {{-- 日報内容 --}}
                <div class="confirm-item">
                    <div class="item-label">
                        <label for="daily-report-input">日報</label>
                    </div>
                    <p>{!! nl2br(e($inputs['daily_report'])) !!}</p>
                </div>

                {{-- 感想・気づき・質問 --}}
                <div class="confirm-item">
                    <div class="item-label">
                        <label for="impression">感想・気づき・質問</label>
                    </div>
                    <p>{!! nl2br(e($inputs['impression'])) !!}</p>
                </div>

                {{-- 連絡事項 --}}
                <div class="confirm-item">
                    <div class="item-label">
                        <label for="message">連絡事項</label>
                    </div>
                    <p>{!! nl2br(e($inputs['message'])) !!}</p>
                </div>

                <button type="submit" class="form-btn">送信</button>
            </form>

        </div>
        <x-f_bread_crumbs />
    </div>
@endsection

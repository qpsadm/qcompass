@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="日報入力フォーム（確認画面）" />

        <div class="form-content">
            <div class="description-text">
                <p>本講座はシステムエンジニア、Javaプログラマー、Webクリエーターなどに就職することを目標とし、今後さまざまな企業で要求される基礎的なIT技術は勿論のこと、<br>Javaプログラミング、Webサイトの制作などのより高度な技能を実践的なカリキュラムを通して習得できます。</p>
            </div>

            <form class="form-confirm" action="{{ route('user.contact_store') }}" method="POST">
                @csrf

                {{-- <input type="hidden" name="course_id" value="{{ $courses->first()->id }}"> --}}
                <input type="hidden" name="name" value="{{ $inputs['name'] }}">
                <input type="hidden" name="email" value="{{ $inputs['email'] }}">
                {{-- <input type="hidden" name="date" value="{{ $inputs['date'] }}"> --}}
                {{-- <input type="hidden" name="daily_contact" value="{{ $inputs['daily_contact'] }}"> --}}
                {{-- <input type="hidden" name="impression" value="{{ $inputs['impression'] }}">
                <input type="hidden" name="message" value="{{ $inputs['message'] ?? '' }}"> --}}

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
                {{-- <div class="confirm-item">
                    <div class="item-label">
                        <label for="date">報告日</label>
                    </div>
                    <p>{{ $inputs['date'] }}</p>
                </div> --}}

                {{-- 日報内容 --}}
                <div class="confirm-item">
                    <div class="item-label">
                        <label for="daily-contact-input">問い合わせ内容</label>
                    </div>
                    <p>{!! nl2br(e($inputs['daily_contact'])) !!}</p>
                </div>

                {{-- 感想・気づき・質問 --}}
                {{-- <div class="confirm-item">
                    <div class="item-label">
                        <label for="impression">感想・気づき・質問</label>
                    </div>
                    <p>{!! nl2br(e($inputs['impression'])) !!}</p>
                </div> --}}

                {{-- 連絡事項 --}}
                {{-- <div class="confirm-item">
                    <div class="item-label">
                        <label for="message">連絡事項</label>
                    </div>
                    <p>{!! nl2br(e($inputs['message'])) !!}</p>
                </div> --}}

                <button type="submit" class="form-btn">送信</button>
            </form>

        </div>
        <x-f_bread_crumbs />
    </div>
@endsection

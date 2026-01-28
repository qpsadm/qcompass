@extends('layouts.f_layout')

@section('title', '送信完了')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <!-- コンテンツ詳細（文字サイズ変更対象） -->
        <div
            class="complete
            @switch(session('settings.fontsize', 2))
            @case(1)@break
            @case(2) font-medium @break
            @case(3) font-large @break
        @endswitch">

            <h2>送信完了</h2>
            <p>日報の送信が完了しました。<br>
                ご登録のメールアドレスへ確認用のメールをお送りしておりますので、ご確認ください。</p>
            <p>過去に作成された日報は、マイページ内の日報カレンダーよりご覧いただけます。<br>
                学習内容の振り返りにぜひご活用ください。</p>
            <a href="{{ route('user.top') }}" class="form-btn">
                トップへもどる
            </a>
        </div>
    </div>
@endsection

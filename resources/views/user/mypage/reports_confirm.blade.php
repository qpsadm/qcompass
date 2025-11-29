@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <div class="confirm">
            <h2>送信完了</h2>
            <p>日報の送信が完了しました。<br> ご登録のメールアドレスへ確認用のメールをお送りしておりますので、ご確認ください。</p>
            <p>過去に作成された日報は、マイページ内の日報カレンダーよりご覧いただけます。<br> 学習内容の振り返りにぜひご活用ください。</p>
            <a href="{{ route('user.top') }}" class="form-btn">
                トップへもどる
            </a>
        </div>
    </div>
@endsection

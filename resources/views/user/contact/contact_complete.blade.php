@extends('layouts.f_layout')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_form.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <div class="complete">
            <h2>送信完了</h2>
            <p>お問い合わせ内容は、無事に送信されました。<br> ご入力いただいたメールアドレスに自動返信しておりますので、ご確認ください。</p>
            <p>お問い合わせいただいた内容について、確認の上、ご返信させていただきます。</p>
            <a href="{{ route('user.top') }}" class="form-btn">
                トップへもどる
            </a>
        </div>
    </div>
@endsection

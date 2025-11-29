@extends('layouts.f_layout')

@section('main-content')
<div class="container mx-auto p-4 max-w-3xl">
    <h1 class="text-2xl font-bold mb-4">日報送信完了</h1>
    <p>日報の送信が完了しました。</p>
    <a href="{{ route('user.reports_info') }}" class="mt-4 inline-block text-blue-600 hover:underline">
        日報一覧に戻る
    </a>
</div>
@endsection

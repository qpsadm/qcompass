@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">お知らせ分類 作成</h1>

    <form method="POST" action="{{ route('admin.announcement_types.store') }}">
        @csrf

        @include('admin.announcement_types.form')

        <button class="bg-blue-600 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection

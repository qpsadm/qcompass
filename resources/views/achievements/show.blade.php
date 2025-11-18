@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">実績詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>実績名:</strong> {{ $Achievement->title }}</p>
            <p><strong>条件説明:</strong> {{ $Achievement->description }}</p>
            <p><strong>達成条件タイプ:</strong> {{ $Achievement->condition_type }}</p>
            <p><strong>条件値:</strong> {{ $Achievement->condition_value }}</p>
            <p><strong>削除日:</strong> {{ $Achievement->deleted_at }}</p>

        </div>
        <a href="{{ route('achievements.edit', $Achievement->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('achievements.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection

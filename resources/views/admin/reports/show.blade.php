@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">日報詳細</h1>
            <div class="border p-4 rounded mb-4">
                <p><strong>提出者ID:</strong> {{ $Report->user_id }}</p>
                <p><strong>講座ID:</strong> {{ $Report->course_id }}</p>
                <p><strong>日報対象日:</strong> {{ $Report->date }}</p>
                <p><strong>タイトル:</strong> {{ $Report->title }}</p>
                <p><strong>日報:</strong> {{ $Report->content }}</p>
                <p><strong>感想・気づき・質問:</strong> {{ $Report->impression }}</p>
                <p><strong>連絡事項:</strong> {{ $Report->notice }}</p>
                <p><strong>作成者:</strong> {{ $Report->created_user_id }}</p>
                <p><strong>作成日:</strong> {{ $Report->updated_user_id }}</p>
                <p><strong>削除日:</strong> {{ $Report->deleted_at }}</p>
                <p><strong>削除者:</strong> {{ $Report->deleted_user_id }}</p>

            </div>
            <a href="{{ route('admin.reports.edit', $Report->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.reports.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    @endsection

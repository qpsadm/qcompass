@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">User詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>code:</strong> {{ $User->code }}</p>
            <p><strong>name:</strong> {{ $User->name }}</p>
            <p><strong>furigana:</strong> {{ $User->furigana }}</p>
            <p><strong>roman_name:</strong> {{ $User->roman_name }}</p>
            <p><strong>password:</strong> {{ $User->password }}</p>
            <p><strong>role_id:</strong> {{ $User->role_id }}</p>
            <p><strong>courses_id:</strong> {{ $User->courses_id }}</p>
            <p><strong>remember_token:</strong> {{ $User->remember_token }}</p>
            <p><strong>email:</strong> {{ $User->email }}</p>
            <p><strong>email_verified_at:</strong> {{ $User->email_verified_at }}</p>
            <p><strong>created_user_id:</strong> {{ $User->created_user_id }}</p>
            <p><strong>updated_user_id:</strong> {{ $User->updated_user_id }}</p>
            <p><strong>deleted_at:</strong> {{ $User->deleted_at }}</p>
            <p><strong>deleted_user_id:</strong> {{ $User->deleted_user_id }}</p>

        </div>
        <a href="{{ route('admin.users.edit', $User->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection

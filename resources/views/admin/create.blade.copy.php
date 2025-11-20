@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">ユーザー作成</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1">ユーザーコード</label>
            <input type="text" name="code" value="{{ old('code', $User->code ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">氏名</label>
            <input type="text" name="name" value="{{ old('name', $User->name ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">ふりがな</label>
            <input type="text" name="furigana" value="{{ old('furigana', $User->furigana ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">ローマ字氏名</label>
            <input type="text" name="roman_name" value="{{ old('roman_name', $User->roman_name ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">パスワード</label>
            <input type="text" name="password" value="{{ old('password', $User->password ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">権限</label>
            <select name="role_id" class="border px-2 py-1 w-48 rounded">
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id', $User->role_id ?? '') == $role->id ? 'selected' : '' }}>
                    {{ $role->role_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">担当講座</label>
            <select name="courses_id" class="border px-2 py-1 w-48 rounded">
                <option value="">選択してください</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('courses_id', $user->courses_id ?? '') == $course->id ? 'selected' : '' }}>
                    {{ $course->course_name }} ({{ $course->course_code }})
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">リメンバートークン</label>
            <input type="text" name="remember_token" value="{{ old('remember_token', $User->remember_token ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">メールアドレス</label>
            <input type="text" name="email" value="{{ old('email', $User->email ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">メール確認日時</label>
            <input type="text" name="email_verified_at" value="{{ old('email_verified_at', $User->email_verified_at ?? '') }}" class="border px-2 py-1 w-48 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">作成者ID</label>
            <input type="hidden" name="created_user_name" value="{{ auth()->user()->id }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mb-8 rounded">保存</button>
    </form>
</div>
@endsection

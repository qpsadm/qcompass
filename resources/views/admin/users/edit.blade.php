@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">User編集</h1>
        <form action="{{ route('admin.users.update', $User->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">code</label>
                <input type="text" name="code" value="{{ old('code', $User->code ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">name</label>
                <input type="text" name="name" value="{{ old('name', $User->name ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">furigana</label>
                <input type="text" name="furigana" value="{{ old('furigana', $User->furigana ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">roman_name</label>
                <input type="text" name="roman_name" value="{{ old('roman_name', $User->roman_name ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">password</label>
                <input type="text" name="password" value="{{ old('password', $User->password ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">role_id</label>
                <input type="text" name="role_id" value="{{ old('role_id', $User->role_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">courses_id</label>
                <input type="text" name="courses_id" value="{{ old('courses_id', $User->courses_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">remember_token</label>
                <input type="text" name="remember_token" value="{{ old('remember_token', $User->remember_token ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">email</label>
                <input type="text" name="email" value="{{ old('email', $User->email ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">email_verified_at</label>
                <input type="text" name="email_verified_at"
                    value="{{ old('email_verified_at', $User->email_verified_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">created_user_id</label>
                <input type="text" name="created_user_id"
                    value="{{ old('created_user_id', $User->created_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">updated_user_id</label>
                <input type="text" name="updated_user_id"
                    value="{{ old('updated_user_id', $User->updated_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">deleted_at</label>
                <input type="text" name="deleted_at" value="{{ old('deleted_at', $User->deleted_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">deleted_user_id</label>
                <input type="text" name="deleted_user_id"
                    value="{{ old('deleted_user_id', $User->deleted_user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection

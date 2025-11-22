@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">ユーザー基本情報編集</h1>
    <div class="mt-4">
        @if ($user->detail)
        <!-- 詳細情報がある場合は編集画面 -->
        <a href="{{ route('admin.user_details.edit', ['user' => $user->id, 'detail' => $user->detail->id]) }}"
            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
            詳細情報を編集
        </a>
        @else
        <!-- 詳細情報がない場合は作成画面 -->
        <a href="{{ route('admin.user_details.create', ['user' => $user->id]) }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
            詳細情報を作成
        </a>
        @endif
    </div>
    {{-- フォーム --}}
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- コード --}}
        <div>
            <label class="block mb-1 font-semibold">ユーザーコード</label>
            <input type="text" name="code" value="{{ old('code', $user->code) }}"
                class="w-full border rounded px-3 py-2">
            @error('code') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- 名前 --}}
        <div>
            <label class="block mb-1 font-semibold">名前</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full border rounded px-3 py-2">
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- メール --}}
        <div>
            <label class="block mb-1 font-semibold">メール</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border rounded px-3 py-2">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- パスワード --}}
        <div>
            <label class="block mb-1 font-semibold">パスワード（変更する場合のみ）</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>


        {{-- 役割 --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">役割</label>
            <select name="role_id" class="w-full border rounded px-3 py-2">
                @foreach($roles as $role)
                <option value="{{ $role->id }}"
                    {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                    {{ $role->role_name }}
                </option>
                @endforeach
            </select>
            @error('role_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- 担当講座 --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">担当講座</label>
            <select name="courses_id" class="w-full border rounded px-3 py-2">
                @foreach($courses as $course)
                <option value="{{ $course->id }}"
                    {{ old('courses_id', $user->courses_id) == $course->id ? 'selected' : '' }}>
                    {{ $course->course_name }}
                </option>
                @endforeach
            </select>
            @error('courses_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>


        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                更新する
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection

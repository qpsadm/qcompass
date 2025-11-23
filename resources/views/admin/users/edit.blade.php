@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-5xl">
    <h1 class="text-3xl font-bold mb-6">ユーザー基本情報編集：{{ $user->name }}</h1>

    {{-- 詳細情報作成／編集ボタン --}}
    <div class="mb-6">
        @if ($user->detail)
        <a href="{{ route('admin.user_details.edit', ['user' => $user->id, 'detail' => $user->detail->id]) }}"
            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-2 rounded shadow-sm transition">
            詳細情報を編集
        </a>
        @else
        <a href="{{ route('admin.user_details.create', ['user' => $user->id]) }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded shadow-sm transition">
            詳細情報を作成
        </a>
        @endif
    </div>

    {{-- フォーム --}}
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <table class="w-full table-auto border-collapse">
            <tbody>
                {{-- ユーザーコード --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">ユーザーコード</th>
                    <td class="px-4 py-2">
                        <input type="text" name="code" value="{{ old('code', $user->code) }}"
                            class="border rounded px-3 py-2 w-64">
                        @error('code') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 名前 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">名前</th>
                    <td class="px-4 py-2">
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="border rounded px-3 py-2 w-64">
                        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- メール --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">メール</th>
                    <td class="px-4 py-2">
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="border rounded px-3 py-2 w-80">
                        @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- パスワード --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">パスワード</th>
                    <td class="px-4 py-2">
                        <input type="password" name="password" class="border rounded px-3 py-2 w-64">
                        <p class="text-gray-500 text-sm">※変更する場合のみ入力してください</p>
                        @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 役割 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">役割</th>
                    <td class="px-4 py-2">
                        <select name="role_id" class="border rounded px-3 py-2 w-64">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('role_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 担当講座 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">担当講座</th>
                    <td class="px-4 py-2">
                        <select name="courses_id" class="border rounded px-3 py-2 w-64">
                            <option value="">選択してください</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('courses_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }} ({{ $course->course_code }})
                            </option>
                            @endforeach
                        </select>
                        @error('courses_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                更新する
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection

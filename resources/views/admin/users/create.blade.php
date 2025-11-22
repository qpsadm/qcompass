@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-6 h-6">
            <span>ユーザー作成</span>
        </h1>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- ユーザーコード -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">ユーザーコード
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                </label>
                <input type="text" name="code" value="{{ old('code') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 氏名 -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">氏名
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ふりがな -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">ふりがな
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                </label>
                <input type="text" name="furigana" value="{{ old('furigana') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('furigana')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ローマ字氏名 -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">ローマ字氏名
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                </label>
                <input type="text" name="roman_name" value="{{ old('roman_name') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('roman_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- パスワード -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">パスワード
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                </label>
                <input type="password" name="password"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 権限 -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">権限
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                </label>
                <select name="role_id"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">選択してください</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}"
                        {{ old('role_id', 3) == $role->id ? 'selected' : '' }}>
                        {{ $role->role_name }}
                    </option>
                    @endforeach
                </select>
                @error('role_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 担当講座 -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">担当講座</label>
                <select name="courses_id[]"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">選択してください</option>
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}"
                        {{ (collect(old('courses_id', []))->contains($course->id)) ? 'selected' : '' }}>
                        {{ $course->course_name }} ({{ $course->course_code }})
                    </option>
                    @endforeach
                </select>
                @error('courses_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- メールアドレス -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 作成者ID -->
            <input type="hidden" name="created_user_name" value="{{ auth()->user()->id }}">

            <!-- ボタン -->
            <div class="flex gap-3 mt-4">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                    保存
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

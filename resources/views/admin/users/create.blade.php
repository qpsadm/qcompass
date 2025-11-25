@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6">ユーザー基本情報作成</h1>

        {{-- フォーム --}}
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- ユーザーコード --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">ユーザーコード
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="code" value="{{ old('code') }}"
                                class="border rounded px-3 py-2 w-64">
                            @error('code')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 氏名 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">氏名
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>

                        <td class="px-4 py-2">
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="border rounded px-3 py-2 w-64">
                            @error('name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- ふりがな --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">ふりがな
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="furigana" value="{{ old('furigana') }}"
                                class="border rounded px-3 py-2 w-64">
                            @error('furigana')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- ローマ字氏名 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">ローマ字氏名
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="roman_name" value="{{ old('roman_name') }}"
                                class="border rounded px-3 py-2 w-64">
                            @error('roman_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- パスワード --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">パスワード
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="password" name="password" class="border rounded px-3 py-2 w-64">
                            <p class="text-gray-500 text-sm">※新規作成のため必須</p>
                            @error('password')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 権限 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">権限</th>
                        <td class="px-4 py-2">
                            <select name="role_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択してください</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id', 3) == $role->id ? 'selected' : '' }}>
                                        {{ $role->role_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 担当講座 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">担当講座</th>
                        <td class="px-4 py-2">
                            <select name="courses_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択してください</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('courses_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('courses_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 部署 --}}
                    <tr class="border-b">
                        <th class="bg-gray-100 text-right font-medium px-4 py-2">部署</th>
                        <td class="px-4 py-2">
                            <select name="division_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}"
                                        {{ old('division_id', $user->detail->divisions_id ?? '') == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    {{-- メール --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">メールアドレス</th>
                        <td class="px-4 py-2">
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="border rounded px-3 py-2 w-80">
                            @error('email')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <input type="hidden" name="created_user_name" value="{{ auth()->user()->id }}">

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    保存する
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen" x-data="{ deleteOpen: false }">

        <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">

            <!-- ヘッダー -->
            <div class="mb-6">
                {{-- <a href="{{ route('admin.course_users.index') }}"
                    class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                    ← 講座受講者一覧に戻る
                </a> --}}
                <h1 class="text-2xl font-bold text-gray-800">
                    講座受講者 編集
                </h1>
            </div>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 編集フォーム -->
            <form action="{{ route('admin.course_users.update', $courseUser->id) }}" method="POST">
                @csrf
                @method('PUT')

                <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-sm">
                    <tbody>

                        {{-- ユーザー --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                                ユーザー
                                <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                    必須
                                </span>
                            </th>
                            <td class="px-4 py-3">
                                <select name="user_id"
                                    class="w-full border rounded px-3 py-2
                                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required disabled>
                                    <option value="">選択してください</option>
                                    @foreach ($users as $user)
                                        {{-- @if ($user->role_id >= 4) --}}
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $courseUser->user_id) == $user->id ? 'selected' : '' }}>
                                            【{{ $user->code }}】 {{ $user->name }}
                                        </option>
                                        {{-- @endif --}}
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 講座 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                                講座
                                <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                    必須
                                </span>
                            </th>
                            <td class="px-4 py-3">
                                <select name="course_id"
                                    class="w-full border rounded px-3 py-2
                                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="">選択してください</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', $courseUser->course_id) == $course->id ? 'selected' : '' }}>
                                            【{{ $course->course_code }}】 {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                    </tbody>
                </table>

                <!-- 操作ボタン -->
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="save bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                        更新する
                    </button>
                    <a href="{{ route('admin.course_users.index') }}"
                        class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>

            <!-- 危険操作ゾーン -->
            <div class="mt-10 pt-6 border-t border-red-200">
                <h2 class="text-red-600 font-semibold mb-2">
                    ⚠ 危険な操作
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    この講座受講者を削除すると、元に戻すことはできません。
                </p>

                <button @click="deleteOpen = true" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                    削除する
                </button>
            </div>
        </div>

        <!-- 削除確認モーダル -->
        <div x-show="deleteOpen" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

            <div x-show="deleteOpen" x-transition.scale class="bg-white rounded-2xl p-6 w-full max-w-sm">

                <h3 class="text-lg font-semibold text-center mb-3">
                    削除確認
                </h3>

                <p class="text-center text-gray-700 mb-5">
                    「<span class="font-semibold">{{ $courseUser->user->name }}</span>」の受講情報を削除しますか？
                </p>

                <div class="flex justify-center gap-4">
                    <button @click="deleteOpen = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        キャンセル
                    </button>

                    <form action="{{ route('admin.course_users.destroy', $courseUser->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            削除する
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
@endsection

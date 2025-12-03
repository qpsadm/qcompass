@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-lg mx-auto">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">講座受講者編集</h1>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.course_users.update', $CourseUser->id) }}" method="POST">
                @csrf
                @method('PUT')

                <table class="w-full table-auto border-collapse">
                    <tbody>
                        {{-- ユーザー選択 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                ユーザー
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                                    <option value="">選択してください</option>
                                    @foreach ($users as $user)
                                        @if ($user->role_id >= 4)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $CourseUser->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 講座選択 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                講座
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <select name="course_id" class="w-full border rounded px-3 py-2" required>
                                    <option value="">選択してください</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', $CourseUser->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->course_name }}
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

                {{-- ボタン --}}
                <div class="mt-6 flex gap-3 justify-center">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                        更新
                    </button>
                    <a href="{{ route('admin.course_users.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

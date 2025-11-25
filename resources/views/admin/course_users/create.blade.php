@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6">ユーザー講座作成</h1>

        <form action="{{ route('admin.course_users.store') }}" method="POST">
            @csrf
            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- ユーザー --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">ユーザー <span
                                class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span></th>
                        <td class="px-4 py-2">
                            <select name="user_id" class="border rounded px-3 py-2 w-64" required>
                                <option value="">選択してください</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $CourseUser->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 講座 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座 <span
                                class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span></th>
                        <td class="px-4 py-2">
                            <select name="course_id" class="border rounded px-3 py-2 w-64" required>
                                <option value="">選択してください</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id', $CourseUser->course_id ?? '') == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    保存する
                </button>
                <a href="{{ route('admin.course_users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

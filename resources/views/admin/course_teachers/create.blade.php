@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">講座講師作成</h1>

            <form action="{{ route('admin.course_teachers.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- 講座選択 --}}
                <div>
                    <label class="block font-medium mb-1">講座ID <span class="text-red-500">*</span></label>
                    <select name="course_id" class="border px-3 py-2 w-full rounded" required>
                        <option value="">選択してください</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 講師選択 --}}
                <div>
                    <label class="block font-medium mb-1">講師 <span class="text-red-500">*</span></label>
                    <select name="user_id" class="border px-3 py-2 w-full rounded" required>
                        <option value="">選択してください</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 担当区分 --}}
                <div>
                    <label class="block font-medium mb-1">担当区分 <span class="text-red-500">*</span></label>
                    <select name="role_in_course" class="border px-3 py-2 w-full rounded" required>
                        <option value="1"
                            {{ is_array(old('role_in_course')) && in_array(1, old('role_in_course')) ? 'selected' : '' }}>
                            責任者</option>
                        <option value="2"
                            {{ is_array(old('role_in_course')) && in_array(2, old('role_in_course')) ? 'selected' : '' }}>
                            講師</option>
                        <option value="3"
                            {{ is_array(old('role_in_course')) && in_array(2, old('role_in_course')) ? 'selected' : '' }}>
                            キャリコン</option>
                        <option value="4"
                            {{ is_array(old('role_in_course')) && in_array(2, old('role_in_course')) ? 'selected' : '' }}>
                            補助</option>

                    </select>
                </div>

                {{-- 保存ボタン --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        保存
                    </button>
                    <a href="{{ route('admin.course_teachers.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

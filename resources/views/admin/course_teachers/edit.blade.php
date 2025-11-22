@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">講座講師編集</h1>

        <form action="{{ route('admin.course_teachers.update', $CourseTeacher->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- 講座 --}}
            <div>
                <label class="block mb-1 font-semibold">講座</label>
                <select name="course_id" class="w-full border rounded px-3 py-2">
                    <option value="">選択してください</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $CourseTeacher->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->course_name }}
                    </option>
                    @endforeach
                </select>
                @error('course_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 講師 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講師 <span class="text-red-500">*</span></label>
                <select name="user_id" class="border px-3 py-2 w-full rounded" required>
                    <option value="">選択してください</option>
                    @foreach($users as $user)
                    @if($user->role_id >= 4) {{-- role_id 4以上のユーザーのみ --}}
                    <option value="{{ $user->id }}" {{ old('user_id', $CourseTeacher->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
                @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 担当区分 --}}
            <div>
                <label class="block font-medium mb-1">担当区分 <span class="text-red-500">*</span></label>
                <select name="role_in_course" class="border px-3 py-2 w-full rounded" required>
                    @php
                    $selectedRole = old('role_in_course', $CourseTeacher->role_in_course ?? '');
                    @endphp

                    <option value="1" {{ $selectedRole == 1 ? 'selected' : '' }}>責任者</option>
                    <option value="2" {{ $selectedRole == 2 ? 'selected' : '' }}>講師</option>
                    <option value="3" {{ $selectedRole == 3 ? 'selected' : '' }}>キャリコン</option>
                    <option value="4" {{ $selectedRole == 4 ? 'selected' : '' }}>補助</option>
                </select>
                @error('role_in_course')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                    更新
                </button>
                <a href="{{ route('admin.course_teachers.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

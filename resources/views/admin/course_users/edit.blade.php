@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">ユーザー講座編集</h1>

        <form action="{{ route('admin.course_users.update', $CourseUser->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- ユーザー選択 --}}
            <div>
                <label class="block mb-1 font-semibold">ユーザー <span class="text-red-500">*</span></label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">選択してください</option>
                    @foreach($users as $user)
                    @if($user->role_id >= 4)
                    <option value="{{ $user->id }}" {{ old('user_id', $CourseUser->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
                @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 講座選択 --}}
            <div>
                <label class="block mb-1 font-semibold">講座 <span class="text-red-500">*</span></label>
                <select name="course_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">選択してください</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $CourseUser->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->course_name }}
                    </option>
                    @endforeach
                </select>
                @error('course_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                    更新
                </button>
                <a href="{{ route('admin.course_users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

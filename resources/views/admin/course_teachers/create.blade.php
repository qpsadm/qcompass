@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6">講座講師作成</h1>

        <form action="{{ route('admin.course_teachers.store') }}" method="POST">
            @csrf
            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- 講座 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座 <span
                                class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span></th>
                        <td class="px-4 py-2">
                            <select name="course_id" class="border rounded px-3 py-2 w-64" required>
                                <option value="">選択してください</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 講師 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講師 <span
                                class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span></th>
                        <td class="px-4 py-2">
                            <select name="user_id" class="border rounded px-3 py-2 w-64" required>
                                <option value="">選択してください</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 担当区分 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">担当区分 <span
                                class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span></th>
                        <td class="px-4 py-2">
                            <select name="role_in_course" class="border rounded px-3 py-2 w-64" required>
                                <option value="">選択してください</option>
                                <option value="1" {{ old('role_in_course') == 1 ? 'selected' : '' }}>責任者</option>
                                <option value="2" {{ old('role_in_course') == 2 ? 'selected' : '' }}>講師</option>
                                <option value="3" {{ old('role_in_course') == 3 ? 'selected' : '' }}>キャリコン</option>
                                <option value="4" {{ old('role_in_course') == 4 ? 'selected' : '' }}>補助</option>
                            </select>
                            @error('role_in_course')
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
                <a href="{{ route('admin.course_teachers.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

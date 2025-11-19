@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24 max-h-screen overflow-y-auto">
    <h1 class="text-2xl font-bold mb-6">講座作成</h1>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            {{-- 講座コード --}}
            <div class="mb-4">
                <label for="course_code" class="block font-medium mb-1">講座コード</label>
                <input type="text" name="course_code" id="course_code" value="{{ old('course_code') }}"
                       class="border-gray-300 border px-2 py-1 w-[100px] rounded-md
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            {{-- 講座分野 --}}
            <div class="mb-4">
                <label for="course_type_ID" class="block font-medium mb-1">講座分野</label>
                <select name="course_type_ID" id="course_type_ID"
                        class="border-gray-300 border px-2 py-1 w-[200px] rounded-md
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">選択してください</option>
                    @foreach ($courseTypes as $type)
                        <option value="{{ $type->id }}" {{ old('course_type_ID') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 講座種類 --}}
            <div class="mb-4">
                <label for="Level_id" class="block font-medium mb-1">講座種類</label>
                <select name="Level_id" id="Level_id"
                        class="border-gray-300 border px-2 py-1 w-[200px] rounded-md
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">選択してください</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}" {{ old('Level_id') == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 主催者 --}}
            <div class="mb-4">
                <label for="organizer_id" class="block font-medium mb-1">実施主体（主催者）</label>
                <select name="organizer_id" id="organizer_id"
                        class="border-gray-300 border px-2 py-1 w-[500px] rounded-md
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">選択してください</option>
                    @foreach ($organizers as $organizer)
                        <option value="{{ $organizer->id }}" {{ old('organizer_id') == $organizer->id ? 'selected' : '' }}>
                            {{ $organizer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 講座名 --}}
            <div class="mb-4">
                <label for="course_name" class="block font-medium mb-1">講座名</label>
                <input type="text" name="course_name" id="course_name" value="{{ old('course_name') }}"
                       class="border-gray-300 border px-2 py-1 w-[800px] rounded-md
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            {{-- 会場 --}}
            <div class="mb-4">
                <label for="venue" class="block font-medium mb-1">実施会場</label>
                <input type="text" name="venue" id="venue" value="{{ old('venue') }}"
                       class="border-gray-300 border px-2 py-1 w-[300px] rounded-md
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- 日程 --}}
            <div class="mb-4 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="start_date" class="block font-medium mb-1">開始日</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1">
                    <label for="end_date" class="block font-medium mb-1">終了日</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- 開始時間・終了時間 --}}
            <div class="mb-4 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="start_time" class="block font-medium mb-1">開始時間</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1">
                    <label for="finish_time" class="block font-medium mb-1">終了時間</label>
                    <input type="time" name="finish_time" id="finish_time" value="{{ old('finish_time') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- 総授業時間・時限数 --}}
            <div class="mb-4 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="total_hours" class="block font-medium mb-1">総授業時間</label>
                    <input type="number" name="total_hours" id="total_hours" value="{{ old('total_hours') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1">
                    <label for="periods" class="block font-medium mb-1">時限数</label>
                    <input type="number" name="periods" id="periods" value="{{ old('periods') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- 閲覧期間 --}}
            <div class="mb-4 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="start_viewing" class="block font-medium mb-1">閲覧開始</label>
                    <input type="date" name="start_viewing" id="start_viewing" value="{{ old('start_viewing') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1">
                    <label for="finish_viewing" class="block font-medium mb-1">閲覧終了</label>
                    <input type="date" name="finish_viewing" id="finish_viewing" value="{{ old('finish_viewing') }}"
                           class="border-gray-300 border px-2 py-1 w-full rounded-md
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- 作成者 --}}
            <div class="mb-4">
                <label for="created_user_id" class="block font-medium mb-1 text-gray-700">作成者名</label>
                <input type="text" name="created_user_id" id="created_user_id" value="{{ old('created_user_id') }}"
                       class="border-gray-300 border px-2 py-1 w-[300px] rounded-md
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex gap-2 mb-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    保存
                </button>
                <a href="{{ route('admin.courses.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                   一覧に戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

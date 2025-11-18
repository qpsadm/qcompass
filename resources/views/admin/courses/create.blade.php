@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">講座作成</h1>

        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            {{-- 講座コード --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講座コード</label>
                <input type="text" name="course_code" value="{{ old('course_code') }}"
                    class="border px-2 py-1 w-full rounded" required>
            </div>

            {{-- 講座分野 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講座分野</label>
                <select name="course_type_ID" class="border px-2 py-1 w-full rounded" required>
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
                <label class="block font-medium mb-1">講座種類</label>
                <select name="Level_id" class="border px-2 py-1 w-full rounded" required>
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
                <label class="block font-medium mb-1">実施主体（主催者）</label>
                <select name="organizer_id" class="border px-2 py-1 w-full rounded" required>
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
                <label class="block font-medium mb-1">講座名</label>
                <input type="text" name="course_name" value="{{ old('course_name') }}"
                    class="border px-2 py-1 w-full rounded" required>
            </div>

            {{-- 会場 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">実施会場</label>
                <input type="text" name="venue" value="{{ old('venue') }}" class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 日程 --}}
            <div class="mb-4 flex gap-2">
                <div>
                    <label class="block font-medium mb-1">開始日</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                        class="border px-2 py-1 rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">終了日</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="border px-2 py-1 rounded">
                </div>
            </div>

            {{-- 総授業時間 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">総授業時間</label>
                <input type="text" name="total_hours" value="{{ old('total_hours') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 作成者 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">作成者名</label>
                <input type="text" name="created_user_id" value="{{ old('created_user_id') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <div class="flex gap-2 mb-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
                <a href="{{ route('admin.courses.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
            </div>
        </form>
    </div>
@endsection

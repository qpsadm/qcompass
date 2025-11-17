@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">講座編集</h1>

        <form action="{{ route('admin.courses.update', $Course->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- 講座コード --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講座コード</label>
                <input type="text" name="course_code" value="{{ old('course_code', $Course->course_code ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 講座分野 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講座分野</label>
                <select name="course_type_ID" class="border px-2 py-1 w-full rounded">
                    <option value="">選択してください</option>
                    <option value="1" {{ old('course_type_ID', $Course->course_type_ID) == 1 ? 'selected' : '' }}>IT
                    </option>
                    <option value="2" {{ old('course_type_ID', $Course->course_type_ID) == 2 ? 'selected' : '' }}>ビジネス
                    </option>
                    <option value="3" {{ old('course_type_ID', $Course->course_type_ID) == 3 ? 'selected' : '' }}>語学
                    </option>
                </select>
            </div>

            {{-- 講座種類 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講座種類</label>
                <select name="Level_id" class="border px-2 py-1 w-full rounded">
                    <option value="">選択してください</option>
                    <option value="1" {{ old('Level_id', $Course->Level_id) == 1 ? 'selected' : '' }}>初級</option>
                    <option value="2" {{ old('Level_id', $Course->Level_id) == 2 ? 'selected' : '' }}>中級</option>
                    <option value="3" {{ old('Level_id', $Course->Level_id) == 3 ? 'selected' : '' }}>上級</option>
                </select>
            </div>

            {{-- 主催者 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">主催者</label>
                <select name="organizer_id" class="border px-2 py-1 w-full rounded">
                    <option value="">選択してください</option>
                    @foreach ($organizers as $organizer)
                        <option value="{{ $organizer->id }}"
                            {{ old('organizer_id', $Course->organizer_id) == $organizer->id ? 'selected' : '' }}>
                            {{ $organizer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 講座名 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講座名</label>
                <input type="text" name="course_name" value="{{ old('course_name', $Course->course_name ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 実施会場 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">実施会場</label>
                <input type="text" name="venue" value="{{ old('venue', $Course->venue ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 日付関連 --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">申請日</label>
                    <input type="date" name="application_date"
                        value="{{ old('application_date', $Course->application_date ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">認定日</label>
                    <input type="date" name="certification_date"
                        value="{{ old('certification_date', $Course->certification_date ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">開始日</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $Course->start_date ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">終了日</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $Course->end_date ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
            </div>

            {{-- 認定番号 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">認定番号</label>
                <input type="text" name="certification_number"
                    value="{{ old('certification_number', $Course->certification_number ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 総授業時間・時限数 --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">総授業時間</label>
                    <input type="text" name="total_hours" value="{{ old('total_hours', $Course->total_hours ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">時限数</label>
                    <input type="text" name="periods" value="{{ old('periods', $Course->periods ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
            </div>

            {{-- 開始時間・終了時間 --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">開始時間</label>
                    <input type="time" name="start_time" value="{{ old('start_time', $Course->start_time ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">終了時間</label>
                    <input type="time" name="finish_time" value="{{ old('finish_time', $Course->finish_time ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
            </div>

            {{-- 閲覧期間 --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">閲覧開始</label>
                    <input type="date" name="start_viewing"
                        value="{{ old('start_viewing', $Course->start_viewing ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">閲覧終了</label>
                    <input type="date" name="finish_viewing"
                        value="{{ old('finish_viewing', $Course->finish_viewing ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
            </div>

            {{-- ファイルパス --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">日別計画書パス</label>
                <input type="text" name="plan_path" value="{{ old('plan_path', $Course->plan_path ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">チラシパス</label>
                <input type="text" name="flier_path" value="{{ old('flier_path', $Course->flier_path ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 定員・申込者・完了者 --}}
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">定員</label>
                    <input type="text" name="capacity" value="{{ old('capacity', $Course->capacity ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">申込者数</label>
                    <input type="text" name="entering" value="{{ old('entering', $Course->entering ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div>
                    <label class="block font-medium mb-1">完了者数</label>
                    <input type="text" name="completed" value="{{ old('completed', $Course->completed ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
            </div>

            {{-- 説明 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">説明</label>
                <textarea name="description" class="border px-2 py-1 w-full rounded" rows="3">{{ old('description', $Course->description ?? '') }}</textarea>
            </div>

            {{-- 状態 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">状態</label>
                <input type="text" name="status" value="{{ old('status', $Course->status ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <div class="flex gap-2 mb-8">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
                <a href="{{ route('admin.courses.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
            </div>

        </form>
    </div>
@endsection

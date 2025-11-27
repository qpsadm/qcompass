@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6">
            講座編集：{{ $Course->course_name ?? '新規作成' }}
        </h1>

        <form action="{{ isset($Course) ? route('admin.courses.update', $Course->id) : route('admin.courses.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($Course))
                @method('PUT')
            @endif

            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- 講座コード --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座コード</th>
                        <td class="px-4 py-2">
                            <input type="text" name="course_code"
                                value="{{ old('course_code', $Course->course_code ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                            @error('course_code')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 講座名 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座名</th>
                        <td class="px-4 py-2">
                            <input type="text" name="course_name"
                                value="{{ old('course_name', $Course->course_name ?? '') }}"
                                class="border rounded px-3 py-2 w-80">
                            @error('course_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 講座分野 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座分野</th>
                        <td class="px-4 py-2">
                            <select name="course_type_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択してください</option>
                                @foreach ($courseTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('course_type_id', $Course->course_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_type_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 講座種類 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座種類</th>
                        <td class="px-4 py-2">
                            <select name="level_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択してください</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level_id', $Course->level_id ?? '') == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 主催者 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">主催者</th>
                        <td class="px-4 py-2">
                            <select name="organizer_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択してください</option>
                                @foreach ($organizers as $org)
                                    <option value="{{ $org->id }}"
                                        {{ old('organizer_id', $Course->organizer_id ?? '') == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organizer_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 実施会場 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">実施会場</th>
                        <td class="px-4 py-2">
                            <input type="text" name="venue" value="{{ old('venue', $Course->venue ?? '') }}"
                                class="border rounded px-3 py-2 w-80">
                            @error('venue')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    {{-- 開始日・終了日 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">期間</th>
                        <td class="px-4 py-2 flex gap-2">
                            <input type="date" name="start_date"
                                value="{{ old('start_date', isset($Course->start_date) ? $Course->start_date->format('Y-m-d') : '') }}"
                                class="border rounded px-3 py-2">
                            ～
                            <input type="date" name="end_date"
                                value="{{ old('end_date', isset($Course->end_date) ? $Course->end_date->format('Y-m-d') : '') }}"
                                class="border rounded px-3 py-2">
                        </td>
                    </tr>

                    {{-- 開始時間・終了時間 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">時間</th>
                        <td class="px-4 py-2 flex gap-2">
                            <input type="time" name="start_time"
                                value="{{ old('start_time', isset($Course->start_time) ? $Course->start_time->format('H:i') : '') }}"
                                class="border rounded px-3 py-2">
                            ～
                            <input type="time" name="finish_time"
                                value="{{ old('finish_time', isset($Course->finish_time) ? $Course->finish_time->format('H:i') : '') }}"
                                class="border rounded px-3 py-2">
                        </td>
                    </tr>

                    {{-- 総授業時間・時限数 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">授業時間 / 時限数</th>
                        <td class="px-4 py-2 flex gap-2">
                            <input type="number" name="total_hours"
                                value="{{ old('total_hours', $Course->total_hours ?? '') }}"
                                class="border rounded px-3 py-2 w-32">
                            /
                            <input type="number" name="periods" value="{{ old('periods', $Course->periods ?? '') }}"
                                class="border rounded px-3 py-2 w-24">
                        </td>
                    </tr>

                    {{-- 日別計画書 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">日別計画書</th>
                        <td class="px-4 py-2">
                            <input type="file" name="plan_path" class="border rounded px-3 py-2 w-full mb-2">
                            @if (isset($Course) && $Course->plan_path)
                                <a href="{{ asset('storage/' . $Course->plan_path) }}" target="_blank"
                                    class="text-blue-500 underline">現在のファイルを確認</a>
                            @endif
                        </td>
                    </tr>

                    {{-- フライヤー --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">フライヤー</th>
                        <td class="px-4 py-2">
                            <input type="file" name="flier_path" class="border rounded px-3 py-2 w-full mb-2">
                            @if (isset($Course) && $Course->flier_path)
                                <a href="{{ asset('storage/' . $Course->flier_path) }}" target="_blank"
                                    class="text-blue-500 underline">現在のファイルを確認</a>
                            @endif
                        </td>
                    </tr>

                    {{-- 定員・申込者数・修了者数 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">定員 / 申込 / 修了</th>
                        <td class="px-4 py-2 flex gap-2">
                            <input type="number" name="capacity" value="{{ old('capacity', $Course->capacity ?? '') }}"
                                class="border rounded px-3 py-2 w-24">
                            /
                            <input type="number" name="entering" value="{{ old('entering', $Course->entering ?? '') }}"
                                class="border rounded px-3 py-2 w-24">
                            /
                            <input type="number" name="completed"
                                value="{{ old('completed', $Course->completed ?? '') }}"
                                class="border rounded px-3 py-2 w-24">
                        </td>
                    </tr>

                    {{-- 説明 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">説明</th>
                        <td class="px-4 py-2">
                            <textarea name="description" class="border rounded px-3 py-2 w-full">{{ old('description', $Course->description ?? '') }}</textarea>
                        </td>
                    </tr>

                    {{-- 状態 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">状態</th>
                        <td class="px-4 py-2">
                            <select name="status" class="border rounded px-3 py-2 w-48">
                                @foreach (\App\Models\Course::STATUS as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('status', $Course->status ?? 0) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">保存</button>
                <a href="{{ route('admin.courses.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
            </div>
        </form>
    </div>
@endsection

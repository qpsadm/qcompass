@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24">
    <h1 class="text-2xl font-bold mb-6">{{ $Quiz->id ? 'クイズ編集' : 'クイズ作成' }}</h1>

    <div class="bg-white rounded-lg shadow-md p-6">

        <form action="{{ $Quiz->id ? route('admin.quizzes.update', $Quiz->id) : route('admin.quizzes.store') }}" method="POST">
            @csrf
            @if($Quiz->id)
            @method('PUT')
            @endif

            {{-- クイズコード --}}
            <div class="mb-4">
                <label class="block font-medium mb-1 text-gray-700">クイズコード</label>
                <input type="text" name="code" value="{{ old('code', $Quiz->code ?? '') }}" class="border px-2 py-1 w-full rounded" required>
            </div>

            {{-- クイズ名 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1 text-gray-700">クイズ名</label>
                <input type="text" name="title" value="{{ old('title', $Quiz->title ?? '') }}" class="border px-2 py-1 w-full rounded" required>
            </div>

            {{-- 概要説明 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1 text-gray-700">概要説明</label>
                <textarea name="description" class="border px-2 py-1 w-full rounded">{{ old('description', $Quiz->description ?? '') }}</textarea>
            </div>

            {{-- 関連講座 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1 text-gray-700">関連講座（任意）</label>
                <select name="course_id" class="border px-2 py-1 w-full rounded">
                    <option value="">選択してください</option>
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ (old('course_id', $Quiz->course_id ?? '') == $course->id) ? 'selected' : '' }}>
                        {{ $course->course_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- クイズ種類 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1 text-gray-700">種類</label>
                <select name="type" class="border px-2 py-1 w-full rounded" required>
                    <option value="">選択してください</option>
                    <option value="0" {{ (old('type', $Quiz->type ?? '') == 0) ? 'selected' : '' }}>試験</option>
                    <option value="1" {{ (old('type', $Quiz->type ?? '') == 1) ? 'selected' : '' }}>アンケート</option>
                    <option value="2" {{ (old('type', $Quiz->type ?? '') == 2) ? 'selected' : '' }}>練習</option>
                </select>
            </div>

            {{-- 制限時間 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1 text-gray-700">制限時間（分）</label>
                <input type="number" name="time_limit" value="{{ old('time_limit', $Quiz->time_limit ?? '') }}" class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 満点 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1 text-gray-700">満点</label>
                <input type="number" name="total_score" value="{{ old('total_score', $Quiz->total_score ?? '') }}" class="border px-2 py-1 w-full rounded">
            </div>

            {{-- 公開期間 --}}
            <div class="mb-4 flex gap-2">
                <div class="w-1/2">
                    <label class="block font-medium mb-1 text-gray-700">公開開始日</label>
                    <input type="datetime-local" name="active_from" value="{{ $Quiz->active_from ? $Quiz->active_from->format('Y-m-d\TH:i') : old('active_from') }}" class="border px-2 py-1 rounded w-full">
                </div>
                <div class="w-1/2">
                    <label class="block font-medium mb-1 text-gray-700">公開終了日</label>
                    <input type="datetime-local" name="active_to" value="{{ $Quiz->active_to ? $Quiz->active_to->format('Y-m-d\TH:i') : old('active_to') }}" class="border px-2 py-1 rounded w-full">
                </div>
            </div>

            {{-- ランダム順 --}}
            <div class="mb-4 flex items-center gap-2">
                <input type="checkbox" name="random_order" value="1" {{ ($Quiz->random_order ?? old('random_order')) ? 'checked' : '' }} class="h-4 w-4">
                <label class="text-gray-700 font-semibold">問題順をランダムにする</label>
            </div>

            <div class="flex gap-2 mb-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">保存</button>
                <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">一覧に戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection

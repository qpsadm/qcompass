@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">
        {{ $Quiz->id ? 'クイズ編集' : '新規作成' }}
    </h1>

    <form action="{{ $Quiz->id ? route('admin.quizzes.update', $Quiz->id) : route('admin.quizzes.store') }}" method="POST" class="space-y-4">
        @csrf
        @if($Quiz->id)
        @method('PUT')
        @endif

        {{-- クイズコード --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">クイズコード</label>
            <input type="text" name="code" value="{{ old('code', $Quiz->code ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- クイズ名 --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">クイズ名</label>
            <input type="text" name="title" value="{{ old('title', $Quiz->title ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        {{-- 概要説明 --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">概要説明</label>
            <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $Quiz->description ?? '') }}</textarea>
        </div>

        {{-- 関連講座ID --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">関連講座ID（任意）</label>
            <input type="text" name="course_id" value="{{ old('course_id', $Quiz->course_id ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 関連アジェンダID --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">関連アジェンダID（任意）</label>
            <input type="text" name="agenda_id" value="{{ old('agenda_id', $Quiz->agenda_id ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 問題タイプ --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">問題タイプ</label>
            <select name="type" class="w-full ...">
                <option value="">選択してください</option>
                <option value="1" {{ old('type', $Quiz->type) == 1 ? 'selected' : '' }}>試験</option>
                <option value="2" {{ old('type', $Quiz->type) == 2 ? 'selected' : '' }}>アンケート</option>
                <option value="3" {{ old('type', $Quiz->type) == 3 ? 'selected' : '' }}>練習</option>
            </select>
        </div>

        {{-- 制限時間 --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">制限時間（分）</label>
            <input type="number" name="time_limit" value="{{ old('time_limit', $Quiz->time_limit ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 満点 --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">満点</label>
            <input type="number" name="total_score" value="{{ old('total_score', $Quiz->total_score ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 合格点 --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">合格点</label>
            <input type="number" name="passing_score" value="{{ old('passing_score', $Quiz->passing_score ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- ランダム順 --}}
        <div class="flex items-center gap-2">
            <input type="checkbox" name="random_order" value="1" {{ old('random_order', $Quiz->random_order ?? false) ? 'checked':'' }} class="h-4 w-4">
            <label class="text-gray-700 font-semibold">問題順をランダムにする</label>
        </div>

        {{-- 公開開始日 --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">公開開始日</label>
            <input type="datetime-local" name="active_from" value="{{ old('active_from', $Quiz->active_from?->format('Y-m-d\TH:i')) }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 公開終了日 --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">公開終了日</label>
            <input type="datetime-local" name="active_to" value="{{ old('active_to', $Quiz->active_to?->format('Y-m-d\TH:i')) }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- 保存ボタン --}}
        <div class="flex items-center gap-3 mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">保存</button>
            <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">一覧に戻る</a>
        </div>
    </form>
</div>
@endsection

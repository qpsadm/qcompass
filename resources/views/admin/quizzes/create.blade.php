@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">クイズ作成</h1>

    <form action="{{ route('admin.quizzes.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- code --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">クイズコード</label>
            <input
                type="text"
                name="code"
                value="{{ old('code', $Quiz->code ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- title --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">クイズ名</label>
            <input
                type="text"
                name="title"
                value="{{ old('title', $Quiz->title ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- description --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">概要説明</label>
            <input
                type="text"
                name="description"
                value="{{ old('description', $Quiz->description ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- course_id --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">関連講座ID　※任意</label>
            <input
                type="text"
                name="course_id"
                value="{{ old('course_id', $Quiz->course_id ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- agenda_id --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">関連アジェンダID　※任意</label>
            <input
                type="text"
                name="agenda_id"
                value="{{ old('agenda_id', $Quiz->agenda_id ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- type --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">問題タイプ</label>
            <input
                type="text"
                name="type"
                value="{{ old('type', $Quiz->type ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- time_limit --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">制限時間（分）</label>
            <input
                type="text"
                name="time_limit"
                value="{{ old('time_limit', $Quiz->time_limit ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- total_score --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">満点</label>
            <input
                type="text"
                name="total_score"
                value="{{ old('total_score', $Quiz->total_score ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- passing_score --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">合格点</label>
            <input
                type="text"
                name="passing_score"
                value="{{ old('passing_score', $Quiz->passing_score ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- random_order --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">ランダム順</label>
            <input
                type="text"
                name="random_order"
                value="{{ old('random_order', $Quiz->random_order ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- active_from --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">公開開始日</label>
            <input
                type="text"
                name="active_from"
                value="{{ old('active_from', $Quiz->active_from ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- active_to --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">公開終了日</label>
            <input
                type="text"
                name="active_to"
                value="{{ old('active_to', $Quiz->active_to ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- created_by --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">作成者</label>
            <input
                type="text"
                name="created_by"
                value="{{ old('created_by', $Quiz->created_by ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>


        {{-- ボタン --}}
        <div class="flex items-center gap-3 mt-4">
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                保存
            </button>
            <a
                href="{{ route('admin.quizzes.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">タグ編集</h1>

            <form action="{{ route('admin.tags.update', $Tag->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- タグコード --}}
                <div>
                    <label class="block font-medium mb-1">タグコード</label>
                    <input type="text" name="code" value="{{ old('code', $Tag->code ?? '') }}"
                        class="border px-3 py-2 w-full rounded" placeholder="任意">
                </div>

                {{-- タグ名 --}}
                <div>
                    <label class="block font-medium mb-1">タグ名 <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $Tag->name ?? '') }}"
                        class="border px-3 py-2 w-full rounded" placeholder="必須" required>
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4" x-data="{ is_show: {{ old('is_show', $JobOffer->is_show ?? 0) }} }">
                    <span class="font-medium mr-2">表示フラグ</span>
                    <div class="flex gap-2">
                        <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                            <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                            公開
                        </label>

                        <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                            <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                            非公開
                        </label>
                    </div>
                </div>

                {{-- 保存ボタン --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        更新
                    </button>

                    <a href="{{ route('admin.tags.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

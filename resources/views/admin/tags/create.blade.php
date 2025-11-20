@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">タグ作成</h1>

            <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- タグコード --}}
                <div>
                    <label class="block font-medium mb-1">タグコード</label>
                    <input type="text" name="code" value="{{ old('code', $tag->code ?? '') }}"
                        class="border px-3 py-2 w-full rounded" placeholder="任意">
                </div>

                {{-- タグ名 --}}
                <div>
                    <label class="block font-medium mb-1">タグ名 <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $tag->name ?? '') }}"
                        class="border px-3 py-2 w-full rounded" placeholder="必須" required>
                </div>

                {{-- 表示フラグ --}}
                <div>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_show" value="1"
                            {{ old('is_show', $tag->is_show ?? true) ? 'checked' : '' }} class="form-checkbox">
                        表示する
                    </label>
                </div>

                {{-- 保存ボタン --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        保存
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

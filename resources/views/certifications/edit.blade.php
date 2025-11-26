@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">資格編集</h1>

            {{-- エラー表示 --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 編集フォーム --}}
            <form action="{{ route('admin.certifications.update', $certification->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- 資格名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">資格名<span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="border px-2 py-1 w-full rounded"
                        value="{{ old('name', $certification->name) }}" required>
                </div>

                {{-- レベル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">資格レベル</label>
                    <select name="level" class="border px-2 py-1 w-full rounded">
                        @php
                            $levels = [1 => '初級', 2 => '上級'];
                        @endphp
                        <option value="">選択してください</option>
                        @foreach ($levels as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('level', $certification->level) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 説明 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明・備考</label>
                    <textarea name="description" class="border px-2 py-1 w-full rounded">{{ old('description', $certification->description) }}</textarea>
                </div>

                {{-- 参照URL --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">参照URL</label>
                    <input type="text" name="url" class="border px-2 py-1 w-full rounded"
                        value="{{ old('url', $certification->url) }}">
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-6">
                    <label class="block font-medium mb-1">表示設定</label>
                    <input type="checkbox" name="is_show" value="1"
                        {{ old('is_show', $certification->is_show) ? 'checked' : '' }}>
                    <span>公開する</span>
                </div>

                {{-- 送信ボタン --}}
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        更新する
                    </button>
                    <a href="{{ route('admin.job_offers.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

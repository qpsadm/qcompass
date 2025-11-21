@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ作成</h1>

            {{-- エラー表示 --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('learning.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- 種別 --}}
                @php
                    $types = [
                        'book' => '1. 本',
                        'site' => '2. サイト',
                        'video' => '3. 動画',
                        'article' => '4. 記事',
                    ];
                @endphp
                <div class="mb-4">
                    <label class="block font-medium mb-1">種類<span class="text-red-500">*</span></label>
                    <select name="type" class="border px-2 py-1 w-full rounded">
                        <option value="">選択してください</option>
                        @foreach ($types as $value => $label)
                            <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- タイトル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">タイトル<span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="border px-2 py-1 w-full rounded"
                        value="{{ old('name') }}">
                </div>

                {{-- 説明 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明・備考</label>
                    <input type="text" name="description" class="border px-2 py-1 w-full rounded"
                        value="{{ old('description') }}">
                </div>

                {{-- 画像 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">画像（URL またはファイル）</label>
                    <input type="text" name="image" class="border px-2 py-1 w-full rounded" placeholder="URL"
                        value="{{ old('image') }}">
                    <input type="file" name="image_file" class="mt-2">
                </div>

                {{-- URL --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">URL</label>
                    <input type="text" name="url" class="border px-2 py-1 w-full rounded"
                        value="{{ old('url') }}">
                </div>

                {{-- 出版社 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">出版社</label>
                    <input type="text" name="publisher" class="border px-2 py-1 w-full rounded"
                        value="{{ old('publisher') }}">
                </div>

                {{-- 難易度 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">難易度</label>
                    <select name="level" class="border px-2 py-1 w-full rounded">
                        <option value="">選択してください</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('level') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- タグ --}}
                <div class="mb-6">
                    <label class="block font-medium mb-1">タグ</label>
                    <select name="tags[]" multiple class="border px-2 py-1 w-full rounded h-32">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" @if (collect(old('tags'))->contains($tag->id)) selected @endif>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-gray-500 text-sm mt-1">※ Ctrl（Command）で複数選択</p>
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-6">
                    <label class="block font-medium mb-1">表示設定</label>
                    <input type="checkbox" name="display_flag" value="1" {{ old('display_flag') ? 'checked' : '' }}>
                    <span>公開する</span>
                </div>

                {{-- 送信 --}}
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        登録する
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ作成（管理画面）</h1>

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

            <form action="{{ route('admin.learnings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @php
                    $types = [
                        'book' => '1. 本',
                        'site' => '2. サイト',
                        'video' => '3. 動画',
                        'article' => '4. 記事',
                    ];
                    $levels = [
                        1 => '初級',
                        2 => '上級',
                    ];
                    $tag_id = [
                        'hard' => '1. ハードウェア',
                        'soft' => '2. ソフトウェア',
                        'network' => '3. ネットワーク・通信',
                        'data' => '4. データ・情報処理',
                        'program' => '5. プログラミング',
                        'webcreate' => '6. WEB制作',
                        'webdesign' => '7.WEBデザイン',
                        'security' => '8. セキュリティ',
                        'certification' => '9. 資格',
                        'job' => '10. 就職支援',
                        'other' => '4. 記事',
                    ];
                @endphp

                {{-- 種別 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">種類<span class="text-red-500">*</span></label>
                    <select name="type" class="border px-2 py-1 w-full rounded" required>
                        <option value="">選択してください</option>
                        @foreach ($types as $value => $label)
                            <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- タイトル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">タイトル<span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="border px-2 py-1 w-full rounded" value="{{ old('title') }}"
                        required>
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
                    <label class="block font-medium mb-1">参照URL</label>
                    <input type="text" name="url" class="border px-2 py-1 w-full rounded"
                        value="{{ old('url') }}">
                </div>

                {{-- 難易度 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">レベル</label>
                    <select name="level" class="border px-2 py-1 w-full rounded">
                        <option value="">選択してください</option>
                        @foreach ($levels as $key => $label)
                            <option value="{{ $key }}" {{ old('level') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- タグ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">タグ<span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($tags as $tag)
                            <div>
                                <input type="radio" name="tag_id" value="{{ $tag->id }}"
                                    {{ old('tag_id') == $tag->id ? 'checked' : '' }} id="tag-{{ $tag->id }}">
                                <label for="tag-{{ $tag->id }}" class="ml-2">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
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

                {{-- 送信 --}}
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        登録する
                    </button>

                    <a href="{{ route('admin.learnings.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

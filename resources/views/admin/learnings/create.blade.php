@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">参考用コンテンツ作成</h1>

            {{-- バリデーション --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                // $types = [
                //     'book' => '参考書籍',
                //     'site' => '参考サイト',
                //     'video' => 'IT資格',
                //     'article' => '制作品',
                // ];
                $types = [
                    '1' => '参考書籍',
                    '2' => '参考サイト',
                    '3' => 'IT資格',
                    '4' => '制作品',
                ];

                $levels = ['1' => '初級', '2' => '中級', '3' => '上級'];

                // $tags = [
                //     1 => 'WEB制作',
                //     2 => 'WEBデザイン',
                //     3 => 'プログラミング',
                //     4 => 'OA',
                //     5 => 'その他',
                // ];

            @endphp

            <form action="{{ route('admin.learnings.store') }}" method="POST" enctype="multipart/form-data"
                x-data="{ type: '{{ old('type') }}', is_show: {{ old('is_show', 1) }}, description: `{!! addslashes(old('description')) !!}`, previewWindow: null }">
                @csrf

                <table class="w-full table-auto border-collapse">
                    <tbody>
                        {{-- タイトル --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium w-60">
                                タイトル
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="border rounded px-3 py-2 w-full" required>
                            </td>
                        </tr>

                        {{-- 種類 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium w-60">
                                種類
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <select name="type" x-model="type" class="border rounded px-3 py-2 w-60" required>
                                    <option value="">選択してください</option>
                                    @foreach ($types as $value => $label)
                                        <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        {{-- タグ --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                タグ
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    {{-- @foreach ($tags as $id => $label)
                                        <label class="inline-flex items-center gap-1">
                                            <input type="radio" name="tag_id" value="{{ $id }}"
                                                {{ old('tag_id') == $id ? 'checked' : '' }} required>
                                            {{ $label }}
                                        </label>
                                    @endforeach --}}
                                    @foreach ($tags as $tag)
                                        <label class="inline-flex items-center gap-4 mr-4">
                                            <input type="radio" name="tag_id" value="{{ $tag->id }}"
                                                {{ old('tag_id') == $tag->id ? 'checked' : '' }} required>
                                            {{ $tag->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>

                        {{-- レベル --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                レベル
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <select name="level" class="border rounded px-3 py-2 w-60" required>
                                    <option value="">選択してください</option>
                                    @foreach ($levels as $id => $label)
                                        <option value="{{ $id }}" {{ old('level') == $id ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        {{-- 説明 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">説明</th>
                            <td class="px-4 py-2">
                                <textarea name="description" x-model="description" rows="5" class="border rounded px-3 py-2 w-full"></textarea>

                                {{-- <button type="button"
                                    class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                                    @click="
                                    if(!previewWindow || previewWindow.closed){
                                        previewWindow = window.open('', 'preview', 'width=800,height=600');
                                        previewWindow.document.head.innerHTML='<style>body{font-family:sans-serif;padding:1rem;}</style>';
                                    }
                                    previewWindow.document.body.innerHTML = description.replace(/\n/g,'<br>');
                                ">
                                    プレビュー
                                </button> --}}
                            </td>
                        </tr>

                        {{-- 画像 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">画像</th>
                            <td class="px-4 py-2">
                                <input type="text" name="image" placeholder="画像URL"
                                    class="border rounded px-3 py-2 w-full mb-2" value="{{ old('image') }}">
                                <input type="file" name="image_file">
                            </td>
                        </tr>

                        {{-- 参照URL --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">参照URL</th>
                            <td class="px-4 py-2">
                                <input type="text" name="url" class="border rounded px-3 py-2 w-full"
                                    value="{{ old('url') }}">
                            </td>
                        </tr>

                        {{-- article専用 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                訓練科名
                                <span class="bg-blue-500 text-white text-xs px-2 py-2 rounded ml-1">制作品専用</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="course_name" value="{{ old('course_name') }}"
                                    placeholder="例： WEBプログラマー養成科第23期: 憩チーム(7人)" class="border rounded px-3 py-2 w-full">

                                {{-- <select name="course_name" class="border px-2 py-1 rounded">
                                    <option value="">講座を選んでください</option>
                                    @foreach ($courses as $id => $course)
                                        <option value="{{ $course->course_name }}"
                                            {{ request('course_name') === $course->course_name ? 'selected' : '' }}>
                                            {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select> --}}
                            </td>
                        </tr>

                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                訓練期間
                                <span class="bg-blue-500 text-white text-xs px-2 py-2 rounded ml-1">制作品専用</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="priod" class="border rounded px-3 py-2 w-full"
                                    placeholder="例： 2026年3月26日～2026年9月25日" value="{{ old('priod') }}">
                            </td>
                        </tr>

                        {{-- 表示状態 --}}
                        <tr>
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">表示状態</th>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200'"
                                        class="px-4 py-2 rounded-full cursor-pointer">
                                        <input type="radio" name="is_show" value="1" class="hidden"
                                            x-model="is_show">
                                        公開
                                    </label>
                                    <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200'"
                                        class="px-4 py-2 rounded-full cursor-pointer">
                                        <input type="radio" name="is_show" value="0" class="hidden"
                                            x-model="is_show">
                                        非公開
                                    </label>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                {{-- ボタン --}}
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="save bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        登録
                    </button>
                    <a href="{{ route('admin.learnings.index') }}"
                        class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

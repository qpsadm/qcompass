@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">
                学習コンテンツ編集：{{ $learning->title ?? '新規作成' }}
            </h1>

            {{-- バリデーション --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $types = ['book' => '参考書籍', 'site' => '参考サイト', 'video' => 'IT資格', 'article' => '制作品'];
                $levels = [1 => '初級', 2 => '上級'];
                $tags = [1 => 'WEB制作', 2 => 'WEBデザイン', 3 => 'プログラミング', 4 => 'OA', 5 => 'その他'];
            @endphp

            <form action="{{ route('admin.learnings.update', $learning->id) }}" method="POST" enctype="multipart/form-data"
                x-data="{
                    type: {{ json_encode(old('type', $learning->type)) }},
                    is_show: {{ old('is_show', $learning->is_show ?? 1) }},
                    description: {{ json_encode(old('description', $learning->description ?? '')) }}
                }">
                @csrf
                @method('PUT')

                <table class="w-full table-auto border-collapse">
                    <tbody>

                        {{-- 種類 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium w-1/4">
                                種類
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <select name="type" x-model="type" class="border rounded px-3 py-2 w-60" required>
                                    <option value="">選択してください</option>
                                    @foreach ($types as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        {{-- タイトル --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                タイトル
                                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="title" value="{{ old('title', $learning->title) }}"
                                    class="border rounded px-3 py-2 w-full" required>
                            </td>
                        </tr>

                        {{-- 説明 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">説明</th>
                            <td class="px-4 py-2">
                                <textarea name="description" x-model="description" rows="5" class="border rounded px-3 py-2 w-full"></textarea>
                            </td>
                        </tr>

                        {{-- 画像 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">画像</th>
                            <td class="px-4 py-2">
                                <input type="text" name="image" value="{{ old('image', $learning->image) }}"
                                    class="border rounded px-3 py-2 w-full mb-2">

                                <input type="file" name="image_file">

                                <label class="inline-flex items-center gap-2 mt-2 text-sm">
                                    <input type="checkbox" name="delete_image" value="1">
                                    既存画像を削除
                                </label>
                            </td>
                        </tr>

                        {{-- 参照URL --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">参照URL</th>
                            <td class="px-4 py-2">
                                <input type="text" name="url" value="{{ old('url', $learning->url) }}"
                                    class="border rounded px-3 py-2 w-full">
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
                                        <option value="{{ $id }}"
                                            {{ old('level', $learning->level) == $id ? 'selected' : '' }}>
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
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($tags as $id => $label)
                                        <label class="inline-flex items-center gap-1">
                                            <input type="radio" name="tag_id" value="{{ $id }}"
                                                {{ old('tag_id', $learning->tag_id) == $id ? 'checked' : '' }}>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>

                        {{-- 制作品専用 --}}
                        <tr class="border-b" x-show="type === 'article'">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">訓練科名</th>
                            <td class="px-4 py-2">
                                <input type="text" name="course_name"
                                    value="{{ old('course_name', $learning->course_name) }}"
                                    class="border rounded px-3 py-2 w-full">
                            </td>
                        </tr>

                        <tr class="border-b" x-show="type === 'article'">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">制作期間</th>
                            <td class="px-4 py-2">
                                <input type="text" name="priod" value="{{ old('priod', $learning->priod) }}"
                                    class="border rounded px-3 py-2 w-full">
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
                        更新
                    </button>
                    <a href="{{ route('admin.learnings.index') }}"
                        class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>


            {{-- 危険操作ゾーン --}}
            @if (isset($learning))
                <div class="mt-10 pt-6 border-t border-red-200" x-data="{ deleteOpen: false }">
                    <h2 class="text-red-600 font-semibold mb-2">⚠ 危険な操作</h2>
                    <p class="text-sm text-gray-600 mb-4">
                        このコンテンツを削除すると元に戻せません。
                    </p>
                    <button @click="deleteOpen = true"
                        class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">削除する</button>

                    {{-- 削除確認モーダル --}}
                    <div x-show="deleteOpen" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div x-show="deleteOpen" x-transition.scale.duration.200ms
                            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                            <p class="text-gray-700 text-center mb-5">「{{ $learning->title ?? 'このコンテンツ' }}」を削除しますか？</p>
                            <div class="flex justify-center gap-4">
                                <button @click="deleteOpen = false"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">キャンセル</button>
                                <form action="{{ route('admin.learnings.destroy', $learning->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">削除する</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

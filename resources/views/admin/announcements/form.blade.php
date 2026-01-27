@extends('layouts.app')

@section('content')
@php
$types = $types ?? collect();
$courses = $courses ?? collect();
$currentStatus = old('status', $announcement->status ?? 2);
$currentIsShow = old('is_show', $announcement->is_show ?? 1);
$storageBaseUrl = env('APP_STORAGE_URL', url('/storage'));
@endphp

<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">
            {{ isset($announcement->id) ? 'お知らせ編集' : 'お知らせ新規作成' }}
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

        <form id="announcement-form"
            method="POST"
            action="{{ isset($announcement->id)
                ? route('admin.announcements.update', $announcement->id)
                : route('admin.announcements.store') }}">
            @csrf
            @if (isset($announcement->id))
            @method('PUT')
            @endif

            <table class="w-full table-auto border-collapse">
                <tbody>

                    {{-- タイトル --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                            タイトル
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="title"
                                value="{{ old('title', $announcement->title ?? '') }}"
                                class="border rounded px-3 py-2 w-full" required>
                        </td>
                    </tr>

                    {{-- カテゴリ --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                            カテゴリ
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <select name="type_id" class="border rounded px-3 py-2 w-80" required>
                                <option value="">選択してください</option>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}"
                                    @selected(old('type_id', $announcement->type_id ?? '') == $type->id)>
                                    {{ $type->type_name }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    {{-- 講座 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">講座</th>
                        <td class="px-4 py-2">
                            <select name="course_id" class="border rounded px-3 py-2 w-80">
                                <option value="">全員向け</option>
                                @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    @selected(old('course_id', $announcement->course_id ?? '') == $course->id)>
                                    {{ $course->course_name }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    {{-- 本文 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">本文</th>
                        <td class="px-4 py-2">
                            <textarea name="content" id="announcement-content" rows="6"
                                class="border rounded px-3 py-2 w-full">{{ old('content', $announcement->content ?? '') }}</textarea>
                        </td>
                    </tr>

                    {{-- 表示フラグ --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">表示フラグ</th>
                        <td class="px-4 py-2" x-data="{ is_show: {{ $currentIsShow }} }">
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
                        </td>
                    </tr>

                    {{-- 状態 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">状態</th>
                        <td class="px-4 py-2">
                            <select name="status" class="border rounded px-3 py-2 w-60">
                                <option value="0" @selected($currentStatus==0)>下書き</option>
                                <option value="1" @selected($currentStatus==1)>承認待ち</option>
                                <option value="2" @selected($currentStatus==2)>承認済み</option>
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>

            {{-- ファイル一覧（既存ロジックそのまま） --}}
            @if(isset($announcement) && $announcement->files->isNotEmpty())
            <div class="mt-6 bg-gray-50 p-4 rounded border">
                <h2 class="text-lg font-semibold mb-3">登録済みファイル一覧</h2>
                <table class="w-full table-auto border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-3 py-2">ファイル名</th>
                            <th class="border px-3 py-2">サイズ</th>
                            <th class="border px-3 py-2">プレビュー</th>
                            <th class="border px-3 py-2">URLコピー</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($announcement->files as $file)
                        @php
                        $relativePath = str_replace('public/', '', $file->file_path);
                        $fileUrl = rtrim($storageBaseUrl, '/') . '/' . $relativePath;
                        @endphp
                        <tr>
                            <td class="border px-3 py-2">{{ $file->file_name }}</td>
                            <td class="border px-3 py-2">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                            <td class="border px-3 py-2">
                                @if (Str::startsWith($file->file_type, 'image/'))
                                <a href="{{ $fileUrl }}" target="_blank">
                                    <img src="{{ $fileUrl }}" class="w-20 h-20 object-cover rounded">
                                </a>
                                @else
                                N/A
                                @endif
                            </td>
                            <td class="border px-3 py-2">
                                <button type="button"
                                    class="bg-gray-200 px-2 py-1 rounded text-sm"
                                    onclick="navigator.clipboard.writeText('{{ $fileUrl }}').then(()=>alert('URLをコピーしました'))">
                                    URLコピー
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- ボタン --}}
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    {{ isset($announcement->id) ? '更新' : '保存' }}
                </button>
                <a href="{{ route('admin.announcements.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('announcement-content', {
            language: 'ja',
            allowedContent: true
        });
        document.getElementById('announcement-form').addEventListener('submit', function() {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });
    </script>

    <style>
        .cke_notifications_area {
            display: none !important;
        }
    </style>
</div>
@endsection

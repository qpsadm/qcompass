@extends('layouts.app')

@section('content')
@php
$types = $types ?? collect();
$courses = $courses ?? collect();
$currentStatus = old('status', $announcement->status ?? 2);
$currentIsShow = old('is_show', $announcement->is_show ?? 1);
$storageBaseUrl = env('APP_STORAGE_URL', url('/storage'));
@endphp

<div class="container mx-auto p-6 flex justify-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-2xl p-6">
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

        <form method="POST"
            action="{{ isset($announcement->id) ? route('admin.announcements.update', $announcement->id) : route('admin.announcements.store') }}"
            id="announcement-form">
            @csrf
            @if (isset($announcement->id))
            @method('PUT')
            @endif

            {{-- タイトル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">タイトル <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $announcement->title ?? '') }}"
                    class="border px-3 py-2 w-full rounded">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- カテゴリ --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">カテゴリ <span class="text-red-500">*</span></label>
                <select name="type_id" class="border px-3 py-2 w-full rounded">
                    <option value="">選択してください</option>
                    @foreach ($types as $type)
                    <option value="{{ $type->id }}" @selected(old('type_id', $announcement->type_id ?? '') == $type->id)>
                        {{ $type->type_name }}
                    </option>
                    @endforeach
                </select>
                @error('type_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 講座 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">講座</label>
                <select name="course_id" class="border px-3 py-2 w-full rounded">
                    <option value="">全員向け</option>
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}" @selected(old('course_id', $announcement->course_id ?? '') == $course->id)>
                        {{ $course->course_name }}
                    </option>
                    @endforeach
                </select>
                @error('course_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 本文 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">本文</label>
                <textarea name="content" id="announcement-content" rows="5" class="border px-3 py-2 w-full rounded">{{ old('content', $announcement->content ?? '') }}</textarea>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 表示フラグ --}}
            <div class="mb-4" x-data="{ is_show: {{ $currentIsShow }} }">
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


            {{-- 状態 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">状態</label>
                <select name="status" class="border px-3 py-2 w-full rounded">
                    <option value="0" @selected($currentStatus==0)>下書き</option>
                    <option value="1" @selected($currentStatus==1)>承認待ち</option>
                    <option value="2" @selected($currentStatus==2)>承認済み</option>
                </select>
            </div>

            {{-- ファイル一覧 --}}
            @if(isset($announcement) && $announcement->files->isNotEmpty())
            <div class="mt-6 bg-gray-50 p-4 rounded border">
                <h2 class="text-lg font-semibold mb-3">登録済みファイル一覧</h2>
                <table class="w-full table-auto border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-3 py-2 text-left">ファイル名</th>
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
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-sm">{{ $file->file_name }}</td>
                            <td class="border px-3 py-2 text-sm">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                            <td class="border px-3 py-2">
                                @if (Str::startsWith($file->file_type, 'image/'))
                                <a href="{{ $fileUrl }}" target="_blank">
                                    <img src="{{ $fileUrl }}" class="w-20 h-20 object-cover rounded mx-auto" alt="プレビュー">
                                </a>
                                @else
                                <span class="text-gray-500 text-xs">N/A</span>
                                @endif
                            </td>
                            <td class="border px-3 py-2 text-center">
                                <button type="button"
                                    class="bg-gray-200 px-2 py-1 rounded text-xs hover:bg-gray-300"
                                    onclick="navigator.clipboard.writeText('{{ $fileUrl }}').then(() => { alert('URLをコピーしました'); });">
                                    URLコピー
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- ファイル追加 --}}
            @if(isset($announcement->id))
            <a href="{{ route('admin.files.create', [
    'type'=>'announcement',
    'targetId'=>$announcement->id,
    'return'=>request()->fullUrl()
]) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                ファイル追加
            </a>
            @endif

            {{-- 更新・一覧 --}}
            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">更新</button>
                <a href="{{ route('admin.announcements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
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
            for (var instance in CKEDITOR.instances) CKEDITOR.instances[instance].updateElement();
        });
    </script>

    <style>
        .cke_notifications_area {
            display: none !important;
        }
    </style>
</div>
@endsection

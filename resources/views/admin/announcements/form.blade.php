@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">
            {{ isset($announcement->id) ? 'お知らせ編集' : 'お知らせ新規作成' }}
        </h1>

        <form method="POST" action="{{ isset($announcement->id) ? route('admin.announcements.update', $announcement->id) : route('admin.announcements.store') }}" id="announcement-form">
            @csrf
            @if(isset($announcement->id))
            @method('PUT')
            @endif

            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- タイトル --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">タイトル
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="title" value="{{ old('title', $announcement->title ?? '') }}"
                                class="border rounded px-3 py-2 w-full">
                            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- カテゴリ --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">カテゴリ
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <select name="type_id" class="border rounded px-3 py-2 w-64">
                                <option value="">選択してください</option>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected(old('type_id', $announcement->type_id ?? '') == $type->id)>
                                    {{ $type->type_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('type_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 講座 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座</th>
                        <td class="px-4 py-2">
                            <select name="course_id" class="border rounded px-3 py-2 w-64">
                                <option value="">全員向け</option>
                                @foreach ($courses as $course)
                                <option value="{{ $course->id }}" @selected(old('course_id', $announcement->course_id ?? '') == $course->id)>{{ $course->course_name }}</option>
                                @endforeach
                            </select>
                            @error('course_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 本文 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">本文</th>
                        <td class="px-4 py-2">
                            <textarea name="content" id="announcement-content" rows="5" class="border rounded px-3 py-2 w-full">{{ old('content', $announcement->content ?? '') }}</textarea>
                            @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 表示フラグ --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示</th>
                        <td class="px-4 py-2">
                            <input type="hidden" name="is_show" value="0">
                            <input type="checkbox" name="is_show" value="1" @checked(old('is_show', $announcement->is_show ?? 1))>
                            表示
                            @error('is_show') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 状態 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">状態（status）</th>
                        <td class="px-4 py-2">
                            <select name="status" class="border rounded px-3 py-2 w-32">
                                <option value="1" @selected(old('status', $announcement->status ?? 2) == 1)>承認待ち</option>
                                <option value="2" @selected(old('status', $announcement->status ?? 2) == 2)>承認済み</option>
                            </select>
                            @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">{{ isset($announcement->id) ? '更新' : '作成' }}</button>
                <a href="{{ route('admin.announcements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
            </div>
        </form>
    </div>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        var editor = CKEDITOR.replace('announcement-content', {
            language: 'ja',
            allowedContent: true,
        });

        document.getElementById('announcement-form').addEventListener('submit', function(e) {
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

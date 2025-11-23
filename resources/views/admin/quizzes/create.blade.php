@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-5xl">
    <h1 class="text-3xl font-bold mb-6">クイズ作成</h1>

    {{-- フォーム --}}
    <form action="{{ route('admin.quizzes.store') }}" method="POST">
        @csrf
        <table class="w-full table-auto border-collapse">
            <tbody>
                {{-- タイトル --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">タイトル
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="border rounded px-3 py-2 w-64">
                        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- コース --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">コース選択</th>
                    <td class="px-4 py-2">
                        <select name="course_id" class="border rounded px-3 py-2 w-64">
                            <option value="">選択してください</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id')==$course->id)>
                                {{ $course->course_name }} ({{ $course->course_code }})
                            </option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 種類 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">種類</th>
                    <td class="px-4 py-2">
                        <select name="type" class="border rounded px-3 py-2 w-64">
                            <option value="1" @selected(old('type')==1)>試験</option>
                            <option value="2" @selected(old('type')==2)>アンケート</option>
                            <option value="3" @selected(old('type')==3)>練習</option>
                        </select>
                        @error('type') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 状態 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">状態</th>
                    <td class="px-4 py-2">
                        <select name="status" class="border rounded px-3 py-2 w-32">
                            <option value="1" @selected(old('status', 2)==1)>承認待ち</option>
                            <option value="2" @selected(old('status', 2)==2)>承認済み</option>
                        </select>
                        @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 公開フラグ --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">公開フラグ</th>
                    <td class="px-4 py-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_show" value="1" {{ old('is_show', 1) ? 'checked' : '' }}>
                            <span>公開</span>
                        </label>
                        @error('is_show') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- 保存＋一覧に戻る --}}
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                保存する
            </button>
            <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection

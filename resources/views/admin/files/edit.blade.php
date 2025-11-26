@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">
                {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} ファイル編集
            </h1>

            <form action="{{ route('admin.files.update', ['type' => $type, 'id' => $file->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="target_type" value="{{ $type }}">
                <input type="hidden" name="target_id" value="{{ $file->target_id }}">

                <input type="hidden" name="target_type" value="{{ $type }}">
                <input type="hidden" name="target_id" value="{{ $file->target_id }}">

                {{-- 対象選択（target_idが未固定の場合のみ） --}}
                @if (!isset($target))
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} <span class="text-red-500">*</span>
                        </label>
                        <select name="target_id" class="border px-2 py-1 w-full rounded" required>
                            <option value="">選択してください</option>
                            @foreach ($targets as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('target_id', $file->target_id) == $item->id ? 'selected' : '' }}>
                                    {{ $type === 'agenda' ? $item->agenda_name : $item->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('target_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- ファイル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイル</label>
                    <input type="file" name="file_path" class="border px-2 py-1 w-full rounded">
                    @if ($file->file_path)
                        <p class="text-sm text-gray-500 mt-1">
                            現在のファイル: {{ $file->file_name ?? $file->file_path }}
                        </p>
                    @endif
                </div>

                {{-- ファイル名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイル名</label>
                    <input type="text" name="file_name" value="{{ old('file_name', $file->file_name) }}"
                        class="border px-2 py-1 w-full rounded">
                    @error('file_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 説明 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">用途・備考</label>
                    <input type="text" name="description" value="{{ old('description', $file->description) }}"
                        class="border px-2 py-1 w-full rounded">
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ボタン --}}
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        保存
                    </button>
                    <a href="{{ route('admin.files.index', ['type' => $type, 'targetId' => $file->target_id]) }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-4xl">

        <h1 class="text-2xl font-bold mb-6">
            {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} ファイル編集
        </h1>

        <form action="{{ route('admin.files.update', ['type' => $type, 'id' => $file->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="target_type" value="{{ $type }}">
            <input type="hidden" name="target_id" value="{{ $file->target_id }}">

            <table class="w-full border-collapse">

                {{-- 対象 --}}
                @if (!isset($target))
                    <tr class="border-b">
                        <th class="w-1/4 bg-gray-100 px-4 py-3 text-right font-medium">
                            {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }}
                            <span class="text-red-500 ml-1">*</span>
                        </th>
                        <td class="px-4 py-3">
                            <select name="target_id" class="border rounded px-3 py-2 w-full" required>
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
                        </td>
                    </tr>
                @endif

                {{-- ファイル --}}
                <tr class="border-b" x-data="{
                    previewWindow: null,
                    previewUrl: '{{ $file->file_path ? asset('storage/' . $file->file_path) : '' }}',
                    openPreview() {
                        if (!this.previewUrl) return;
                
                        if (!this.previewWindow || this.previewWindow.closed) {
                            this.previewWindow = window.open('', 'preview', 'width=900,height=700');
                        }
                        this.previewWindow.location.href = this.previewUrl;
                    },
                    changeFile(e) {
                        const file = e.target.files[0];
                        if (file) {
                            this.previewUrl = URL.createObjectURL(file);
                        }
                    }
                }">
                    <th class="w-1/4 bg-gray-100 px-4 py-3 text-right font-medium">
                        ファイル
                    </th>
                    <td class="px-4 py-3 space-y-2">

                        {{-- ファイル選択 --}}
                        <input type="file" name="file_path" class="border rounded px-3 py-2 w-full" @change="changeFile">

                        {{-- 現在のファイル --}}
                        @if ($file->file_path)
                            <p class="text-sm text-gray-600 break-all">
                                現在：
                                {{ $file->file_name ?? $file->file_path }}
                            </p>
                        @endif

                        {{-- プレビュー --}}
                        <div class="flex items-center gap-3">
                            <button type="button" @click="openPreview" :disabled="!previewUrl"
                                class="px-4 py-2 text-sm rounded text-white"
                                :class="previewUrl ? 'bg-blue-500 hover:bg-blue-600' : 'bg-gray-300 cursor-not-allowed'">
                                プレビュー
                            </button>

                            <span class="text-sm text-gray-500">
                                別ウィンドウで表示されます
                            </span>
                        </div>
                    </td>
                </tr>


                {{-- ファイル名 --}}
                <tr class="border-b">
                    <th class="w-1/4 bg-gray-100 px-4 py-3 text-right font-medium">
                        ファイル名
                    </th>
                    <td class="px-4 py-3">
                        <input type="text" name="file_name" value="{{ old('file_name', $file->file_name) }}"
                            class="border rounded px-3 py-2 w-full">
                        @error('file_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

                {{-- 説明 --}}
                <tr class="border-b">
                    <th class="w-1/4 bg-gray-100 px-4 py-3 text-right font-medium">
                        用途・備考
                    </th>
                    <td class="px-4 py-3">
                        <input type="text" name="description" value="{{ old('description', $file->description) }}"
                            class="border rounded px-3 py-2 w-full">
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

            </table>

            {{-- ボタン --}}
            <div class="mt-6 flex gap-3">
                <button type="submit" class="save bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    保存
                </button>

                <a href="{{ route('admin.files.index', ['type' => $type, 'targetId' => 0]) }}"
                    class="back bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>

        </form>
    </div>
@endsection

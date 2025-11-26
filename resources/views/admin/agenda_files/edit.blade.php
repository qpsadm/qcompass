@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">アジェンダファイル編集</h1>

            <form action="{{ route('admin.agenda_files.update', $agendaFile->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- アジェンダ選択 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">アジェンダ <span class="text-red-500">*</span></label>
                    <select name="target_id" class="border px-2 py-1 w-full rounded" required>
                        <option value="">選択してください</option>
                        @foreach ($agendas as $agenda)
                            <option value="{{ $agenda->id }}"
                                {{ old('target_id', $agendaFile->target_id) == $agenda->id ? 'selected' : '' }}>
                                {{ $agenda->agenda_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ファイル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイル</label>
                    <input type="file" name="file_path" class="border px-2 py-1 w-full rounded">
                    @if ($agendaFile->file_path)
                        <p class="text-sm text-gray-500 mt-1">現在のファイル:
                            {{ $agendaFile->file_name ?? $agendaFile->file_path }}</p>
                    @endif
                </div>

                {{-- ファイル名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイル名</label>
                    <input type="text" name="file_name" value="{{ old('file_name', $agendaFile->file_name) }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- ファイルタイプ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイルタイプ</label>
                    <input type="text" name="file_type" value="{{ old('file_type', $agendaFile->file_type) }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 説明 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明</label>
                    <input type="text" name="description" value="{{ old('description', $agendaFile->description) }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">保存</button>
                    <a href="{{ route('admin.agenda_files.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
@endsection

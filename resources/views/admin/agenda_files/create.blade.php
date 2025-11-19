@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">

        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <h1 class="text-2xl font-bold mb-6">アジェンダファイル作成</h1>

            <form action="{{ route('admin.agenda_files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- アジェンダ選択 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">アジェンダ <span class="text-red-500">*</span></label>
                    <select name="agenda_id" class="border px-2 py-1 w-full rounded" required>
                        <option value="">選択してください</option>
                        @foreach ($agendas as $agenda)
                            <option value="{{ $agenda->id }}" {{ old('agenda_id') == $agenda->id ? 'selected' : '' }}>
                                {{ $agenda->agenda_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ファイル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイル <span class="text-red-500">*</span></label>
                    <input type="file" name="file_path" class="border px-2 py-1 w-full rounded" required>
                </div>

                {{-- ファイル名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイル名</label>
                    <input type="text" name="file_name" value="{{ old('file_name') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- ファイルタイプ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">ファイルタイプ</label>
                    <input type="text" name="file_type" value="{{ old('file_type') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 説明 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">用途・備考</label>
                    <input type="text" name="description" value="{{ old('description') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
            </form>
        </div>
    @endsection

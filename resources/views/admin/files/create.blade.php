@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">
                {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} ファイル作成
            </h1>

            <form action="{{ route('admin.files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="target_type" value="{{ $type }}">
                <input type="hidden" name="target_id" value="{{ $target->id ?? 0 }}">

                <table class="w-full table-auto border-collapse">
                    <tbody>
                        {{-- 対象選択（target_idが未指定の場合だけ） --}}
                        @if (!isset($target))
                            <tr class="border-b">
                                <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">
                                    {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} <span class="text-red-500">*</span>
                                </th>
                                <td class="px-4 py-2">
                                    <select name="target_id"
                                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="">選択してください</option>
                                        @foreach ($targets as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('target_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->{$type === 'agenda' ? 'agenda_name' : 'title'} }}
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
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                                ファイル <span class="text-red-500">*</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="file" name="file_path"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                @error('file_path')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- ファイル名 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">ファイル名</th>
                            <td class="px-4 py-2">
                                <input type="text" name="file_name" value="{{ old('file_name') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('file_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 説明 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">用途・備考</th>
                            <td class="px-4 py-2">
                                <input type="text" name="description" value="{{ old('description') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- ボタン --}}
                <div class="flex gap-3 mt-6 justify-start">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded shadow-sm transition">
                        保存
                    </button>
                    <a href="{{ route('admin.files.index', ['type' => $type, 'targetId' => $target->id ?? 0]) }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow-sm transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

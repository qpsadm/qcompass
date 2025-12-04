@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-5xl">
    <h1 class="text-3xl font-bold mb-6">求人票編集：{{ $job_offer->title ?? '新規作成' }}</h1>

    <form action="{{ route('admin.job_offers.update', $job_offer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table class="w-full table-auto border-collapse">
            <tbody>
                {{-- 求人タイトル --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">求人タイトル</th>
                    <td class="px-4 py-2">
                        <input type="text" name="title" value="{{ old('title', $job_offer->title ?? '') }}" class="border rounded px-3 py-2 w-full">
                        @error('title')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </td>
                </tr>

                {{-- 説明文 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">説明文</th>
                    <td class="px-4 py-2">
                        <textarea name="description" class="border rounded px-3 py-2 w-full">{{ old('description', $job_offer->description ?? '') }}</textarea>
                        @error('description')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </td>
                </tr>

                {{-- PDF --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">PDFファイル</th>
                    <td class="px-4 py-2 flex gap-2 items-center">
                        <input type="file" name="pdf_file" class="border rounded px-3 py-2">
                        @if ($job_offer->file_path)
                        <a href="{{ asset('storage/' . $job_offer->file_path) }}" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200">確認</a>
                        @endif
                        @error('pdf_file')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </td>
                </tr>

                {{-- 表示開始日時 / 終了日時 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示期間</th>
                    <td class="px-4 py-2 flex gap-2 items-center">
                        <input type="date" name="start_datetime" value="{{ old('start_datetime', $job_offer->start_datetime?->format('Y-m-d')) }}" class="border rounded px-3 py-2">
                        ～
                        <input type="date" name="end_datetime" value="{{ old('end_datetime', $job_offer->end_datetime?->format('Y-m-d')) }}" class="border rounded px-3 py-2">
                    </td>
                </tr>

                {{-- 表示フラグ --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示フラグ</th>
                    <td class="px-4 py-2" x-data="{ is_show: Number('{{ old('is_show', $job_offer->is_show ?? 1) }}') }">
                        <div class="flex gap-2">
                            <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                                <input type="radio" name="is_show" :value="1" class="hidden" x-model="is_show">
                                公開
                            </label>
                            <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                                <input type="radio" name="is_show" :value="0" class="hidden" x-model="is_show">
                                非公開
                            </label>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">更新する</button>
            <a href="{{ route('admin.job_offers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
        </div>
    </form>
</div>
@endsection

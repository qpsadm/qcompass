@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票編集</h1>

            <form action="{{ route('admin.job_offers.update', $job_offer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">求人タイトル</label>
                    <input type="text" name="title" value="{{ old('title', $job_offer->title) }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">説明文</label>
                    <textarea name="description" class="border px-2 py-1 w-full rounded">{{ old('description', $job_offer->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">PDFファイル</label>
                    @if ($job_offer->file_path)
                        <p>現在のファイル: <a href="{{ asset('storage/' . $job_offer->file_path) }}" target="_blank">確認</a></p>
                    @endif
                    <input type="file" name="pdf_file" class="border px-2 py-1 w-full rounded">
                </div>

                <div class="mb-4" x-data="{ is_show: {{ old('is_show', $JobOffer->is_show ?? 0) }} }">
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




                <div class="mt-6 flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新する</button>
                    <a href="{{ route('admin.job_offers.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        一覧に戻る
                    </a>
                </div>
        </div>
        </form>
    </div>
    </div>
@endsection

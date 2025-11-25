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
                <input type="text" name="title" value="{{ old('title', $job_offer->title) }}" class="border px-2 py-1 w-full rounded">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">説明文</label>
                <textarea name="description" class="border px-2 py-1 w-full rounded">{{ old('description', $job_offer->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">PDFファイル</label>
                @if($job_offer->file_path)
                    <p>現在のファイル: <a href="{{ asset('storage/' . $job_offer->file_path) }}" target="_blank">確認</a></p>
                @endif
                <input type="file" name="pdf_file" class="border px-2 py-1 w-full rounded">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">表示フラグ</label>
                <input type="checkbox" name="is_show" value="1" {{ $job_offer->is_show ? 'checked' : '' }}>
                <span>表示する</span>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新する</button>
        </form>
    </div>
</div>
@endsection

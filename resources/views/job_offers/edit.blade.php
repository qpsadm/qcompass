@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">求人票編集</h1>
        <form action="{{ route('job_offers.update', $JobOffer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">求人タイトル</label>
                <input type="text" name="title" value="{{ old('title', $JobOffer->title ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">会社名</label>
                <input type="text" name="company" value="{{ old('company', $JobOffer->company ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">PDFファイル保存パス</label>
                <input type="text" name="file_path" value="{{ old('file_path', $JobOffer->file_path ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">更新者ID</label>
                <input type="text" name="user_id" value="{{ old('user_id', $JobOffer->user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">削除日</label>
                <input type="text" name="deleted_at" value="{{ old('deleted_at', $JobOffer->deleted_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection

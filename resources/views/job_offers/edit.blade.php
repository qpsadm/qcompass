@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票編集</h1>
            <form action="{{ route('admin.job_offers.update', $job_offer->id) }}" method="POST">

                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-medium mb-1">求人タイトル</label>
                    <input type="text" name="title" value="{{ old('title', $job_offer->title ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明・備考</label>
                    <input type="text" name="description" value="{{ old('description', $job_offer->company ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">PDFファイル保存パス</label>
                    <input type="text" name="file_path" value="{{ old('file_path', $job_offer->file_path ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">更新者名</label>
                    <input type="text" name="updated_user_name"
                        value="{{ old('updated_user_name', $job_offer->updated_user_name ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>


                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>

                <a href="{{ route('admin.job_offers.index') }}" class="ml-2 text-gray-600">キャンセル</a>
            </form>
        </div>
    @endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票作成</h1>
            <form action="{{ route('job_offers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium mb-1">求人票のタイトル</label>
                    <input type="text" name="title" value="{{ old('title', $JobOffer->title ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明文</label>
                    <input type="text" name="description" value="{{ old('company', $JobOffer->company ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                
                <div class="mb-4">
                    <label class="block font-medium mb-1">PDFファイル保存パス</label>
                    <input type="text" name="file_path" value="{{ old('file_path', $JobOffer->file_path ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示開始日時</label>
                    <input type="date" name="start_datetime" value="{{ old('user_id', $JobOffer->user_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">表示修了日時</label>
                    <input type="date" name="end_datetime" value="{{ old('user_id', $JobOffer->user_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示フラグ</label>
                    <input type="text" name="user_id" value="{{ old('user_id', $JobOffer->user_id ?? '') }}"
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

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
            </form>
        </div>
    @endsection

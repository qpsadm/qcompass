@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票詳細</h1>
            <div class="border p-4 rounded mb-4">
                <p><strong>求人タイトル:</strong> {{ $job_offer->title }}</p>
                <p><strong>説明・備考:</strong> {{ $job_offer->company }}</p>
                <p><strong>PDFファイル保存パス:</strong> {{ $job_offer->file_path }}</p>
                <p><strong>更新者名:</strong> {{ $job_offer->updated_user_name }}</p>
                <p><strong>削除:</strong> {{ $job_offer->deleted_at }}</p>

            </div>
            <a href="{{ route('admin.job_offers.edit', $job_offer->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.job_offers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    @endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票詳細</h1>
            <div class="border p-4 rounded mb-4">
                <p><strong>求人タイトル:</strong> {{ $JobOffer->title }}</p>
                <p><strong>会社名:</strong> {{ $JobOffer->company }}</p>
                <p><strong>PDFファイル保存パス:</strong> {{ $JobOffer->file_path }}</p>
                <p><strong>更新者ID:</strong> {{ $JobOffer->user_id }}</p>
                <p><strong>削除:</strong> {{ $JobOffer->deleted_at }}</p>

            </div>
            <a href="{{ route('job_offers.edit', $JobOffer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('job_offers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    @endsection

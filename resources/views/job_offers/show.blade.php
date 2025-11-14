@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">JobOffer詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>title:</strong> {{ $JobOffer->title }}</p>
<p><strong>company:</strong> {{ $JobOffer->company }}</p>
<p><strong>file_path:</strong> {{ $JobOffer->file_path }}</p>
<p><strong>user_id:</strong> {{ $JobOffer->user_id }}</p>
<p><strong>deleted_at:</strong> {{ $JobOffer->deleted_at }}</p>

    </div>
    <a href="{{ route('job_offers.edit', $JobOffer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('job_offers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection
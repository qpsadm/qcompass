@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Report詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>user_id:</strong> {{ $Report->user_id }}</p>
<p><strong>course_id:</strong> {{ $Report->course_id }}</p>
<p><strong>date:</strong> {{ $Report->date }}</p>
<p><strong>title:</strong> {{ $Report->title }}</p>
<p><strong>content:</strong> {{ $Report->content }}</p>
<p><strong>impression:</strong> {{ $Report->impression }}</p>
<p><strong>notice:</strong> {{ $Report->notice }}</p>
<p><strong>created_user_id:</strong> {{ $Report->created_user_id }}</p>
<p><strong>updated_user_id:</strong> {{ $Report->updated_user_id }}</p>
<p><strong>deleted_at:</strong> {{ $Report->deleted_at }}</p>
<p><strong>deleted_user_id:</strong> {{ $Report->deleted_user_id }}</p>

    </div>
    <a href="{{ route('reports.edit', $Report->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('reports.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection
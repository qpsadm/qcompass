@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24">
    <h1 class="text-2xl font-bold mb-6">カテゴリー一覧</h1>

    <a href="{{ route('admin.categories.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
        ＋ 新規登録
    </a>

    <div class="bg-white shadow-md rounded-lg p-4">
        <ul class="space-y-2">
            @include('admin.categories.partials.category-tree', [
            'categories' => $categories,
            'showActions' => true,
            'radioName' => null
            ])
        </ul>
    </div>
</div>
@endsection

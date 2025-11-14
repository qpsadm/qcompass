@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">カテゴリー一覧</h1>
        <a href="{{ route('admin.categories.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        @include('admin.categories.partials.category-tree', ['categories' => $categories])
    </div>
@endsection

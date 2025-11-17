@extends('layouts.app')

@section('content')
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">ゴミ箱カテゴリ一覧</h1>
        <a href="{{ route('admin.categories.index') }}" class="text-blue-500 underline mb-4 inline-block">← 一覧へ戻る</a>

        <div class="bg-white shadow rounded p-4">
            <ul class="space-y-2">
                @foreach ($categories as $category)
                    <li class="flex items-center justify-between bg-white rounded-md shadow-sm py-2 px-3 hover:bg-gray-50">
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-800">{{ $category->categories_name }}</span>
                            <span class="text-xs text-gray-500">
                                ID: {{ $category->id }} / コード: {{ $category->code }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- 復元 --}}
                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST"
                                style="display:inline">
                                @csrf
                                <button type="submit"
                                    class="px-2 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                                    復活
                                </button>
                            </form>

                            {{-- 完全削除 --}}
                            <form action="{{ route('admin.categories.forceDelete', $category->id) }}" method="POST"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                                    完全削除
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

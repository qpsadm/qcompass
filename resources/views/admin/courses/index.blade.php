@extends('layouts.app')

@php
$sort = request('sort', 'id');
$order = request('order', 'asc');
$nextOrder = $order === 'asc' ? 'desc' : 'asc';
@endphp

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md"
    x-data="{ open:false, deleteUrl:'', deleteName:'' }">

    <h1 class="text-2xl font-bold mb-4">講座一覧</h1>

    {{-- 上部操作 --}}
    <div class="flex items-center justify-between mb-4">

        {{-- 新規作成 --}}
        <a href="{{ route('admin.courses.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>

        {{-- 検索 --}}
        <form method="GET" action="{{ route('admin.courses.index') }}"
            class="flex items-center space-x-2">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="講座コード・講座名で検索"
                class="border px-2 py-1 rounded w-64">
            <button
                class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_search.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">検索</span>
            </button>
        </form>
    </div>

    {{-- 上ページネーション --}}
    <div class="mb-4">
        {{ $courses->appends(request()->query())->links() }}
    </div>

    {{-- テーブル --}}
    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-12 text-center">No.</th>

                    <th class="border px-4 py-2 w-16 text-center">
                        <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort'=>'id','order'=>$nextOrder])) }}"
                            class="flex items-center justify-center">
                            <span>ID</span>
                            @if($sort==='id')
                            <span>{{ $order==='asc'?'▲':'▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <th class="border px-4 py-2 w-24">
                        <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort'=>'course_code','order'=>$nextOrder])) }}"
                            class="flex items-center">
                            <span>講座コード</span>
                            @if($sort==='course_code')
                            <span>{{ $order==='asc'?'▲':'▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.courses.index', array_merge(request()->query(), ['sort'=>'course_name','order'=>$nextOrder])) }}"
                            class="flex items-center">
                            <span>講座名</span>
                            @if($sort==='course_name')
                            <span>{{ $order==='asc'?'▲':'▼' }}</span>
                            @endif
                        </a>
                    </th>

                    <th class="border px-4 py-2">分野</th>
                    <th class="border px-4 py-2 w-32">期間</th>
                    <th class="border px-4 py-2">状態</th>
                    <th class="border px-4 py-2 text-center">表示</th>
                    <th class="border px-4 py-2 w-24 text-center">受講生</th>
                    <th class="border px-4 py-2 w-56 text-center">操作</th>
                </tr>
            </thead>

            <tbody>
                @forelse($courses as $course)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ ($courses->currentPage()-1)*$courses->perPage()+$loop->iteration }}
                    </td>
                    <td class="border px-4 py-2 text-center">{{ $course->id }}</td>
                    <td class="border px-4 py-2">{{ $course->course_code }}</td>
                    <td class="border px-4 py-2">{{ $course->course_name }}</td>
                    <td class="border px-4 py-2">{{ $course->courseType->name ?? '-' }}</td>
                    <td class="border px-4 py-2">
                        {{ $course->start_date }} ～ {{ $course->end_date }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ \App\Models\Course::STATUS[$course->status] ?? '不明' }}
                    </td>
                    <td class="border px-4 py-2 text-center">
                        @if($course->is_show)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                        @else
                        <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <a href="{{ route('admin.courses.students',$course->id) }}"
                            class="text-purple-600 hover:underline">一覧</a>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex justify-center space-x-3">
                            <a href="{{ route('admin.courses.show',$course->id) }}"
                                class="text-green-600 hover:underline">詳細</a>
                            <a href="{{ route('admin.courses.edit',$course->id) }}"
                                class="text-blue-600 hover:underline">編集</a>
                            <button
                                @click="open=true;
                                        deleteUrl='{{ route('admin.courses.destroy',$course->id) }}';
                                        deleteName='{{ $course->course_name }}'"
                                class="text-red-600 hover:underline">
                                削除
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-gray-500 py-4">
                        データがありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 下ページネーション --}}
    <div class="mt-4">
        {{ $courses->appends(request()->query())->links() }}
    </div>

    {{-- 削除モーダル --}}
    <div x-show="open" x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-center mb-5">
                「<span x-text="deleteName"></span>」を削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open=false"
                    class="px-4 py-2 bg-gray-300 rounded">
                    キャンセル
                </button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 bg-red-500 text-white rounded">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection

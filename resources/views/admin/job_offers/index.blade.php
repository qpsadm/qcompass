@php
$sort = request('sort', 'id');
$order = request('order', 'asc');
$nextOrder = $order === 'asc' ? 'desc' : 'asc';
@endphp

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-4 text-gray-800">求人票一覧</h1>

    <!-- 新規作成 -->
    <div class="flex items-center justify-start mb-4">
        <a href="{{ route('admin.job_offers.create') }}"
            class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">新規作成</span>
        </a>
    </div>

    <!-- 検索 -->
    <div x-data="searchBox()" class="flex items-center space-x-2 mb-4">
        <form :action="url" method="GET" class="relative flex-1">
            <input type="text" name="search" x-model="search" placeholder="求人タイトルで検索"
                @keydown.enter.prevent="submit()" class="w-full border px-2 py-1 rounded pr-8">
            <button type="button" x-show="search" @click="clear()"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;
            </button>
        </form>
        <button @click="submit()"
            class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
            <img src="{{ asset('assets/images/icon/b_search.svg') }}" class="w-4 h-4">
            <span class="hidden lg:inline ml-1">検索</span>
        </button>

        <script>
            function searchBox() {
                return {
                    search: "{{ request('search') }}",
                    url: "{{ route('admin.job_offers.index') }}",
                    submit() {
                        const form = document.createElement('form');
                        form.method = 'GET';
                        form.action = this.url;
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'search';
                        input.value = this.search;
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    },
                    clear() {
                        this.search = '';
                        this.submit();
                    }
                }
            }
        </script>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-16 text-center">No.</th>
                    <th class="border px-4 py-2 w-32">
                        <a href="{{ route('admin.job_offers.index', array_merge(request()->query(), ['sort'=>'id','order'=>$sort==='id'? $nextOrder:'asc'])) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            ID @if($sort==='id')<span>{{ $order==='asc'?'▲':'▼' }}</span>@endif
                        </a>
                    </th>
                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.job_offers.index', array_merge(request()->query(), ['sort'=>'title','order'=>$sort==='title'? $nextOrder:'asc'])) }}"
                            class="flex items-center justify-center gap-1 hover:underline">
                            求人タイトル @if($sort==='title')<span>{{ $order==='asc'?'▲':'▼' }}</span>@endif
                        </a>
                    </th>
                    <th class="border px-4 py-2 text-center">PDF</th>
                    <th class="border px-4 py-2 text-center">公開期間</th>
                    <th class="border px-4 py-2 text-center">表示</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($job_offers as $jobOffer)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">{{ ($job_offers->currentPage()-1)*$job_offers->perPage() + $loop->iteration }}</td>
                    <td class="border px-4 py-2 text-center">{{ $jobOffer->id }}</td>
                    <td class="border px-4 py-2 truncate max-w-xs" title="{{ $jobOffer->title }}">
                        <a href="{{ route('admin.job_offers.edit', $jobOffer->id) }}" class="text-blue-600 hover:underline">
                            {{ \Illuminate\Support\Str::limit($jobOffer->title,50) }}
                        </a>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        @if($jobOffer->file_path)
                        <a href="{{ url('storage/'.$jobOffer->file_path) }}" target="_blank">
                            <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-6 h-6 inline-block">
                        </a>
                        @else
                        ❌
                        @endif
                    </td>
                    <td class="border px-4 py-2 text-center">
                        {{ $jobOffer->start_datetime? $jobOffer->start_datetime->format('Y-m-d'):'-' }}
                        〜
                        {{ $jobOffer->end_datetime? $jobOffer->end_datetime->format('Y-m-d'):'-' }}
                    </td>
                    <td class="border px-4 py-2 text-center">
                        @if($jobOffer->is_show)
                        <span class="text-green-600">表示</span>
                        @else
                        <span class="text-gray-400">非表示</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">データがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $job_offers->appends(request()->query())->links() }}</div>
    </div>

</div>
@endsection

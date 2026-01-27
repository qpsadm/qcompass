@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-4">日報管理</h1>

    <!-- 検索 -->
    <div class="flex justify-end mb-4" x-data="searchBox()">
        <form :action="url" method="GET" class="relative w-72">
            <input type="text"
                name="search"
                x-model="search"
                placeholder="タイトル・提出者で検索"
                @keydown.enter.prevent="submit()"
                class="w-full border px-3 py-2 rounded pr-8">

            <button type="button"
                x-show="search"
                @click="clear()"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                &times;
            </button>
        </form>

        <button @click="submit()"
            class="ml-2 bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 hover:text-white transition">
            検索
        </button>
    </div>

    <!-- ページネーション（上） -->
    {{ $reports->appends(request()->query())->links() }}

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-12 text-center">No.</th>

                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.reports.index', array_merge(request()->query(), [
                            'sort' => 'user_id',
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                        ])) }}" class="hover:underline">
                            提出者
                            @if(request('sort') === 'user_id')
                            {{ request('direction') === 'asc' ? '▲' : '▼' }}
                            @endif
                        </a>
                    </th>

                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.reports.index', array_merge(request()->query(), [
                            'sort' => 'course_id',
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                        ])) }}" class="hover:underline">
                            講座
                            @if(request('sort') === 'course_id')
                            {{ request('direction') === 'asc' ? '▲' : '▼' }}
                            @endif
                        </a>
                    </th>

                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.reports.index', array_merge(request()->query(), [
                            'sort' => 'date',
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                        ])) }}" class="hover:underline">
                            日付
                            @if(request('sort') === 'date')
                            {{ request('direction') === 'asc' ? '▲' : '▼' }}
                            @endif
                        </a>
                    </th>

                    <th class="border px-4 py-2">タイトル</th>

                    <th class="border px-4 py-2">
                        <a href="{{ route('admin.reports.index', array_merge(request()->query(), [
                            'sort' => 'created_at',
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                        ])) }}" class="hover:underline">
                            送信日時
                            @if(request('sort') === 'created_at')
                            {{ request('direction') === 'asc' ? '▲' : '▼' }}
                            @endif
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody>
                @php
                $counter = ($reports->currentPage() - 1) * $reports->perPage() + 1;
                @endphp

                @forelse($reports as $report)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">
                        {{ $counter++ }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $report->user->name ?? '-' }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $report->course->course_name ?? '-' }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $report->date }}
                    </td>

                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.reports.show', $report->id) }}"
                            class="text-blue-600 hover:underline font-medium">
                            {{ $report->title }}
                        </a>
                    </td>

                    <td class="border px-4 py-2">
                        {{ $report->created_at->format('Y-m-d H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border px-4 py-6 text-center text-gray-500">
                        データがありません
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ページネーション（下） -->
    <div class="mt-4">
        {{ $reports->appends(request()->query())->links() }}
    </div>
</div>

<script>
    function searchBox() {
        return {
            search: "{{ request('search') }}",
            url: "{{ route('admin.reports.index') }}",
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
@endsection

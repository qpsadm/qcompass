@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">お知らせ一覧</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('admin.notices.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">新規作成</a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border-b px-4 py-2">講座名</th>
                <th class="border px-4 py-2">アジェンダ名</th>
                <th class="border px-4 py-2">表示</th>
                <th class="border px-4 py-2">承認</th>
                <th class="border px-4 py-2">作成者</th>
                <th class="border px-4 py-2 text-center">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($agendas as $agenda)
            <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2">
                    @forelse($agenda->courses as $course)
                    <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded mr-1">{{ $course->course_name }}</span>
                    @empty
                    不明な講座
                    @endforelse
                </td>
                </td>
                <td class="border px-4 py-2">{{ $agenda->agenda_name }}</td>
                <td class="border px-4 py-2">{{ $agenda->is_show ? '表示' : '非表示' }}</td>
                <td class="border px-4 py-2">{{ $agenda->accept === 'yes' ? '承認済み' : '下書き' }}</td>
                <td class="border px-4 py-2">{{ optional($agenda->createdUser)->name ?? '不明' }}</td>
                <td class="border px-4 py-2 text-center">
                    <a href="{{ route('admin.notices.edit', $agenda->id) }}"
                        class="text-blue-500 hover:underline mr-2">編集</a>
                    <form action="{{ route('admin.notices.destroy', $agenda->id) }}" method="POST"
                        class="inline-block" onsubmit="return confirm('削除してもよろしいですか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">削除</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">お知らせはまだ登録されていません。</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

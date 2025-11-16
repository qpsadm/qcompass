@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24"> {{-- pb-24 でフッター分の余白 --}}
    <h1 class="text-2xl font-bold mb-6">アジェンダ一覧</h1>

    {{-- 新規作成 --}}
    <a href="{{ route('admin.agendas.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition">
        ＋ 新規作成
    </a>

    {{-- アジェンダ一覧テーブル --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-700">
                    <th class="border-b px-4 py-2">アジェンダ名</th>
                    <th class="border-b px-4 py-2">カテゴリ</th>
                    <th class="border-b px-4 py-2">表示フラグ</th>
                    <th class="border-b px-4 py-2">承認</th>
                    <th class="border-b px-4 py-2">作成者名</th>

                    <th class="border-b px-4 py-2 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agendas as $agenda)
                <tr class="hover:bg-gray-50">
                    <td class="border-b px-4 py-2">{{ $agenda->agenda_name }}</td>
                    <td class="border-b px-4 py-2">{{ $agenda->category?->name ?? '未設定' }}</td>
                    <td class="border-b px-4 py-2">{{ $agenda->is_show ? '表示' : '非表示' }}</td>
                    <td class="border-b px-4 py-2">{{ $agenda->accept === 'yes' ? '承認済み' : '下書き' }}</td>
                    <td>{{ $agenda->user?->name ?? '不明' }}</td> {{-- 作成者名 --}}
                    <td class="border-b px-4 py-2 flex justify-center gap-2">
                        <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="text-green-500 hover:underline">詳細</a>
                        <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="text-blue-500 hover:underline">編集</a>
                        <form action="{{ route('admin.agendas.destroy', $agenda->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">削除</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center text-gray-500 py-4">データがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

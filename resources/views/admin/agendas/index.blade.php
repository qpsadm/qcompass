@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 pb-24">
    <h1 class="text-2xl font-bold mb-6">アジェンダ一覧</h1>

    {{-- 新規作成 --}}
    <div class="mb-4 flex items-center gap-4">
        <a href="{{ route('admin.agendas.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            ＋ 新規作成
        </a>
        <a href="{{ route('admin.agendas.trash') }}" class="text-red-500 underline">
            ゴミ箱
        </a>
    </div>

    {{-- アジェンダ一覧テーブル --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-700">
                    <th class="border-b px-4 py-2">講座名</th>
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
                    {{-- 講座名（複数対応） --}}
                    <td class="border px-4 py-2">
                        @if($agenda->courses->isNotEmpty())
                        {{ $agenda->courses->pluck('course_name')->join(', ') }}
                        @else
                        不明な講座
                        @endif
                    </td>

                    <td class="border px-4 py-2">{{ $agenda->agenda_name }}</td>
                    <td class="border px-4 py-2">{{ $agenda->category?->name ?? '未設定' }}</td>
                    <td class="border px-4 py-2">{{ $agenda->is_show ? '表示' : '非表示' }}</td>
                    <td class="border px-4 py-2">{{ $agenda->accept === 'yes' ? '承認済み' : '下書き' }}</td>
                    <td class="border px-4 py-2">{{ optional($agenda->createdUser)->name ?? '不明' }}</td>

                    {{-- 操作 --}}
                    <td class="border px-4 py-2 flex justify-center gap-2">
                        <a href="{{ route('admin.agendas.show', $agenda->id) }}"
                            class="text-green-500 hover:underline">詳細</a>
                        <a href="{{ route('admin.agendas.edit', $agenda->id) }}"
                            class="text-blue-500 hover:underline">編集</a>
                        <button type="button" class="text-red-500 hover:underline"
                            onclick="openDeleteModal({{ $agenda->id }}, '{{ $agenda->agenda_name }}')">
                            削除
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">データがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- 削除確認モーダル --}}
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-semibold mb-4">削除の確認</h2>
        <p class="mb-6" id="deleteMessage">本当に削除しますか？</p>
        <div class="flex justify-end gap-4">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                キャンセル
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    削除
                </button>
            </form>
        </div>
    </div>
</div>

{{-- モーダル制御スクリプト --}}
<script>
    function openDeleteModal(id, name) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const message = document.getElementById('deleteMessage');

        form.action = "{{ url('admin/agendas') }}/" + id;
        message.textContent = `「${name}」を本当に削除しますか？この操作は取り消せません。`;
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>
@endsection

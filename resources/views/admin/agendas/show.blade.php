@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">アジェンダ詳細</h1>

        <table class="table-auto w-full border-collapse">
            <tbody>
                <tr>
                    <td class="border px-4 py-2 font-bold">アジェンダ名</td>
                    <td class="border px-4 py-2">{{ $agenda->agenda_name }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">カテゴリ</td>
                    <td class="border px-4 py-2">{{ $agenda->category?->name ?? '未設定' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">表示フラグ</td>
                    <td class="border px-4 py-2">{{ $agenda->is_show ? '表示' : '非表示' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">承認</td>
                    <td class="border px-4 py-2">{{ $agenda->status === 'yes' ? '承認済み' : '下書き' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">作成者</td>
                    <td class="border px-4 py-2">{{ $agenda->created_user_name ?? '不明' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">更新者</td>
                    <td class="border px-4 py-2">{{ $agenda->updated_user_name ?? 'なし' }}</td>
                </tr>
            </tbody>
        </table>

        {{-- プレビューボタン --}}
        <div class="flex gap-2 mt-6">
            <button type="button"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition preview-button"
                data-content='@json($agenda->content)'
                data-title="{{ $agenda->agenda_name }}">
                プレビュー
            </button>
            <a href="{{ route('admin.agendas.edit', $agenda->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                編集
            </a>
            <a href="{{ route('admin.agendas.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                一覧に戻る
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/previewWindow.js') }}"></script>
@endsection

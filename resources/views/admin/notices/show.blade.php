@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">お知らせ詳細</h1>

        <table class="table-auto w-full border-collapse">
            <tbody>
                <tr>
                    <td class="border px-4 py-2 font-bold">お知らせ詳細</td>
                    <td class="border px-4 py-2">{{ $Agenda->agenda_name }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">カテゴリ</td>
                    <td class="border px-4 py-2">{{ $Agenda->category?->name ?? '未設定' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">表示フラグ</td>
                    <td class="border px-4 py-2">{{ $Agenda->is_show ? '表示' : '非表示' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">承認</td>
                    <td class="border px-4 py-2">{{ $Agenda->accept === 'yes' ? '承認済み' : '下書き' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">作成者</td>
                    <td class="border px-4 py-2">{{ $Agenda->createdUser?->name ?? '不明' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-bold">更新者</td>
                    <td class="border px-4 py-2">{{ $Agenda->updatedUser?->name ?? 'なし' }}</td>
                </tr>

            </tbody>
        </table>

        {{-- 非表示のHTML（保存された内容） --}}
        <div id="agenda-description" class="hidden">
            {!! $Agenda->description_sanitized !!}
        </div>


        {{-- プレビューボタン --}}
        <button type="button" id="preview-button" class="bg-green-600 text-white px-3 py-1 rounded mt-2">
            プレビューを見る
        </button>

        <div class="flex gap-2 mt-6">
            <a href="{{ route('admin.notices.edit', $Agenda->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                編集
            </a>
            <a href="{{ route('admin.notices.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                一覧に戻る
            </a>
        </div>
    </div>
@endsection

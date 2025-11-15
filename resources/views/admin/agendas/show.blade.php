@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Agenda詳細</h1>

    <div class="border p-4 rounded mb-4 bg-white shadow">
        <p><strong>Agenda名:</strong> {{ $Agenda->agenda_name }}</p>
        <p><strong>カテゴリID:</strong> {{ $Agenda->category_id }}</p>
        <p><strong>表示フラグ:</strong> {{ $Agenda->is_show ? '表示' : '非表示' }}</p>
        <p><strong>承認:</strong> {{ $Agenda->accept }}</p>
        <p><strong>作成者ID:</strong> {{ $Agenda->user_id }}</p>
        <p><strong>作成者:</strong> {{ $Agenda->created_user_id }}</p>
        <p><strong>更新者:</strong> {{ $Agenda->updated_user_id }}</p>
        <p><strong>削除日時:</strong> {{ $Agenda->deleted_at }}</p>
        <p><strong>削除者:</strong> {{ $Agenda->deleted_user_id }}</p>
    </div>

    {{-- CKEditorで作成したHTMLを美しく表示 --}}
    <div class="prose max-w-none bg-gray-50 p-6 rounded border">
        {!! html_entity_decode($Agenda->description) !!}
    </div>


    <div class="flex gap-2 mt-6">
        <a href="{{ route('admin.agendas.edit', $Agenda->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            編集
        </a>
        <a href="{{ route('admin.agendas.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            一覧に戻る
        </a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Agenda詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>agenda_name:</strong> {{ $Agenda->agenda_name }}</p>
<p><strong>category_id:</strong> {{ $Agenda->category_id }}</p>
<p><strong>description:</strong> {{ $Agenda->description }}</p>
<p><strong>is_show:</strong> {{ $Agenda->is_show }}</p>
<p><strong>user_id:</strong> {{ $Agenda->user_id }}</p>
<p><strong>accept:</strong> {{ $Agenda->accept }}</p>
<p><strong>created_user_id:</strong> {{ $Agenda->created_user_id }}</p>
<p><strong>updated_user_id:</strong> {{ $Agenda->updated_user_id }}</p>
<p><strong>deleted_at:</strong> {{ $Agenda->deleted_at }}</p>
<p><strong>deleted_user_id:</strong> {{ $Agenda->deleted_user_id }}</p>

    </div>
    <a href="{{ route('agendas.edit', $Agenda->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('agendas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection
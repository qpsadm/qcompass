@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">資格詳細</h1>

            @php
                $levelLabels = [
                    1 => '初級',
                    2 => '上級',
                ];
            @endphp

            <div class="border p-4 rounded mb-4 space-y-2">
                <p><strong>資格名:</strong> {{ $typeLabels[$learning->type] ?? $learning->type }}</p>
                <p><strong>資格レベル:</strong> {{ $levelLabels[$learning->level] ?? $learning->level }}</p>
                <p><strong>説明・備考:</strong> {{ $learning->description }}</p>
                <p><strong>参照URL:</strong>
                    @if ($learning->url)
                        <a href="{{ $learning->url }}" target="_blank" class="text-blue-600 underline">{{ $learning->url }}</a>
                    @else
                        なし
                    @endif
                </p>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.learnings.edit', $learning->id) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
                    <a href="{{ route('admin.learnings.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
                </div>
            </div>
        </div>
    @endsection

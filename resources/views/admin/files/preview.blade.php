@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} ファイルプレビュー</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="mb-4">ファイル名: {{ $file->file_name }}</p>
            <p class="mb-4">ファイルサイズ: {{ number_format($file->file_size / 1024, 2) }} KB</p>

            @if (Str::startsWith($file->file_type, 'image/'))
                <img src="{{ asset('storage/' . $file->file_path) }}" alt="プレビュー" class="max-w-full h-auto rounded">
            @elseif(Str::endsWith($file->file_type, ['pdf']))
                <iframe src="{{ asset('storage/' . $file->file_path) }}" class="w-full h-[600px]" frameborder="0"></iframe>
            @else
                <p>このファイルはプレビューできません。</p>
                <a href="{{ asset('storage/' . $file->file_path) }}" class="text-blue-500 underline" download>ダウンロード</a>
            @endif

            <div class="mt-4">
                <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">戻る</a>
            </div>
        </div>
    </div>
@endsection

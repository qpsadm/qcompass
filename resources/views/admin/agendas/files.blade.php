@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-4xl mx-auto bg-white rounded shadow">

        <h2 class="text-xl font-bold mb-4">
            @if ($agenda)
                「{{ $agenda->agenda_name }}」の登録済みファイル
            @else
                すべての登録済みファイル
            @endif
        </h2>

        @if ($files->isEmpty())
            <p class="text-gray-500">登録済みファイルはありません。</p>
        @else
            <div class="grid grid-cols-3 gap-4">
                @foreach ($files as $file)
                    <div class="border p-2 rounded text-center">
                        <img src="{{ asset('storage/' . $file->path) }}" class="w-full h-32 object-cover mb-1">
                        <p class="text-xs">{{ $file->filename }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection

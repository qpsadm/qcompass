@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">添付ファイルカウント作成</h1>
        <form action="{{ route('files_count.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-1">カウント</label>
                <input type="text" name="count" value="{{ old('count', $FilesCount->count ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
        </form>
    </div>
@endsection

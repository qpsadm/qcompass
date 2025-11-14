@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Organizer編集</h1>

    <form action="{{ route('admin.organizers.update', $Organizer->id) }}" method="POST"
        class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf
        @method('PUT')

        <!-- 名前 -->
        <div>
            <label for="name" class="block text-gray-700 font-semibold mb-2">名前</label>
            <input type="text" name="name" id="name"
                value="{{ old('name', $Organizer->name ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- ボタン -->
        <div class="flex items-center gap-2 mt-4">
            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                更新
            </button>
            <a href="{{ route('admin.organizers.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection

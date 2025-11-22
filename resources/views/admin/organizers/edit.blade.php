@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 min-h-screen">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">開催者編集</h1>

        <form action="{{ route('admin.organizers.update', $Organizer->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- 開催者名 -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">開催者名</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $Organizer->name ?? '') }}"
                    class="w-full max-w-md border border-gray-300 rounded-md shadow-sm px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ボタン -->
            <div class="flex items-center gap-3 mt-6">
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
</div>
@endsection

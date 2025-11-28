@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">資格新規入力</h1>

            {{-- フォーム開始 --}}
            <form action="{{ route('admin.certifications.store') }}" method="POST">
                @csrf

                {{-- エラー表示 --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- 資格名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">資格名<span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="border px-2 py-1 w-full rounded" value="{{ old('name') }}">
                </div>

                {{-- 資格レベル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">資格レベル</label>
                    <select name="level" class="border px-2 py-1 w-full rounded">
                        <option value="">選択してください</option>
                        <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>初級</option>
                        <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>上級</option>
                    </select>
                </div>

                {{-- 説明・備考 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明・備考</label>
                    <input type="text" name="description" class="border px-2 py-1 w-full rounded"
                        value="{{ old('description') }}">
                </div>

                {{-- URL --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">参照URL</label>
                    <input type="text" name="url" class="border px-2 py-1 w-full rounded"
                        value="{{ old('url') }}">
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4" x-data="{ is_show: {{ old('is_show', $JobOffer->is_show ?? 0) }} }">
                    <span class="font-medium mr-2">表示フラグ</span>
                    <div class="flex gap-2">
                        <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                            <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                            公開
                        </label>

                        <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                            <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                            非公開
                        </label>
                    </div>
                </div>

                {{-- 送信 --}}
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        登録する
                    </button>


                    <a href="{{ route('admin.certifications.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

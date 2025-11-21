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
                    <input type="text" name="name" class="border px-2 py-1 w-full rounded"
                        value="{{ old('name') }}">
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
                    <input type="text" name="url" class="border px-2 py-1 w-full rounded" value="{{ old('url') }}">
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-6">
                    <label class="block font-medium mb-1">表示設定</label>
                    <input type="checkbox" name="display_flag" value="1" {{ old('display_flag', 1) ? 'checked' : '' }}>
                    <span>公開する</span>
                </div>

                {{-- 送信 --}}
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        登録する
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

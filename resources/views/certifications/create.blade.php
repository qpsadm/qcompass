@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">資格新規入力</h1>

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


            {{-- タイトル --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">資格名<span class="text-red-500">*</span></label>
                <input type="text" name="name" class="border px-2 py-1 w-full rounded" value="{{ old('name') }}">
            </div>

            {{-- 説明 --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">資格レベル</label>
                <select name="level" class="border px-2 py-1 w-full rounded">
                    @php
                        $levels = ['beginner' => '初級', 'advanced' => '上級'];
                    @endphp
                    <option value="">選択してください</option>
                    @foreach ($levels as $key => $label)
                        <option value="{{ $key }}"
                            {{ old('level', $learning->level ?? '') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- 説明・備考 --}}

            <div class="mb-4">
                <label class="block font-medium mb-1">説明・備考<span class="text-red-500">*</span></label>
                <input type="text" name="description" class="border px-2 py-1 w-full rounded"
                    value="{{ old('name') }}">
            </div>

            {{-- URL --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">参照URL</label>
                <input type="text" name="url" class="border px-2 py-1 w-full rounded" value="{{ old('url') }}">
            </div>

            {{-- 難易度 --}}



            {{-- 表示フラグ --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">表示設定</label>
                <input type="checkbox" name="is_show" value="1" {{ old('is_show') ? 'checked' : '' }}>
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

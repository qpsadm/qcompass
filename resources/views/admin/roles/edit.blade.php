@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">権限編集</h1>

    <form action="{{ route('admin.roles.update', $Role->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- 管理番号（0〜9） -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">権限ID（0〜9）</label>
            <select
                name="role_id"
                required
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                @for ($i = 0; $i <= 9; $i++)
                    @php
                    // 既に存在するIDを無効化
                    $disabled=$roles->where('role_id', $i)->first();
                    @endphp
                    <option
                        value="{{ $i }}"
                        {{ old('role_id') == $i ? 'selected' : '' }}
                        {{ $disabled ? 'disabled' : '' }}
                        class="{{ $disabled ? 'text-gray-400 bg-gray-100' : '' }}">
                        {{ $i }} {{ $disabled ? '(使用中)' : '' }}
                    </option>
                    @endfor
            </select>

            @error('role_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 役割名 -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">役割名</label>
            <input type="text" name="role_name"
                value="{{ old('role_name', $Role->role_name) }}"
                class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- ボタン -->
        <div class="flex items-center gap-2 mt-4">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                更新
            </button>
            <a href="{{ route('admin.roles.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                一覧に戻る
            </a>
        </div>
    </form>
</div>
@endsection

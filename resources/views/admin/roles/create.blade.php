@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">権限作成</h1>

            <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- 権限ID（0〜9） -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">権限ID（0〜9）</label>
                    <select name="role_id" required
                        class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        @for ($i = 0; $i <= 9; $i++)
                            @php
                                // 既に存在するIDを無効化
                                $disabled = $roles->where('role_id', $i)->first();
                            @endphp
                            <option value="{{ $i }}" {{ old('role_id') == $i ? 'selected' : '' }}
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

                <!-- 権限名 -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">権限名</label>
                    <input type="text" name="role_name" value="{{ old('role_name') }}" required
                        class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('role_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 作成日（表示のみ） -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">作成日</label>
                    <input type="text" value="{{ now()->format('Y-m-d H:i:s') }}" readonly
                        class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 bg-gray-100 cursor-not-allowed">
                </div>

                <!-- ボタン -->
                <div class="flex items-center gap-3 mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                        保存
                    </button>
                    <a href="{{ route('admin.roles.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow-sm transition">
                        一覧に戻る
                    </a>
                </div>
            </form>

            {{-- ✅ 共通削除モーダル（ちらつきなし） --}}
            <div x-show="open" x-cloak x-transition.opacity.duration.200ms
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div x-show="open" x-transition.scale.duration.200ms
                    class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                    <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                    <p class="text-gray-700 text-center mb-5">
                        「<span x-text="deleteName"></span>」を削除しますか？
                    </p>
                    <div class="flex justify-center space-x-4">
                        <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                            キャンセル
                        </button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                削除する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }

            /* 無効項目（disabled）に色を付ける */
            select option:disabled {
                color: #9ca3af;
                /* text-gray-400 */
                background-color: #f3f4f6;
                /* bg-gray-100 */
            }
        </style>
    @endsection

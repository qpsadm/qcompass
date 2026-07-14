@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen" x-data="{ deleteOpen: false }">

        <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">

            <!-- ヘッダー -->
            <div class="mb-6">
                {{-- <a href="{{ route('admin.organizers.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">
                ← 講座開催者一覧に戻る
            </a> --}}
                <h1 class="text-2xl font-bold text-gray-800">講座開催者 編集</h1>
            </div>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 編集フォーム -->
            <form action="{{ route('admin.organizers.update', $Organizer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-sm">
                    <tbody>
                        <!-- 開催者名 -->
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium align-middle">
                                開催者名
                                <span class="ml-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">
                                    必須
                                </span>
                            </th>
                            <td class="px-4 py-3">
                                <input type="text" name="name" value="{{ old('name', $Organizer->name ?? '') }}"
                                    class="border rounded px-3 py-2 w-64
                                          focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- 操作ボタン -->
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                        更新する
                    </button>
                    <a href="{{ route('admin.organizers.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>

            <!-- 危険操作ゾーン -->
            <div class="mt-10 pt-6 border-t border-red-200">
                <h2 class="text-red-600 font-semibold mb-2 flex items-center">
                    ⚠ 危険な操作
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    この開催者を削除すると、元に戻すことはできません。
                </p>

                <button @click="deleteOpen = true" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                    削除する
                </button>
            </div>
        </div>

        <!-- 削除確認モーダル -->
        <div x-show="deleteOpen" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

            <div x-show="deleteOpen" x-transition.scale class="bg-white rounded-2xl p-6 w-full max-w-sm">

                <h3 class="text-lg font-semibold text-center mb-3">
                    削除確認
                </h3>

                <p class="text-center text-gray-700 mb-5">
                    「<span class="font-semibold">{{ $Organizer->name }}</span>」を
                    削除しますか？
                </p>

                <div class="flex justify-center gap-4">
                    <button @click="deleteOpen = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        キャンセル
                    </button>

                    <form action="{{ route('admin.organizers.destroy', $Organizer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            削除する
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
@endsection

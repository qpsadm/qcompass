@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">詳細情報作成：{{ $user->name }}</h1>

        <form action="{{ route('admin.user_details.store', $user->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">生年月日</label>
                <input type="date" name="birthday" class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">性別</label>
                <select name="gender" class="border px-3 py-2 rounded w-full">
                    <option value="">選択</option>
                    <option value="1">男性</option>
                    <option value="2">女性</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">電話番号1</label>
                <input type="text" name="phone1" class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">電話番号2</label>
                <input type="text" name="phone2" class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">住所1</label>
                <input type="text" name="address1" class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">住所2</label>
                <input type="text" name="address2" class="border px-3 py-2 rounded w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">写真</label>
                <input type="file" name="avatar_path" class="border px-3 py-2 rounded w-full">
            </div>

            <div class="flex space-x-2 mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    作成
                </button>

                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    ユーザー一覧に戻る
                </a>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4" x-data="{ tab: 'basic' }">

        <h1 class="text-2xl font-bold mb-6">ユーザー編集</h1>

        <!-- タブボタン -->
        <div class="flex border-b mb-6">
            <button @click="tab = 'basic'" :class="tab === 'basic' ? 'border-b-2 border-blue-500 text-blue-500' : ''"
                class="px-4 py-2 font-semibold">基本情報</button>
            <button @click="tab = 'detail'" :class="tab === 'detail' ? 'border-b-2 border-blue-500 text-blue-500' : ''"
                class="px-4 py-2 font-semibold">詳細情報</button>
        </div>

        <!-- 基本情報タブ -->
        <div x-show="tab === 'basic'" class="mb-6">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                class="bg-white p-6 rounded-lg shadow-md space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-1">ユーザーコード</label>
                    <input type="text" name="code" value="{{ $user->code }}"
                        class="border px-3 py-2 rounded w-full">
                </div>

                <div>
                    <label class="block font-semibold mb-1">氏名</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="border px-3 py-2 rounded w-full">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Eメール</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                        class="border px-3 py-2 rounded w-full">
                </div>

                <div>
                    <label class="block font-semibold mb-1">権限 ID</label>
                    <input type="number" name="role_id" value="{{ $user->role_id }}"
                        class="border px-3 py-2 rounded w-full">
                </div>

                <div>
                    <label class="block font-semibold mb-1">講座 ID</label>
                    <input type="number" name="courses_id" value="{{ $user->courses_id }}"
                        class="border px-3 py-2 rounded w-full">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">基本情報更新</button>
            </form>
        </div>

        <!-- 詳細情報タブ -->
        <div x-show="tab === 'detail'">
            @if ($user->detail)
                <form action="{{ route('admin.user_details.update', $user->detail->id) }}" method="POST"
                    enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold mb-1">生年月日</label>
                        <input type="date" name="birthday" value="{{ $user->detail->birthday ?? '' }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">性別</label>
                        <select name="gender" class="border px-3 py-2 rounded w-full">
                            <option value="">選択</option>
                            <option value="male" {{ $user->detail->gender === 'male' ? 'selected' : '' }}>男性</option>
                            <option value="female" {{ $user->detail->gender === 'female' ? 'selected' : '' }}>女性</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">電話番号1</label>
                        <input type="text" name="phone1" value="{{ $user->detail->phone1 ?? '' }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">電話番号2</label>
                        <input type="text" name="phone2" value="{{ $user->detail->phone2 ?? '' }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">住所1</label>
                        <input type="text" name="address1" value="{{ $user->detail->address1 ?? '' }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">住所2</label>
                        <input type="text" name="address2" value="{{ $user->detail->address2 ?? '' }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">写真</label>
                        <input type="file" name="avatar_path" class="border px-3 py-2 rounded w-full">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">詳細情報更新</button>
                </form>
            @else
                <p>このユーザーには詳細情報が登録されていません。</p>
                <a href="{{ route('admin.user_details.create', $user->id) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded mt-2 inline-block">
                    詳細情報を作成
                </a>
            @endif
        </div>

    </div>
@endsection

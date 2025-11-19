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
            @php
                $d = $user->detail;
            @endphp

            @if ($d)
                <form action="{{ route('admin.user_details.update', ['user' => $user->id, 'detail' => $d->id]) }}"
                    method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md space-y-4">

                    @csrf
                    @method('PUT')

                    {{-- 生年月日 --}}
                    <div>
                        <label class="block font-semibold mb-1">生年月日</label>
                        <input type="date" name="birthday" value="{{ $d->birthday }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 性別 --}}
                    <div>
                        <label class="block font-semibold mb-1">性別</label>
                        <select name="gender" class="border px-3 py-2 rounded w-full">
                            <option value="">未選択</option>
                            <option value="1" @selected($d->gender == 1)>男性</option>
                            <option value="2" @selected($d->gender == 2)>女性</option>
                        </select>
                    </div>

                    {{-- 電話番号１ --}}
                    <div>
                        <label class="block font-semibold mb-1">電話番号1</label>
                        <input type="text" name="phone1" value="{{ $d->phone1 }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 電話番号２ --}}
                    <div>
                        <label class="block font-semibold mb-1">電話番号2</label>
                        <input type="text" name="phone2" value="{{ $d->phone2 }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 郵便番号 --}}
                    <div>
                        <label class="block font-semibold mb-1">郵便番号</label>
                        <input type="text" name="postal_code" value="{{ $d->postal_code }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 住所１ --}}
                    <div>
                        <label class="block font-semibold mb-1">住所1</label>
                        <input type="text" name="address1" value="{{ $d->address1 }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 住所２ --}}
                    <div>
                        <label class="block font-semibold mb-1">住所2</label>
                        <input type="text" name="address2" value="{{ $d->address2 }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 緊急連絡先 --}}
                    <div>
                        <label class="block font-semibold mb-1">緊急連絡先</label>
                        <input type="text" name="emergency_contact" value="{{ $d->emergency_contact }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- テーマカラー --}}
                    <div>
                        <label class="block font-semibold mb-1">テーマカラー</label>
                        <input type="text" name="theme_color" value="{{ $d->theme_color }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 自己紹介 --}}
                    <div>
                        <label class="block font-semibold mb-1">自己紹介</label>
                        <textarea name="bio" class="border px-3 py-2 rounded w-full" rows="4">{{ $d->bio }}</textarea>
                    </div>

                    {{-- メモ --}}
                    <div>
                        <label class="block font-semibold mb-1">メモ</label>
                        <textarea name="memo1" class="border px-3 py-2 rounded w-full" rows="4">{{ $d->memo1 }}</textarea>
                    </div>

                    {{-- 備考 --}}
                    <div>
                        <label class="block font-semibold mb-1">備考</label>
                        <textarea name="memo2" class="border px-3 py-2 rounded w-full" rows="4">{{ $d->memo2 }}</textarea>
                    </div>

                    {{-- 入社日 --}}
                    <div>
                        <label class="block font-semibold mb-1">入社日/入所日</label>
                        <input type="date" name="joining_date" value="{{ $d->joining_date }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 退所日 --}}
                    <div>
                        <label class="block font-semibold mb-1">退所日/退職日</label>
                        <input type="date" name="leaving_date" value="{{ $d->leaving_date }}"
                            class="border px-3 py-2 rounded w-full">
                    </div>

                    {{-- 退校理由 --}}
                    <div>
                        <label class="block font-semibold mb-1">退校理由</label>
                        <textarea name="leaving_reason" class="border px-3 py-2 rounded w-full" rows="4">{{ $d->leaving_reason }}</textarea>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">詳細情報更新</button>
                </form>
            @else
                {{-- 新規作成 --}}
                <form action="{{ route('admin.user_details.store', ['user' => $user->id]) }}" method="POST"
                    enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md space-y-4">
                    @csrf

                    {{-- コンポーネント使わない版：空欄フォーム --}}
                    <div>
                        <label class="block font-semibold mb-1">生年月日</label>
                        <input type="date" name="birthday" class="border px-3 py-2 rounded w-full">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">性別</label>
                        <select name="gender" class="border px-3 py-2 rounded w-full">
                            <option value="">未選択</option>
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
                        <label class="block font-semibold mb-1">郵便番号</label>
                        <input type="text" name="postal_code" class="border px-3 py-2 rounded w-full">
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
                        <label class="block font-semibold mb-1">緊急連絡先</label>
                        <input type="text" name="emergency_contact" class="border px-3 py-2 rounded w-full">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">テーマカラー</label>
                        <input type="text" name="theme_color" class="border px-3 py-2 rounded w-full">
                    </div>

                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2">詳細情報作成</button>
                </form>
            @endif
        </div>
    </div>
@endsection

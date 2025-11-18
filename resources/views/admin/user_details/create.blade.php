@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細作成</h1>

        <div class="bg-white border border-gray-200 rounded p-6 shadow-sm">
            <form action="{{ route('admin.user_details.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1">ユーザーID</label>
                        <input type="text" name="user_id" value="{{ old('user_id') }}"
                            class="border px-2 py-1 w-full rounded">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">生年月日</label>
                        <input type="date" name="birthday" value="{{ old('birthday') }}"
                            class="border px-2 py-1 w-full rounded">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">性別</label>
                        <select name="gender" class="border px-2 py-1 w-full rounded">
                            <option value="">選択してください</option>
                            <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>男性</option>
                            <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>女性</option>
                            <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>その他</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">電話番号1</label>
                        <input type="text" name="phone1" value="{{ old('phone1') }}"
                            class="border px-2 py-1 w-full rounded">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">電話番号2</label>
                        <input type="text" name="phone2" value="{{ old('phone2') }}"
                            class="border px-2 py-1 w-full rounded">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">郵便番号</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                            class="border px-2 py-1 w-full rounded">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">住所1</label>
                        <input type="text" name="address1" value="{{ old('address1') }}"
                            class="border px-2 py-1 w-full rounded">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">住所2</label>
                        <input type="text" name="address2" value="{{ old('address2') }}"
                            class="border px-2 py-1 w-full rounded">
                    </div>

                    <!-- 必要に応じて残りの項目も同様に追加 -->
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">保存</button>
                    <a href="{{ route('admin.user_details.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded ml-2 hover:bg-gray-600">一覧に戻る</a>
                </div>
            </form>
        </div>
    </div>
@endsection

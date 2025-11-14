@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4" x-data="{ tab: 'basic' }">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細</h1>

        <!-- タブボタン -->
        <div class="flex border-b mb-4">
            <button class="px-4 py-2 font-semibold" :class="{ 'border-b-2 border-blue-500': tab === 'basic' }"
                @click="tab = 'basic'">基本情報</button>
            <button class="px-4 py-2 font-semibold" :class="{ 'border-b-2 border-blue-500': tab === 'detail' }"
                @click="tab = 'detail'">詳細情報</button>
        </div>

        <!-- 基本情報タブ -->
        <div x-show="tab === 'basic'" class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded mb-4">
                <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">ユーザーコード</th>
                        <td class="px-4 py-2">{{ $user->code }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">名前</th>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">フリガナ</th>
                        <td class="px-4 py-2">{{ $user->furigana ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">ローマ字</th>
                        <td class="px-4 py-2">{{ $user->roman_name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">メール</th>
                        <td class="px-4 py-2">{{ $user->email ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">権限</th>
                        <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">講座</th>
                        <td class="px-4 py-2">{{ $user->courses->pluck('name')->join(', ') ?: '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">作成者ID</th>
                        <td class="px-4 py-2">{{ $user->created_user_id ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">作成日時</th>
                        <td class="px-4 py-2">{{ $user->created_at }}</td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- 詳細情報タブ -->
        <div x-show="tab === 'detail'" x-cloak class="mt-4">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded">
                    <tbody>
                        <tr class="border-b">
                            <th class="text-left px-4 py-2 bg-gray-100">Department</th>
                            <td class="px-4 py-2">{{ $user->detail->department ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left px-4 py-2 bg-gray-100">Phone1</th>
                            <td class="px-4 py-2">{{ $user->detail->phone1 ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left px-4 py-2 bg-gray-100">Phone2</th>
                            <td class="px-4 py-2">{{ $user->detail->phone2 ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="text-left px-4 py-2 bg-gray-100">Address1</th>
                            <td class="px-4 py-2">{{ $user->detail->address1 ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-left px-4 py-2 bg-gray-100">Address2</th>
                            <td class="px-4 py-2">{{ $user->detail->address2 ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ボタン -->
        <div class="mt-6 pb-24">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    </div>
@endsection

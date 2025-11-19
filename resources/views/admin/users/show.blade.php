@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4" x-data="{ tab: '{{ request('tab', 'basic') }}' }">

        <h1 class="text-2xl font-bold mb-4">ユーザー詳細</h1>

        <!-- タブボタン -->
        <div class="flex border-b mb-4">
            <button class="px-4 py-2 font-semibold"
                :class="{ 'border-b-2 border-blue-500 text-blue-500': tab === 'basic' }"
                @click="tab = 'basic'">基本情報</button>

            <button class="px-4 py-2 font-semibold"
                :class="{ 'border-b-2 border-blue-500 text-blue-500': tab === 'detail' }"
                @click="tab = 'detail'">詳細情報</button>
        </div>

        <!-- メッセージ -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- 基本情報タブ -->
        <div x-show="tab === 'basic'">
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
                </tbody>
            </table>
            <a href="{{ route('admin.users.edit', $user->id) . '?tab=basic' }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        </div>

        <!-- 詳細情報タブ -->
        <div x-show="tab === 'detail'" x-cloak>
            <table class="min-w-full bg-white border border-gray-200 rounded">
                <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">部署</th>
                        <td class="px-4 py-2">{{ $user->detail->department ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">電話番号1</th>
                        <td class="px-4 py-2">{{ $user->detail->phone1 ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">電話番号2</th>
                        <td class="px-4 py-2">{{ $user->detail->phone2 ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100">住所1</th>
                        <td class="px-4 py-2">{{ $user->detail->address1 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100">住所2</th>
                        <td class="px-4 py-2">{{ $user->detail->address2 ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ route('admin.users.edit', $user->id) . '?tab=detail' }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        </div>

    </div>
@endsection

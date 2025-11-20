@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細</h1>

        <!-- 基本情報 -->
        <div class="bg-white border border-gray-200 rounded mb-6 p-4">
            <h2 class="text-xl font-semibold mb-2">基本情報</h2>
            <table class="min-w-full border-collapse">
                <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">ユーザーID</th>
                        <td class="px-4 py-2">{{ $user->id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">ユーザーコード</th>
                        <td class="px-4 py-2">{{ $user->code }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">名前</th>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">フリガナ</th>
                        <td class="px-4 py-2">{{ $user->furigana ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">ローマ字</th>
                        <td class="px-4 py-2">{{ $user->roman_name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">メール</th>
                        <td class="px-4 py-2">{{ $user->email ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">権限</th>
                        <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">講座</th>
                        <td class="px-4 py-2">{{ $user->courses->pluck('name')->join(', ') ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100 text-left">作成日時</th>
                        <td class="px-4 py-2">{{ $user->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 詳細情報 -->
        <div class="bg-white border border-gray-200 rounded mb-6 p-4">
            <h2 class="text-xl font-semibold mb-2">詳細情報</h2>
            @if ($user->detail)
                <table class="min-w-full border-collapse">
                    <tbody>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">生年月日</th>
                            <td class="px-4 py-2">{{ $user->detail->birthday ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">性別</th>
                            <td class="px-4 py-2">
                                @if ($user->detail->gender == 0)
                                    男性
                                @elseif ($user->detail->gender == 1)
                                    女性
                                @else
                                    その他
                                @endif
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">電話番号1</th>
                            <td class="px-4 py-2">{{ $user->detail->phone1 ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">電話番号2</th>
                            <td class="px-4 py-2">{{ $user->detail->phone2 ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">住所1</th>
                            <td class="px-4 py-2">{{ $user->detail->address1 ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">住所2</th>
                            <td class="px-4 py-2">{{ $user->detail->address2 ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">自己紹介</th>
                            <td class="px-4 py-2">{{ $user->detail->bio ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-left">テーマカラー</th>
                            <td class="px-4 py-2">{{ $user->detail->theme_color ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2 bg-gray-100 text-left">ステータス</th>
                            <td class="px-4 py-2">
                                @if ($user->detail->status == 0)
                                    非アクティブ
                                @elseif($user->detail->status == 1)
                                    アクティブ
                                @else
                                    停止
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">詳細情報は登録されていません。</p>
            @endif
        </div>

        <!-- ボタン -->
        <div class="flex gap-2 mb-8">
            <!-- 編集ボタン -->
            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                編集
            </a>

            <!-- 一覧に戻るボタン -->
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                一覧に戻る
            </a>
        </div>
    </div>
@endsection

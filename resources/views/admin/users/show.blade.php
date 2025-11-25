@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl" x-data="{ tab: '{{ request('tab', 'basic') }}' }">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">ユーザー詳細</h1>

        <!-- タブボタン -->
        <div class="flex border-b mb-6">
            <button class="px-6 py-2 font-semibold focus:outline-none"
                :class="{ 'border-b-2 border-blue-500 text-blue-500': tab === 'basic' }" @click="tab = 'basic'">
                基本情報
            </button>
            <button class="px-6 py-2 font-semibold focus:outline-none"
                :class="{ 'border-b-2 border-blue-500 text-blue-500': tab === 'detail' }" @click="tab = 'detail'">
                詳細情報
            </button>
        </div>

        <!-- メッセージ -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            <!-- 基本情報タブ -->
            <div x-show="tab === 'basic'" x-cloak class="bg-white shadow rounded-lg p-6">
                <table class="w-full table-auto">
                    <tbody>
                        @foreach ([
            'ユーザーID' => $user->id,
            'ユーザーコード' => $user->code,
            '名前' => $user->name,
            'フリガナ' => $user->furigana,
            'ローマ字' => $user->roman_name,
            'メール' => $user->email,
            '権限' => $user->role->role_name ?? '-',
            '講座' => $user->courses && $user->courses->count() > 0 ? $user->courses->pluck('course_name')->join(', ') : '未所属',
            '部署' => $user->division->name ?? '-',
            '作成者' => $user->created_user_name,
            '更新者' => $user->updated_user_name,

            '作成日' => $user->created_at,
            '更新日' => $user->updated_at,
        ] as $label => $value)
                            <tr class="border-b">
                                <th class="px-4 py-2 bg-gray-100 w-1/4 text-right font-medium">{{ $label }}</th>
                                <td class="px-4 py-2 break-words">{{ $value ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 詳細情報タブ -->
            <div x-show="tab === 'detail'" x-cloak class="bg-white shadow rounded-lg p-6">
                @if ($user->detail)
                    @php
                        $details = [
                            '電話番号1' => $user->detail->phone1 ?? '-',
                            '電話番号2' => $user->detail->phone2 ?? '-',
                            '郵便番号' => $user->detail->postal_code ?? '-',
                            '住所1' => $user->detail->address1 ?? '-',
                            '住所2' => $user->detail->address2 ?? '-',
                            '緊急連絡先' => $user->detail->emergency_contact ?? '-',
                            '性別' => isset($user->detail->gender)
                                ? ($user->detail->gender == 1
                                    ? '男性'
                                    : ($user->detail->gender == 2
                                        ? '女性'
                                        : '不明'))
                                : '-',
                            '生年月日' => $user->detail->birthday?->format('Y-m-d') ?? '-',
                            '写真' => $user->detail->avatar_path
                                ? '<img src="' .
                                    asset('storage/' . $user->detail->avatar_path) .
                                    '" class="w-24 h-24 object-cover rounded-full">'
                                : '未登録',
                            'テーマカラー' => $user->detail->theme_id ?? '-',
                            'ステータス' => isset($user->detail->status)
                                ? ($user->detail->status == 1
                                    ? 'アクティブ'
                                    : ($user->detail->status == 0
                                        ? '非アクティブ'
                                        : '停止'))
                                : '-',
                            '自己紹介' => $user->detail->bio ?? '-',
                            '備考' => $user->detail->memo ?? '-',
                            '入校日/入社日' => $user->detail->joining_date ?? '-',
                            '退校日/退社日' => $user->detail->leaving_date ?? '-',
                            '退校/退社理由' => $user->detail->leaving_reason ?? '-',
                            '作成者' => $user->detail->created_user_name ?? '-',
                            '更新者' => $user->detail->updated_user_name ?? '-',
                            '作成日' => $user->detail->created_at ?? '-',
                            '更新日' => $user->detail->updated_at ?? '-',
                        ];
                    @endphp

                    <table class="w-full table-auto">
                        <tbody>
                            @foreach ($details as $label => $value)
                                <tr class="border-b">
                                    <th class="px-4 py-2 bg-gray-100 w-1/4 text-right font-medium">{{ $label }}</th>
                                    <td class="px-4 py-2 break-words">{!! $value !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-gray-500 italic">詳細情報は未登録です。</div>
                @endif
            </div>



        </div>

        <!-- 編集ボタン -->
        <div class="flex gap-3 mt-6">
            <!-- 基本情報編集 -->
            <a href="{{ route('admin.users.edit', ['user' => $user->id, 'tab' => 'basic']) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded shadow transition">
                基本情報編集
            </a>

            <!-- 詳細情報編集 / 作成 -->
            @if ($user->detail)
                <a href="{{ route('admin.user_details.edit', ['user' => $user->id, 'detail' => $user->detail->id]) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded shadow transition">
                    詳細情報編集
                </a>
            @else
                <a href="{{ route('admin.user_details.create', $user->id) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded shadow transition">
                    詳細情報作成
                </a>
            @endif
            <!-- 一覧に戻るボタン -->
            <a href="{{ route('admin.users.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded shadow transition">
                一覧に戻る
            </a>
        </div>

    </div>
@endsection

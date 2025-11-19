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

        <div class="overflow-x-auto">
            <!-- 基本情報タブ -->
            <table x-show="tab === 'basic'" class="table-auto w-full bg-white border border-gray-200 rounded mb-4" x-cloak>
                <tbody>
                    @foreach ([
            'ユーザーID' => $user->id,
            'ユーザーコード' => $user->code,
            '名前' => $user->name,
            'フリガナ' => $user->furigana,
            'ローマ字' => $user->roman_name,
            'メール' => $user->email,
            '権限' => $user->role->name ?? '-',
            '講座' => $user->courses->pluck('name')->join(', ') ?: '-',
            '作成者' => $user->created_user_id,
            '更新者' => $user->updated_user_id,
            '削除者' => $user->deleted_user_id,
            '削除日' => $user->deleted_at,
            '作成日' => $user->created_at,
            '更新日' => $user->updated_at,
        ] as $label => $value)
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 w-1/4 text-left">{{ $label }}</th>
                            <td class="px-4 py-2 break-words text-left">{{ $value ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- 詳細情報タブ -->
            <table x-show="tab === 'detail'" class="table-auto w-full bg-white border border-gray-200 rounded" x-cloak>
                <tbody>
                    @foreach ([
            '部署' => $user->detail->department ?? '-',
            '電話番号1' => $user->detail->phone1 ?? '-',
            '電話番号2' => $user->detail->phone2 ?? '-',
            '郵便番号' => $user->detail->postal_code ?? '-',
            '住所1' => $user->detail->address1 ?? '-',
            '住所2' => $user->detail->address2 ?? '-',
            '緊急連絡先' => $user->detail->emergency_contact ?? '-',
            '写真パス' => $user->detail->avatar_path ?? '-',
            'テーマカラー' => $user->detail->theme_color ?? '-',
            'ステータス' => match ($user->detail->status ?? null) {
                0 => '非アクティブ',
                1 => 'アクティブ',
                default => '停止',
            },
            '表示/非表示' => $user->detail->is_show ?? '-',
            '所属部署ID' => $user->detail->divisions_id ?? '-',
            '自己紹介' => $user->detail->bio ?? '-',
            'メモ1' => $user->detail->memo1 ?? '-',
            'メモ2' => $user->detail->memo2 ?? '-',
            '入校日/入社日' => $user->detail->joining_date ?? '-',
            '退校日/退社日' => $user->detail->leaving_date ?? '-',
            '退校/退社理由' => $user->detail->leaving_reason ?? '-',
            '作成者' => $user->detail->created_user_id ?? '-',
            '更新者' => $user->detail->updated_user_id ?? '-',
            '削除者' => $user->detail->deleted_user_id ?? '-',
            '削除日' => $user->detail->deleted_at ?? '-',
            '作成日' => $user->detail->created_at ?? '-',
            '更新日' => $user->detail->updated_at ?? '-',
        ] as $label => $value)
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 w-1/4 text-left">{{ $label }}</th>
                            <td class="px-4 py-2 break-words text-left">{{ $value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 編集ボタン -->
        <div class="flex gap-2 mt-4">
            <a :href="'{{ route('admin.users.edit', $user->id) }}?tab=basic'"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">基本情報編集</a>
            <a :href="'{{ route('admin.users.edit', $user->id) }}?tab=detail'"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">詳細情報編集</a>
        </div>

    </div>
@endsection

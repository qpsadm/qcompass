@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細</h1>

        <div class="overflow-x-auto bg-white border border-gray-200 rounded mb-4">
            <table class="min-w-full border-collapse">
                <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">ユーザーID</th>
                        <td class="px-4 py-2">{{ $UserDetail->user_id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">生年月日</th>
                        <td class="px-4 py-2">{{ $UserDetail->birthday }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">性別</th>
                        <td class="px-4 py-2">
                            @if ($UserDetail->gender == 0)
                                男性
                            @elseif($UserDetail->gender == 1)
                                女性
                            @else
                                その他
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">電話番号1</th>
                        <td class="px-4 py-2">{{ $UserDetail->phone1 }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">電話番号2</th>
                        <td class="px-4 py-2">{{ $UserDetail->phone2 }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">郵便番号</th>
                        <td class="px-4 py-2">{{ $UserDetail->postal_code }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">住所1</th>
                        <td class="px-4 py-2">{{ $UserDetail->address1 }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">住所2</th>
                        <td class="px-4 py-2">{{ $UserDetail->address2 }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">緊急連絡先</th>
                        <td class="px-4 py-2">{{ $UserDetail->emergency_contact }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">写真パス</th>
                        <td class="px-4 py-2">{{ $UserDetail->avatar_path }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">テーマカラー</th>
                        <td class="px-4 py-2">{{ $UserDetail->theme_color }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">ステータス</th>
                        <td class="px-4 py-2">
                            @if ($UserDetail->status == 0)
                                非アクティブ
                            @elseif($UserDetail->status == 1)
                                アクティブ
                            @else
                                停止
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">表示/非表示</th>
                        <td class="px-4 py-2">{{ $UserDetail->is_show }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">所属部署</th>
                        <td class="px-4 py-2">{{ $UserDetail->divisions_id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">自己紹介</th>
                        <td class="px-4 py-2">{{ $UserDetail->bio }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">メモ</th>
                        <td class="px-4 py-2">{{ $UserDetail->memo1 }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">備考</th>
                        <td class="px-4 py-2">{{ $UserDetail->memo2 }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">入校日/入社日</th>
                        <td class="px-4 py-2">{{ $UserDetail->joining_date }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">退校日/退社日</th>
                        <td class="px-4 py-2">{{ $UserDetail->leaving_date }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">退校/退社理由</th>
                        <td class="px-4 py-2">{{ $UserDetail->leaving_reason }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">作成者</th>
                        <td class="px-4 py-2">{{ $UserDetail->created_user_id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">更新者</th>
                        <td class="px-4 py-2">{{ $UserDetail->updated_user_id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-left">削除日</th>
                        <td class="px-4 py-2">{{ $UserDetail->deleted_at }}</td>
                    </tr>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100 text-left">削除者</th>
                        <td class="px-4 py-2">{{ $UserDetail->deleted_user_id }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex gap-2 mb-8">
            <a href="{{ route('admin.user_details.edit', $UserDetail->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">編集</a>
            <a href="{{ route('admin.user_details.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">一覧に戻る</a>
        </div>
    </div>
@endsection

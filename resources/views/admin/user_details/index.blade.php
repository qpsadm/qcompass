@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細一覧</h1>
        <a href="{{ route('admin.user_details.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">新規作成</a>

        <div class="overflow-x-auto bg-white border border-gray-200 rounded">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2 bg-gray-100 border">ユーザーID</th>
                        <th class="px-4 py-2 bg-gray-100 border">生年月日</th>
                        <th class="px-4 py-2 bg-gray-100 border">性別</th>
                        <th class="px-4 py-2 bg-gray-100 border">電話番号1</th>
                        <th class="px-4 py-2 bg-gray-100 border">電話番号2</th>
                        <th class="px-4 py-2 bg-gray-100 border">郵便番号</th>
                        <th class="px-4 py-2 bg-gray-100 border">住所1</th>
                        <th class="px-4 py-2 bg-gray-100 border">住所2</th>
                        <th class="px-4 py-2 bg-gray-100 border">緊急連絡先</th>
                        <th class="px-4 py-2 bg-gray-100 border">写真パス</th>
                        <th class="px-4 py-2 bg-gray-100 border">テーマカラー</th>
                        <th class="px-4 py-2 bg-gray-100 border">ステータス</th>
                        <th class="px-4 py-2 bg-gray-100 border">表示/非表示</th>
                        <th class="px-4 py-2 bg-gray-100 border">所属部署</th>
                        <th class="px-4 py-2 bg-gray-100 border">自己紹介</th>
                        <th class="px-4 py-2 bg-gray-100 border">メモ</th>
                        <th class="px-4 py-2 bg-gray-100 border">備考</th>
                        <th class="px-4 py-2 bg-gray-100 border">入校日/入社日</th>
                        <th class="px-4 py-2 bg-gray-100 border">退校日/退職日</th>
                        <th class="px-4 py-2 bg-gray-100 border">退校/退職理由</th>
                        <th class="px-4 py-2 bg-gray-100 border">作成者</th>
                        <th class="px-4 py-2 bg-gray-100 border">更新者</th>
                        <th class="px-4 py-2 bg-gray-100 border">削除日</th>
                        <th class="px-4 py-2 bg-gray-100 border">削除者</th>
                        <th class="px-4 py-2 bg-gray-100 border">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_details as $UserDetail)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $UserDetail->user_id }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->birthday }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->gender }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->phone1 }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->phone2 }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->postal_code }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->address1 }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->address2 }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->emergency_contact }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->avatar_path }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->theme_color }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->status }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->is_show }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->divisions_id }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->bio }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->memo1 }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->memo2 }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->joining_date }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->leaving_date }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->leaving_reason }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->created_user_id }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->updated_user_id }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->deleted_at }}</td>
                            <td class="border px-4 py-2">{{ $UserDetail->deleted_user_id }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.user_details.show', $UserDetail->id) }}"
                                    class="text-green-600 hover:underline">詳細</a>
                                <a href="{{ route('admin.user_details.edit', $UserDetail->id) }}"
                                    class="text-blue-600 hover:underline ml-2">編集</a>
                                <form action="{{ route('admin.user_details.destroy', $UserDetail->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

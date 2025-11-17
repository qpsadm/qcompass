@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細一覧</h1>
        <a href="{{ route('admin.user_details.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>ユーザーID</th>
                    <th class='border px-4 py-2'>生年月日</th>
                    <th class='border px-4 py-2'>性別</th>
                    <th class='border px-4 py-2'>電話番号1</th>
                    <th class='border px-4 py-2'>電話番号2</th>
                    <th class='border px-4 py-2'>郵便番号</th>
                    <th class='border px-4 py-2'>住所1</th>
                    <th class='border px-4 py-2'>住所2</th>
                    <th class='border px-4
                    py-2'>緊急連絡先</th>
                    <th class='border px-4 py-2'>写真パス</th>
                    <th class='border px-4 py-2'>テーマカラー</th>
                    <th class='border px-4 py-2'>ステータス</th>
                    <th class='border px-4 py-2'>表示/非表示</th>
                    <th class='border px-4 py-2'>所属部署</th>
                    <th class='border px-4 py-2'>自己紹介</th>
                    <th class='border px-4 py-2'>メモ</th>
                    <th class='border px-4 py-2'>備考</th>
                    <th class='border px-4 py-2'>入校日/入社日</th>
                    <th class='border px-4 py-2'>退校日/退職日</th>
                    <th class='border px-4 py-2'>退校/退職理由</th>
                    <th class='border px-4 py-2'>作成者</th>
                    <th class='border px-4 py-2'>更新者</th>
                    <th class='border px-4 py-2'>削除日</th>
                    <th class='border px-4 py-2'>削除者</th>

                    <th class='border px-4 py-2'>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user_details as $UserDetail)
                    <tr>
                        <td class='border px-4 py-2'>{{ $UserDetail->user_id }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->birthday }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->gender }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->phone1 }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->phone2 }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->postal_code }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->address1 }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->address2 }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->emergency_contact }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->avatar_path }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->theme_color }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->status }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->is_show }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->divisions_id }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->bio }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->memo1 }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->memo2 }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->joining_date }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->leaving_date }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->leaving_reason }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->created_user_id }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->updated_user_id }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->deleted_at }}</td>
                        <td class='border px-4 py-2'>{{ $UserDetail->deleted_user_id }}</td>

                        <td class='border px-4 py-2'>
                            <a href="{{ route('admin.user_details.show', $UserDetail->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('admin.user_details.edit', $UserDetail->id) }}"
                                class="text-blue-600 ml-2">編集</a>
                            <form action="{{ route('admin.user_details.destroy', $UserDetail->id) }}" method="POST"
                                class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

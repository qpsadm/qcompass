@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>ユーザーID:</strong> {{ $UserDetail->user_id }}</p>
            <p><strong>生年月日:</strong> {{ $UserDetail->birthday }}</p>
            <p><strong>性別:</strong>
                @if ($UserDetail->gender == 0)
                    男性
                @elseif($UserDetail->gender == 1)
                    女性
                @else
                    その他
                @endif
            </p>
            <p><strong>phone1:</strong> {{ $UserDetail->phone1 }}</p>
            <p><strong>phone2:</strong> {{ $UserDetail->phone2 }}</p>
            <p><strong>postal_code:</strong> {{ $UserDetail->postal_code }}</p>
            <p><strong>address1:</strong> {{ $UserDetail->address1 }}</p>
            <p><strong>address2:</strong> {{ $UserDetail->address2 }}</p>
            <p><strong>emergency_contact:</strong> {{ $UserDetail->emergency_contact }}</p>
            <p><strong>avatar_path:</strong> {{ $UserDetail->avatar_path }}</p>
            <p><strong>theme_color:</strong> {{ $UserDetail->theme_color }}</p>
            <p><strong>status:</strong>
                @if ($UserDetail->status == 0)
                    非アクティブ
                @elseif($UserDetail->status == 1)
                    アクティブ
                @else
                    停止
                @endif
            </p>
            <p><strong>表示/非表示:</strong> {{ $UserDetail->is_show }}</p>
            <p><strong>所属部署:</strong> {{ $UserDetail->divisions_id }}</p>
            <p><strong>自己紹介:</strong> {{ $UserDetail->bio }}</p>
            <p><strong>メモ:</strong> {{ $UserDetail->memo1 }}</p>
            <p><strong>備考:</strong> {{ $UserDetail->memo2 }}</p>
            <p><strong>入校日/入社日:</strong> {{ $UserDetail->joining_date }}</p>
            <p><strong>退校日/退社日:</strong> {{ $UserDetail->leaving_date }}</p>
            <p><strong>退校/退社理由:</strong> {{ $UserDetail->leaving_reason }}</p>
            <p><strong>作成者:</strong> {{ $UserDetail->created_user_id }}</p>
            <p><strong>更新者s:</strong> {{ $UserDetail->updated_user_id }}</p>
            <p><strong>削除日:</strong> {{ $UserDetail->deleted_at }}</p>
            <p><strong>削除者:</strong> {{ $UserDetail->deleted_user_id }}</p>

        </div>
        <a href="{{ route('admin.user_details.edit', $UserDetail->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.user_details.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection

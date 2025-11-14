@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">UserDetail詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>user_id:</strong> {{ $UserDetail->user_id }}</p>
            <p><strong>birthday:</strong> {{ $UserDetail->birthday }}</p>
            <p><strong>gender:</strong> {{ $UserDetail->gender }}</p>
            <p><strong>phone1:</strong> {{ $UserDetail->phone1 }}</p>
            <p><strong>phone2:</strong> {{ $UserDetail->phone2 }}</p>
            <p><strong>postal_code:</strong> {{ $UserDetail->postal_code }}</p>
            <p><strong>address1:</strong> {{ $UserDetail->address1 }}</p>
            <p><strong>address2:</strong> {{ $UserDetail->address2 }}</p>
            <p><strong>emergency_contact:</strong> {{ $UserDetail->emergency_contact }}</p>
            <p><strong>avatar_path:</strong> {{ $UserDetail->avatar_path }}</p>
            <p><strong>theme_color:</strong> {{ $UserDetail->theme_color }}</p>
            <p><strong>status:</strong> {{ $UserDetail->status }}</p>
            <p><strong>is_show:</strong> {{ $UserDetail->is_show }}</p>
            <p><strong>divisions_id:</strong> {{ $UserDetail->divisions_id }}</p>
            <p><strong>bio:</strong> {{ $UserDetail->bio }}</p>
            <p><strong>memo1:</strong> {{ $UserDetail->memo1 }}</p>
            <p><strong>memo2:</strong> {{ $UserDetail->memo2 }}</p>
            <p><strong>joining_date:</strong> {{ $UserDetail->joining_date }}</p>
            <p><strong>leaving_date:</strong> {{ $UserDetail->leaving_date }}</p>
            <p><strong>leaving_reason:</strong> {{ $UserDetail->leaving_reason }}</p>
            <p><strong>created_user_id:</strong> {{ $UserDetail->created_user_id }}</p>
            <p><strong>updated_user_id:</strong> {{ $UserDetail->updated_user_id }}</p>
            <p><strong>deleted_at:</strong> {{ $UserDetail->deleted_at }}</p>
            <p><strong>deleted_user_id:</strong> {{ $UserDetail->deleted_user_id }}</p>

        </div>
        <a href="{{ route('admin.user_details.edit', $UserDetail->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.user_details.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection

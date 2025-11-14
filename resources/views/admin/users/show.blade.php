@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">User詳細</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded">
            <tbody>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Code</th>
                    <td class="px-4 py-2">{{ $user->code }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Name</th>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Furigana</th>
                    <td class="px-4 py-2">{{ $user->furigana }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Roman Name</th>
                    <td class="px-4 py-2">{{ $user->roman_name }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Password</th>
                    <td class="px-4 py-2">{{ $user->password }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Role ID</th>
                    <td class="px-4 py-2">{{ $user->role_id }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Courses ID</th>
                    <td class="px-4 py-2">{{ $user->courses_id }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Email</th>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Email Verified At</th>
                    <td class="px-4 py-2">{{ $user->email_verified_at }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Created User ID</th>
                    <td class="px-4 py-2">{{ $user->created_user_id }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Updated User ID</th>
                    <td class="px-4 py-2">{{ $user->updated_user_id }}</td>
                </tr>
                <tr class="border-b">
                    <th class="text-left px-4 py-2 bg-gray-100">Deleted At</th>
                    <td class="px-4 py-2">{{ $user->deleted_at }}</td>
                </tr>
                <tr>
                    <th class="text-left px-4 py-2 bg-gray-100">Deleted User ID</th>
                    <td class="px-4 py-2">{{ $user->deleted_user_id }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ボタン -->
    <div class="mt-6 pb-24">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
</div>

@endsection

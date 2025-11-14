@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">User編集</h1>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded">
                <tbody>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100 w-1/4">Code</th>
                        <td class="px-4 py-2">
                            <input type="text" name="code" value="{{ old('code', $user->code ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Name</th>
                        <td class="px-4 py-2">
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Furigana</th>
                        <td class="px-4 py-2">
                            <input type="text" name="furigana" value="{{ old('furigana', $user->furigana ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Roman Name</th>
                        <td class="px-4 py-2">
                            <input type="text" name="roman_name" value="{{ old('roman_name', $user->roman_name ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Password</th>
                        <td class="px-4 py-2">
                            <input type="text" name="password" value="{{ old('password', $user->password ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Role ID</th>
                        <td class="px-4 py-2">
                            <input type="text" name="role_id" value="{{ old('role_id', $user->role_id ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Courses ID</th>
                        <td class="px-4 py-2">
                            <input type="text" name="courses_id" value="{{ old('courses_id', $user->courses_id ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Email</th>
                        <td class="px-4 py-2">
                            <input type="text" name="email" value="{{ old('email', $user->email ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Email Verified At</th>
                        <td class="px-4 py-2">
                            <input type="text" name="email_verified_at" value="{{ old('email_verified_at', $user->email_verified_at ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Created User ID</th>
                        <td class="px-4 py-2">
                            <input type="text" name="created_user_id" value="{{ old('created_user_id', $user->created_user_id ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Updated User ID</th>
                        <td class="px-4 py-2">
                            <input type="text" name="updated_user_id" value="{{ old('updated_user_id', $user->updated_user_id ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="text-left px-4 py-2 bg-gray-100">Deleted At</th>
                        <td class="px-4 py-2">
                            <input type="text" name="deleted_at" value="{{ old('deleted_at', $user->deleted_at ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left px-4 py-2 bg-gray-100">Deleted User ID</th>
                        <td class="px-4 py-2">
                            <input type="text" name="deleted_user_id" value="{{ old('deleted_user_id', $user->deleted_user_id ?? '') }}"
                                class="border px-2 py-1 w-full rounded">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <!-- ボタン -->
            <div class="mt-6 pb-24">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
            </div>
    </form>
</div>
@endsection

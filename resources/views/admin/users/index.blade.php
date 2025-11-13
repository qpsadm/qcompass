@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ユーザー一覧</h1>
        <a href="{{ route('admin.users.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="検索..."
                class="border px-2 py-1 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">検索</button>
        </form>
        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>code</th>
                    <th class='border px-4 py-2'>name</th>
                    <th class='border px-4 py-2'>furigana</th>
                    <th class='border px-4 py-2'>roman_name</th>
                    <th class='border px-4 py-2'>password</th>
                    <th class='border px-4 py-2'>role_id</th>
                    <th class='border px-4 py-2'>courses_id</th>
                    <th class='border px-4 py-2'>remember_token</th>
                    <th class='border px-4 py-2'>email</th>
                    <th class='border px-4 py-2'>email_verified_at</th>
                    <th class='border px-4 py-2'>created_user_id</th>
                    <th class='border px-4 py-2'>updated_user_id</th>
                    <th class='border px-4 py-2'>deleted_at</th>
                    <th class='border px-4 py-2'>deleted_user_id</th>

                    <th class='border px-4 py-2'>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $User)
                    <tr>
                        <td class='border px-4 py-2'>{{ $User->code }}</td>
                        <td class='border px-4 py-2'>{{ $User->name }}</td>
                        <td class='border px-4 py-2'>{{ $User->furigana }}</td>
                        <td class='border px-4 py-2'>{{ $User->roman_name }}</td>
                        <td class='border px-4 py-2'>{{ $User->password }}</td>
                        <td class='border px-4 py-2'>{{ $User->role_id }}</td>
                        <td class='border px-4 py-2'>{{ $User->courses_id }}</td>
                        <td class='border px-4 py-2'>{{ $User->remember_token }}</td>
                        <td class='border px-4 py-2'>{{ $User->email }}</td>
                        <td class='border px-4 py-2'>{{ $User->email_verified_at }}</td>
                        <td class='border px-4 py-2'>{{ $User->created_user_id }}</td>
                        <td class='border px-4 py-2'>{{ $User->updated_user_id }}</td>
                        <td class='border px-4 py-2'>{{ $User->deleted_at }}</td>
                        <td class='border px-4 py-2'>{{ $User->deleted_user_id }}</td>

                        <td class='border px-4 py-2'>
                            <a href="{{ route('admin.users.show', $User->id) }}" class="text-green-600">詳細</a>
                            <a href="{{ route('admin.users.edit', $User->id) }}" class="text-blue-600 ml-2">編集</a>
                            <form action="{{ route('admin.users.destroy', $User->id) }}" method="POST"
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

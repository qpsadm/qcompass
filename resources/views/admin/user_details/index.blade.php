@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">UserDetail一覧</h1>
        <a href="{{ route('admin.user_details.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>user_id</th>
                    <th class='border px-4 py-2'>birthday</th>
                    <th class='border px-4 py-2'>gender</th>
                    <th class='border px-4 py-2'>phone1</th>
                    <th class='border px-4 py-2'>phone2</th>
                    <th class='border px-4 py-2'>postal_code</th>
                    <th class='border px-4 py-2'>address1</th>
                    <th class='border px-4 py-2'>address2</th>
                    <th class='border px-4 py-2'>emergency_contact</th>
                    <th class='border px-4 py-2'>avatar_path</th>
                    <th class='border px-4 py-2'>theme_color</th>
                    <th class='border px-4 py-2'>status</th>
                    <th class='border px-4 py-2'>is_show</th>
                    <th class='border px-4 py-2'>divisions_id</th>
                    <th class='border px-4 py-2'>bio</th>
                    <th class='border px-4 py-2'>memo1</th>
                    <th class='border px-4 py-2'>memo2</th>
                    <th class='border px-4 py-2'>joining_date</th>
                    <th class='border px-4 py-2'>leaving_date</th>
                    <th class='border px-4 py-2'>leaving_reason</th>
                    <th class='border px-4 py-2'>created_user_id</th>
                    <th class='border px-4 py-2'>updated_user_id</th>
                    <th class='border px-4 py-2'>deleted_at</th>
                    <th class='border px-4 py-2'>deleted_user_id</th>

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

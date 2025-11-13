@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Course一覧</h1>
    <a href="{{ route('admin.courses.create') }}" class="bg-blue-500 px-4 py-2 rounded mb-4 inline-block">新規作成</a>
    <form method="GET" action="{{ route('admin.courses.index') }}" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="講座コード・講座名で検索"
            class="border px-2 py-1 rounded">
        <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">検索</button>
    </form>
    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>

                <th class='border px-4 py-2'>講座コード</th>
                <th class='border px-4 py-2'>講座分野</th>
                <th class='border px-4 py-2'>講座種類</th>
                <th class='border px-4 py-2'>実施主体（主催者名）</th>
                <th class='border px-4 py-2'>講座名</th>
                <th class='border px-4 py-2'>認定番号</th>
                <th class='border px-4 py-2'>状態</th>
                <th class='border px-4 py-2'>作成日時</th>
                <th class='border px-4 py-2'>更新日時</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $Course)
            <tr>
                <td class='border px-4 py-2'>{{ $Course->course_code }}</td> <!-- 講座コード -->
                <td class='border px-4 py-2'>{{ $Course->course_type_ID }}</td> <!-- 講座分野 -->
                <td class='border px-4 py-2'>{{ $Course->Level_id }}</td> <!-- 講座種類 -->
                <td class='border px-4 py-2'>{{ $Course->organizer_id }}</td> <!-- 実施主体（主催者名） -->
                <td class='border px-4 py-2'>{{ $Course->course_name }}</td> <!-- 講座名 -->
                <td class='border px-4 py-2'>{{ $Course->certification_number }}</td> <!-- 認定番号 -->
                <td class='border px-4 py-2'>{{ $Course->status }}</td> <!-- 状態 -->
                <td class='border px-4 py-2'>{{ $Course->created_at }}</td> <!-- 作成日時 -->

                <td class='border px-4 py-2'>{{ $Course->updated_at }}</td> <!-- 更新日時 -->




                <td class='border px-4 py-2'>
                    <a href="{{ route('admin.courses.show', $Course->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('admin.courses.edit', $Course->id) }}" class="text-blue-600 ml-2">編集</a>
                    <div x-data="{ open: false }" class="inline-block ml-2">
                        <button @click="open = true" class="text-red-600">削除</button>

                        <!-- モーダル -->
                        <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded shadow">
                                <p class="mb-4">本当に削除しますか？</p>
                                <div class="flex justify-end space-x-2">
                                    <button @click="open = false" class="px-4 py-2 bg-gray-300 rounded">キャンセル</button>
                                    <form action="{{ route('admin.courses.destroy', $Course->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 rounded">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

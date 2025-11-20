@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">質問一覧</h1>
            <a href="{{ route('admin.questions.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr>
                        <th class='border px-4 py-2'>質問者ID</th>
                        <th class='border px-4 py-2'>関連アジェンダID</th>
                        <th class='border px-4 py-2'>講座ID</th>
                        <th class='border px-4 py-2'>質問タイトル</th>
                        <th class='border px-4 py-2'>回答講師ID</th>
                        <th class='border px-4 py-2'>質問内容</th>
                        <th class='border px-4 py-2'>回答内容</th>
                        <th class='border px-4 py-2'>公開/非公開</th>
                        <th class='border px-4 py-2'>削除日</th>

                        <th class='border px-4 py-2'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $Question)
                        <tr>
                            <td class='border px-4 py-2'>{{ $Question->asker_id }}</td>
                            <td class='border px-4 py-2'>{{ $Question->agenda_id }}</td>
                            <td class='border px-4 py-2'>{{ $Question->course_id }}</td>
                            <td class='border px-4 py-2'>{{ $Question->title }}</td>
                            <td class='border px-4 py-2'>{{ $Question->responder_id }}</td>
                            <td class='border px-4 py-2'>{{ $Question->content }}</td>
                            <td class='border px-4 py-2'>{{ $Question->answer }}</td>
                            <td class='border px-4 py-2'>{{ $Question->is_show }}</td>
                            <td class='border px-4 py-2'>{{ $Question->deleted_at }}</td>

                            <td class='border px-4 py-2'>
                                <a href="{{ route('admin.questions.show', $Question->id) }}" class="text-green-600">詳細</a>
                                <a href="{{ route('admin.questions.edit', $Question->id) }}"
                                    class="text-blue-600 ml-2">編集</a>


                                <div x-show="openModal === {{ $Question->id }}"
                                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                                    <div class="bg-white rounded-lg p-6 w-96">
                                        <h2 class="text-lg font-bold mb-4">確認</h2>
                                        <p class="mb-6">本当に削除しますか？</p>
                                        <div class="flex justify-end gap-2">
                                            <button @click="openModal = null"
                                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">キャンセル</button>
                                            <form action="{{ route('admin.questions.destroy', $Question->id) }}"
                                                method="POST" class="inline-block ml-2">
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

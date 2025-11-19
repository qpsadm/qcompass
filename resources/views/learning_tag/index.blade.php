@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツタグ一覧</h1>
            <a href="{{ route('learning_tag.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr>
                        <th class='border px-4 py-2'>学習コンテンツID</th>
                        <th class='border px-4 py-2'>タグID</th>
                        <th class='border px-4 py-2'>削除日</th>

                        <th class='border px-4 py-2'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($learning_tag as $LearningTag)
                        <tr>
                            <td class='border px-4 py-2'>{{ $LearningTag->learning_id }}</td>
                            <td class='border px-4 py-2'>{{ $LearningTag->tag_id }}</td>
                            <td class='border px-4 py-2'>{{ $LearningTag->deleted_at }}</td>

                            <td class='border px-4 py-2'>
                                <a href="{{ route('learning_tag.show', $LearningTag->id) }}" class="text-green-600">詳細</a>
                                <a href="{{ route('learning_tag.edit', $LearningTag->id) }}"
                                    class="text-blue-600 ml-2">編集</a>
                                <form action="{{ route('learning_tag.destroy', $LearningTag->id) }}" method="POST"
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

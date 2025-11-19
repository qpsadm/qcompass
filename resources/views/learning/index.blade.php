@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ一覧</h1>
            <a href="{{ route('learning.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr>
                        <th class='border px-4 py-2'>種別</th>
                        <th class='border px-4 py-2'>名前</th>
                        <th class='border px-4 py-2'>著者名</th>
                        <th class='border px-4 py-2'>出版社</th>
                        <th class='border px-4 py-2'>出版日</th>
                        <th class='border px-4 py-2'>ISBNコード</th>
                        <th class='border px-4 py-2'>URL</th>
                        <th class='border px-4 py-2'>画像</th>
                        <th class='border px-4 py-2'>難易度</th>
                        <th class='border px-4 py-2'>説明・備考</th>
                        <th class='border px-4 py-2'>削除日</th>

                        <th class='border px-4 py-2'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($learning as $Learning)
                        <tr>
                            <td class='border px-4 py-2'>{{ $Learning->type }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->name }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->author }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->publisher }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->publication_date }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->isbn }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->url }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->image }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->level }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->description }}</td>
                            <td class='border px-4 py-2'>{{ $Learning->deleted_at }}</td>

                            <td class='border px-4 py-2'>
                                <a href="{{ route('learning.show', $Learning->id) }}" class="text-green-600">詳細</a>
                                <a href="{{ route('learning.edit', $Learning->id) }}" class="text-blue-600 ml-2">編集</a>
                                <form action="{{ route('learning.destroy', $Learning->id) }}" method="POST"
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

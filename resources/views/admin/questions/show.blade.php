@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">質問詳細</h1>

        <table class="table-auto w-full border-collapse">
            <tbody>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right">講座</th>
                    <td class="px-4 py-2">{{ $Question->course->course_name ?? '未設定' }} ({{ $Question->course->course_code ?? '' }})</td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right">質問タイトル</th>
                    <td class="px-4 py-2">{{ $Question->title }}</td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right">回答講師</th>
                    <td class="px-4 py-2">{{ $Question->responder->name ?? '未設定' }}</td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right">質問内容</th>
                    <td class="px-4 py-2">{{ $Question->content }}</td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right">回答内容</th>
                    <td class="px-4 py-2">{{ $Question->answer }}</td>
                </tr>

                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right">公開 / 非公開</th>
                    <td class="px-4 py-2">{{ $Question->is_show ? '公開' : '非公開' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex gap-2">
            <a href="{{ route('admin.questions.edit', $Question->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.questions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
        </div>
    </div>
</div>
@endsection

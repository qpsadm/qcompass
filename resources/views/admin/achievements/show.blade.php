@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">実績詳細</h1>

        <table class="w-full table-auto border-collapse border mb-4">
            <tbody>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium w-1/4">実績名</th>
                    <td class="px-4 py-2">{{ $Achievement->title }}</td>
                </tr>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">条件説明</th>
                    <td class="px-4 py-2">{{ $Achievement->description }}</td>
                </tr>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">達成条件タイプ</th>
                    <td class="px-4 py-2">{{ $Achievement->condition_type }}</td>
                </tr>
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">条件値</th>
                    <td class="px-4 py-2">{{ $Achievement->condition_value }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex gap-3">
            <a href="{{ route('admin.achievements.edit', $Achievement->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.achievements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">一覧に戻る</a>
        </div>
    </div>
</div>
@endsection

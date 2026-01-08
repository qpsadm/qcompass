@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $course->course_name }} のクイズ回答結果</h1>

    @if ($results->isEmpty())
    <p class="text-gray-600">まだ回答がありません。</p>
    @else
    <table class="min-w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">ユーザー名</th>
                <th class="border px-3 py-2">回答数</th>
                <th class="border px-3 py-2">合計スコア</th>
                <th class="border px-3 py-2">正答率</th>
                <th class="border px-3 py-2">最終回答日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $item)
            <tr>
                <td class="border px-3 py-2">{{ $item['user']->name }}</td>
                <td class="border px-3 py-2">{{ $item['count'] }}</td>
                <td class="border px-3 py-2">{{ $item['total_score'] }}</td>
                <td class="border px-3 py-2">{{ $item['accuracy'] }}%</td>
                <td class="border px-3 py-2">{{ $item['last_answer'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection

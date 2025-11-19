@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">クイズ集計作成</h1>
            <form action="{{ route('quiz_statistics.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium mb-1">クイズID</label>
                    <input type="text" name="quiz_id" value="{{ old('quiz_id', $QuizStatistic->quiz_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">平均点</label>
                    <input type="text" name="average_score"
                        value="{{ old('average_score', $QuizStatistic->average_score ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">最高点</label>
                    <input type="text" name="highest_score"
                        value="{{ old('highest_score', $QuizStatistic->highest_score ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">受験者数</label>
                    <input type="text" name="attempts_count"
                        value="{{ old('attempts_count', $QuizStatistic->attempts_count ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
            </form>
        </div>
    @endsection

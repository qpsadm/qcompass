@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">受験履歴編集</h1>
        <form action="{{ route('quiz_attempts.update', $QuizAttempt->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">受験者ID</label>
                <input type="text" name="user_id" value="{{ old('user_id', $QuizAttempt->user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">クイズID</label>
                <input type="text" name="quiz_id" value="{{ old('quiz_id', $QuizAttempt->quiz_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">開始時刻</label>
                <input type="text" name="started_at" value="{{ old('started_at', $QuizAttempt->started_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">終了時刻</label>
                <input type="text" name="completed_at"
                    value="{{ old('completed_at', $QuizAttempt->completed_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">得点</label>
                <input type="text" name="score" value="{{ old('score', $QuizAttempt->score ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">状態</label>
                <input type="text" name="status" value="{{ old('status', $QuizAttempt->status ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">受験回数</label>
                <input type="text" name="attempt_no" value="{{ old('attempt_no', $QuizAttempt->attempt_no ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">受験環境記録※任意※</label>
                <input type="text" name="ip_address" value="{{ old('ip_address', $QuizAttempt->ip_address ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection

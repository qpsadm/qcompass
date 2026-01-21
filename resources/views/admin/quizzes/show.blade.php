@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">クイズ詳細：{{ $quiz->title }}</h1>

    {{-- クイズ編集ボタン --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            クイズを編集
        </a>
    </div>

    {{-- クイズ情報 --}}
    <div class="bg-white p-4 rounded shadow mb-6">
        <p><strong>コード：</strong> {{ $quiz->code }}</p>
        <p><strong>カテゴリ：</strong> {{ $quiz->category?->name ?? '未設定' }}</p>
        <p><strong>レベル：</strong> {{ $quiz->level ?? '未設定' }}</p>
        <p><strong>満点（自動計算）：</strong> {{ $quiz->total_score }} 点</p>
        <p><strong>合格点：</strong>
            {{ $quiz->total_score ? ceil($quiz->total_score * 0.7) : 0 }} 点
            <span class="text-gray-500 text-sm">(満点の70%)</span>
        </p>
    </div>


    {{-- 新しい問題追加 --}}
    <div class="mb-4">
        <a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}"
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
            新しい問題を追加
        </a>
    </div>

    {{-- 問題一覧 --}}
    <h2 class="text-xl font-bold mb-3">問題一覧</h2>
    <div class="space-y-3">
        @foreach ($quiz->questions->sortBy('order') as $q)
        <div x-data="{ open: false }" class="border rounded shadow bg-white">

            {{-- アコーディオンヘッダー --}}
            <div class="p-3 bg-gray-100 flex justify-between cursor-pointer"
                @click="open = !open">
                <div>
                    <span class="font-bold">Q{{ sprintf('%02d', $loop->iteration) }}.</span>
                    {{ Str::limit($q->question_text, 40) }}
                </div>
                <div>
                    <span class="text-sm text-gray-600 mr-4">配点: {{ $q->score }}点</span>
                    <span x-text="open ? '▲' : '▼'" class="text-gray-600"></span>
                </div>
            </div>

            {{-- アコーディオン中身 --}}
            <div x-show="open" class="p-4 border-t">

                <p class="mb-2">
                    <strong>問題文：</strong><br>
                    {{ $q->question_text }}
                </p>

                <p class="mb-2">
                    <strong>表示：</strong>
                    {{ $q->is_show ? '✔ 表示' : '✖ 非表示' }}
                </p>

                {{-- 選択肢一覧 --}}
                @if ($q->choices->count())
                <h3 class="font-bold mt-4 mb-2">選択肢</h3>
                <ul class="list-disc ml-6">
                    @foreach ($q->choices->sortBy('order') as $c)
                    <li>
                        {{ $c->choice_text }}
                        @if ($c->is_correct)
                        <span class="text-green-600 font-bold ml-2">（正解）</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @endif

                {{-- 編集・削除ボタン --}}
                <div class="mt-4 flex gap-2 justify-end">
                    <a href="{{ route('admin.quizzes.quiz_questions.edit', [$quiz->id, $q->id]) }}"
                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        編集
                    </a>

                    <button @click="document.getElementById('delete-{{ $q->id }}').classList.remove('hidden')"
                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                        削除
                    </button>
                </div>

                {{-- 削除モーダル --}}
                <div id="delete-{{ $q->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 w-80">
                        <h2 class="text-lg font-bold mb-4">削除確認</h2>
                        <p class="mb-4">本当にこの問題を削除しますか？</p>
                        <div class="flex justify-end gap-2">
                            <button @click="document.getElementById('delete-{{ $q->id }}').classList.add('hidden')"
                                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                                キャンセル
                            </button>
                            <form action="{{ route('admin.quizzes.quiz_questions.destroy', [$quiz->id, $q->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                                    削除
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- クイズ一覧に戻る --}}
    <a href="{{ route('admin.quizzes.index') }}" class="text-blue-500 mt-6 inline-block">
        ← クイズ一覧へ戻る
    </a>
</div>
@endsection

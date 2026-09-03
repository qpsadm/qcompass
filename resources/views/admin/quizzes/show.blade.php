@php
    // クイズの種別
    $types = [
        '1' => '試験',
        '2' => '理解度チェック',
        '3' => '練習',
    ];
    // 難易度
    $levels = [
        '1' => '初級',
        '2' => '中級',
        '3' => '上級',
    ];
@endphp

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-5xl bg-white rounded-lg shadow-md">
        <div class="bg-white rounded-lg shadow-md p-6">

            <h1 class="text-2xl font-bold mb-4">クイズ詳細：{{ $quiz->title }}</h1>

            {{-- クイズ情報 --}}
            <div class="border bg-white p-4 rounded mb-6 space-y-3">
                {{-- <p><span class="inline-block w-32 text-right px-4">コード：</span> {{ $quiz->code }}</p> --}}
                <p><span class="inline-block w-32 text-right font-bold px-4">種類：</span> {{ $types[$quiz->type] ?? '未設定' }}
                </p>
                <p><span class="inline-block w-32 text-right font-bold px-4">カテゴリ：</span>
                    {{ $quiz->category?->name ?? '未設定' }}
                </p>
                <p><span class="inline-block w-32 text-right font-bold px-4">レベル：</span> {{ $levels[$quiz->level] ?? '未設定' }}
                </p>
                <p><span class="inline-block w-32 text-right font-bold px-4">満点：</span> {{ $quiz->total_score }} 点 <span
                        class="text-blue-600 text-sm">(自動計算)</span></p>
                <p><span class="inline-block w-32 text-right font-bold px-4">合格点：</span>
                    {{ $quiz->total_score ? ceil($quiz->total_score * 0.7) : 0 }} 点
                    <span class="text-blue-600 text-sm">(満点の70%)</span>
                </p>
            </div>

            {{-- クイズ編集ボタン --}}
            <div class="flex justify-start mb-8 gap-2">
                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
                    class="save bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    クイズを編集
                </a>

                {{-- クイズ一覧に戻る --}}
                <a href="{{ route('admin.quizzes.index') }}"
                    class="back bg-gray-500 text-white px-4 py-2 rounded
                hover:bg-gray-600">
                    クイズ一覧に戻る
                </a>
            </div>

            {{-- 問題一覧 --}}
            <div>
                <h2 class="text-xl font-bold mb-6">問題一覧 ( {{ $quiz->questions_count }}問 )</h2>
                {{-- 新しい問題追加 --}}
                <div class="mb-6">
                    <a href="{{ route('admin.quizzes.quiz_questions.create', $quiz->id) }}"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-yellow-500">
                        クイズ問題追加
                    </a>
                </div>
                <div class="space-y-3">
                    @foreach ($quiz->questions->sortBy('order') as $q)
                        <div x-data="{ open: false }" class="border rounded shadow bg-white">

                            {{-- アコーディオンヘッダー --}}
                            <div class="p-3 bg-gray-100 flex justify-between cursor-pointer" @click="open = !open">
                                <div>
                                    <span class="font-bold">Q{{ sprintf('%02d', $loop->iteration) }}.&nbsp;</span>
                                    {{ Str::limit($q->question_text, 40) }}
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 mr-4"><strong>配点:</strong>
                                        {{ $q->score }}点</span>
                                    <span x-text="open ? '▲' : '▼'" class="text-gray-600"></span>
                                </div>
                            </div>

                            {{-- アコーディオン中身 --}}
                            <div x-show="open" class="p-4 border-t">

                                <div class="flex flex-wrap gap-2 mb-2">
                                    <div class="w-32 text-right font-bold">問題文：</div>
                                    <div class="whitespace-pre-line">{{ $q->question_text }}
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2 mb-2">
                                    <div class="w-32 text-right font-bold">表示：</div>
                                    <div class="whitespace-pre-line">{{ $q->is_show ? '✔ 表示' : '✖ 非表示' }}</div>
                                </div>

                                {{-- 選択肢一覧 --}}
                                @if ($q->choices->count())
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <div class="w-32 text-right font-bold">選択肢：</div>
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
                                    </div>
                                @endif

                                {{-- 編集・削除ボタン --}}
                                <div class="mt-4 flex gap-2 justify-end">
                                    <a href="{{ route('admin.quizzes.quiz_questions.edit', [$quiz->id, $q->id]) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        編集
                                    </a>

                                    <button
                                        @click="document.getElementById('delete-{{ $q->id }}').classList.remove('hidden')"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        削除
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            {{-- モーダルはBladeの最後にまとめて置く --}}
            @foreach ($quiz->questions->sortBy('order') as $q)
                <div id="delete-{{ $q->id }}"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 w-80">
                        <h2 class="text-lg font-bold mb-4">削除確認</h2>
                        <p class="mb-4">本当にこの問題を削除しますか？</p>
                        <div class="flex justify-end gap-2">
                            <button onclick="document.getElementById('delete-{{ $q->id }}').classList.add('hidden')"
                                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                                キャンセル
                            </button>
                            <form action="{{ route('admin.quizzes.quiz_questions.destroy', [$quiz->id, $q->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                                    削除
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endsection
    </div>
</div>

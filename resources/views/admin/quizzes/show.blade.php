@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">クイズ詳細：{{ $quiz->title }}</h1>

    <div class="bg-white p-4 rounded shadow mb-6">
        <p><strong>コード：</strong> {{ $quiz->code }}</p>
        <p><strong>概要：</strong> {{ $quiz->description }}</p>
        <p><strong>満点（自動計算）：</strong> {{ $quiz->total_score }} 点</p>
        <p><strong>合格点：</strong> {{ $quiz->passing_score }} 点</p>
    </div>

    <h2 class="text-xl font-bold mb-3">問題一覧</h2>

    <div class="space-y-3">
        @foreach ($quiz->questions->sortBy('order') as $q)
        <div x-data="{ open: false }" class="border rounded shadow bg-white">

            {{-- アコーディオンヘッダー --}}
            <div class="p-3 bg-gray-100 flex justify-between cursor-pointer"
                @click="open = !open">
                <div>
                    <span class="font-bold">Q{{ $q->order }}.</span>
                    {{ Str::limit($q->question, 40) }}
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
                    {{ $q->question }}
                </p>

                <p class="mb-2">
                    <strong>回答（模範解答）：</strong><br>
                    {{ $q->answer }}
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
                        {{ $c->text }}

                        @if ($c->is_correct)
                        <span class="text-green-600 font-bold ml-2">（正解）</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @endif

                <div class="mt-4 flex justify-end">
                    <a href="{{ route('admin.questions.edit', $q->id) }}"
                        class="px-3 py-1 bg-blue-600 text-white rounded">
                        この問題を編集
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <a href="{{ route('admin.quizzes.index') }}" class="text-blue-500 mt-6 inline-block">
        ← クイズ一覧へ戻る
    </a>

</div>

@endsection

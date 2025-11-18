@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">{{ $question->id ? '問題編集' : '問題作成' }}</h1>

    <form action="{{ $question->id ? route('admin.questions.update', $question->id) : route('admin.questions.store') }}" method="POST">
        @csrf
        @if($question->id)
        @method('PUT')
        @endif

        {{-- 問題文 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">問題文</label>
            <input type="text" name="question_text" value="{{ old('question_text', $question->question_text ?? '') }}" class="border px-2 py-1 w-full rounded" required>
        </div>

        {{-- 問題タイプ --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">タイプ</label>
            <select name="question_type" class="border px-2 py-1 w-full rounded" required>
                <option value="single" {{ (old('question_type', $question->question_type ?? '') == 'single') ? 'selected' : '' }}>単一選択</option>
                <option value="multiple" {{ (old('question_type', $question->question_type ?? '') == 'multiple') ? 'selected' : '' }}>複数選択</option>
                <option value="text" {{ (old('question_type', $question->question_type ?? '') == 'text') ? 'selected' : '' }}>記述式</option>
            </select>
        </div>

        {{-- スコア --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">スコア</label>
            <input type="number" name="score" value="{{ old('score', $question->score ?? 0) }}" class="border px-2 py-1 w-full rounded">
        </div>

        {{-- 選択肢 --}}
        <div class="mb-4">
            <h2 class="font-medium mb-2">選択肢</h2>
            <div id="choices-wrapper">
                @if(old('choices', $question->choices ?? []))
                @foreach(old('choices', $question->choices ?? []) as $i => $choice)
                <div class="flex gap-2 mb-2">
                    <input type="text" name="choices[{{ $i }}][choice_text]" value="{{ $choice['choice_text'] ?? $choice->choice_text }}" class="border px-2 py-1 w-full rounded" required>
                    <label class="flex items-center gap-1">
                        <input type="checkbox" name="choices[{{ $i }}][is_correct]" value="1" {{ (!empty($choice['is_correct'] ?? $choice->is_correct)) ? 'checked' : '' }}> 正解
                    </label>
                </div>
                @endforeach
                @endif
            </div>
            <button type="button" id="add-choice" class="bg-gray-200 px-2 py-1 rounded mt-1">選択肢追加</button>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>

<script>
    let choiceIndex = document.querySelectorAll('#choices-wrapper > div').length;

    document.getElementById('add-choice').addEventListener('click', function() {
        const wrapper = document.getElementById('choices-wrapper');
        const html = `
        <div class="flex gap-2 mb-2">
            <input type="text" name="choices[${choiceIndex}][choice_text]" class="border px-2 py-1 w-full rounded" required>
            <label class="flex items-center gap-1">
                <input type="checkbox" name="choices[${choiceIndex}][is_correct]" value="1"> 正解
            </label>
        </div>
    `;
        wrapper.insertAdjacentHTML('beforeend', html);
        choiceIndex++;
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">問題追加: {{ $quiz->title }}</h1>

    <form action="{{ route('admin.quizzes.quiz_questions.store', $quiz->id) }}" method="POST">
        @csrf

        {{-- 問題文 --}}
        <div class="mb-4">
            <label class="font-bold">問題文</label>
            <input type="text" name="question_text" placeholder="問題文" required
                class="border p-2 w-full">
        </div>

        {{-- 配点 --}}
        <div class="mb-4">
            <label class="font-bold">配点</label>
            <input type="number" name="score" placeholder="0" value="0" class="border p-2 w-full">
        </div>

        {{-- 問題タイプ --}}
        <div class="mb-4">
            <label class="font-bold">問題タイプ</label>
            <select name="type" id="questionType" class="border p-2 w-full">
                <option value="single_2">2択</option>
                <option value="single_4">4択</option>
                <option value="multi">複数選択</option>
                <option value="text">記述式</option>
            </select>
        </div>

        {{-- 選択肢ブロック --}}
        <div id="choiceBlock" class="mb-4">
            <label class="font-bold">選択肢</label>
            <div id="choiceInputs" class="mb-2"></div>
            <button type="button" id="addChoice" class="bg-gray-300 px-2 py-1 rounded">選択肢を追加</button>
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">追加</button>
    </form>
</div>

<script>
    const typeSelect = document.getElementById('questionType');
    const choiceBlock = document.getElementById('choiceBlock');
    const choiceInputs = document.getElementById('choiceInputs');
    const addChoiceBtn = document.getElementById('addChoice');

    renderChoices();

    typeSelect.addEventListener('change', renderChoices);
    addChoiceBtn.addEventListener('click', addChoiceInput);

    function renderChoices() {
        const type = typeSelect.value;
        choiceInputs.innerHTML = '';

        if (type === 'text') {
            choiceBlock.style.display = 'none';
            return;
        }

        choiceBlock.style.display = 'block';

        let choiceCount = 0;
        if (type === 'single_2') choiceCount = 2;
        else if (type === 'single_4') choiceCount = 4;
        else if (type === 'multi') choiceCount = 2;

        for (let i = 0; i < choiceCount; i++) addChoiceInput();
    }

    function addChoiceInput() {
        const index = choiceInputs.children.length;
        const div = document.createElement('div');
        div.classList.add('mb-2');

        div.innerHTML = `
            <input type="text" name="choices[${index}][choice_text]" class="border p-1" placeholder="選択肢 ${index+1}" required>
            <label>正解 <input type="checkbox" name="choices[${index}][is_correct]" value="1"></label>
            <button type="button" class="removeChoice bg-red-400 text-white px-1 py-0.5 rounded ml-2">削除</button>
        `;
        choiceInputs.appendChild(div);

        div.querySelector('.removeChoice').addEventListener('click', () => {
            div.remove();
            refreshChoiceIndexes();
        });
    }

    function refreshChoiceIndexes() {
        Array.from(choiceInputs.children).forEach((div, i) => {
            div.querySelector('input[name$="[choice_text]"]').name = `choices[${i}][choice_text]`;
            div.querySelector('input[type="checkbox"]').name = `choices[${i}][is_correct]`;
        });
    }
</script>
@endsection

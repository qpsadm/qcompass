@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-5xl bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6">問題追加: {{ $quiz->title }}</h1>

    <form action="{{ route('admin.quizzes.quiz_questions.store', $quiz->id) }}" method="POST">
        @csrf
        <table class="w-full table-auto border-collapse">
            <tbody>
                {{-- 問題文 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">問題文
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <input type="text" name="question_text" placeholder="問題文"
                            value="{{ old('question_text') }}"
                            class="border rounded px-3 py-2 w-full" required>
                        @error('question_text') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 配点 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">配点</th>
                    <td class="px-4 py-2">
                        <input type="number" name="score" value="{{ old('score', 0) }}" placeholder="0"
                            class="border rounded px-3 py-2 w-32">
                        @error('score') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 問題タイプ --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">問題タイプ</th>
                    <td class="px-4 py-2">
                        <select name="type" id="questionType" class="border rounded px-3 py-2 w-40">
                            <option value="single_2" @selected(old('type')=='single_2' )>2択</option>
                            <option value="single_4" @selected(old('type')=='single_4' )>4択</option>
                            <option value="multi" @selected(old('type')=='multi' )>複数選択</option>
                            <option value="text" @selected(old('type')=='text' )>記述式</option>
                        </select>
                    </td>
                </tr>

                {{-- 選択肢ブロック --}}
                <tr class="border-b" id="choiceBlockRow">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">選択肢</th>
                    <td class="px-4 py-2">
                        <div id="choiceInputs" class="mb-2"></div>
                        <button type="button" id="addChoice"
                            class="bg-gray-300 px-2 py-1 rounded hover:bg-gray-400 transition">
                            選択肢を追加
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- 追加ボタン --}}
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition">
                追加
            </button>
            <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
                クイズ詳細に戻る
            </a>
        </div>
    </form>
</div>

<script>
    const typeSelect = document.getElementById('questionType');
    const choiceInputs = document.getElementById('choiceInputs');
    const choiceBlockRow = document.getElementById('choiceBlockRow');
    const addChoiceBtn = document.getElementById('addChoice');

    const MAX_MULTI_CHOICES = 10;

    function renderChoices(existingChoices = []) {
        const type = typeSelect.value;
        choiceInputs.innerHTML = '';

        if (type === 'text') {
            choiceBlockRow.style.display = 'none';
            return;
        }

        choiceBlockRow.style.display = 'table-row';

        let count;
        if (type === 'single_2') count = 2;
        else if (type === 'single_4') count = 4;
        else count = Math.max(existingChoices.length || 2, 2);

        for (let i = 0; i < count; i++) {
            addChoiceInput(existingChoices[i], i);
        }

        // 👇 ここが重要
        if (type === 'multi') {
            addChoiceBtn.style.display = 'inline-block';
            addChoiceBtn.onclick = () => {
                if (choiceInputs.children.length >= MAX_MULTI_CHOICES) {
                    alert(`選択肢は最大 ${MAX_MULTI_CHOICES} 個までです`);
                    return;
                }
                addChoiceInput();
            };
        } else {
            addChoiceBtn.style.display = 'none';
            addChoiceBtn.onclick = null;
        }
    }

    function addChoiceInput(choice = {}, index = null) {
        const i = index ?? choiceInputs.children.length;
        const type = typeSelect.value;
        const isSingle = ['single_2', 'single_4'].includes(type);

        const div = document.createElement('div');
        div.classList.add('mb-2');

        div.innerHTML = `
            <input type="text"
                   name="choices[${i}][choice_text]"
                   class="border px-2 py-1 rounded w-64"
                   value="${choice.choice_text ?? ''}"
                   required>

            <label class="ml-2">
                正解
                <input
                    type="${isSingle ? 'radio' : 'checkbox'}"
                    name="${isSingle ? 'correct_choice' : `choices[${i}][is_correct]`}"
                    value="${i}">
            </label>

            <button type="button"
                    class="removeChoice bg-red-400 text-white px-1 py-0.5 rounded ml-2 hover:bg-red-500">
                削除
            </button>
        `;

        choiceInputs.appendChild(div);

        // 削除
        div.querySelector('.removeChoice').onclick = () => {
            div.remove();
            refreshIndexes();
        };
    }

    function refreshIndexes() {
        const type = typeSelect.value;
        const isSingle = ['single_2', 'single_4'].includes(type);

        [...choiceInputs.children].forEach((div, i) => {
            div.querySelector('input[type="text"]').name =
                `choices[${i}][choice_text]`;

            const correctInput = div.querySelector('input[type="radio"], input[type="checkbox"]');

            if (isSingle) {
                correctInput.name = 'correct_choice';
                correctInput.value = i;
            } else {
                correctInput.name = `choices[${i}][is_correct]`;
            }
        });
    }

    typeSelect.addEventListener('change', () => renderChoices());
    renderChoices();
</script>


@endsection

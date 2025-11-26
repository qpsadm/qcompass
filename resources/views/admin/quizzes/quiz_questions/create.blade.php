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
            <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
               class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
                クイズ編集に戻る
            </a>
        </div>
    </form>
</div>

<script>
    const typeSelect = document.getElementById('questionType');
    const choiceBlockRow = document.getElementById('choiceBlockRow');
    const choiceInputs = document.getElementById('choiceInputs');
    const addChoiceBtn = document.getElementById('addChoice');

    function renderChoices() {
        const type = typeSelect.value;
        choiceInputs.innerHTML = '';
        let choiceCount = 0;
        let maxChoices = 0;

        if (type === 'text') {
            choiceBlockRow.style.display = 'none';
            return;
        } else if (type === 'single_2') {
            choiceCount = 2;
            maxChoices = 2;
            addChoiceBtn.style.display = 'none';
        } else if (type === 'single_4') {
            choiceCount = 4;
            maxChoices = 4;
            addChoiceBtn.style.display = 'none';
        } else if (type === 'multi') {
            choiceCount = 2;
            maxChoices = 10;
            addChoiceBtn.style.display = 'inline-block';
        }

        choiceBlockRow.style.display = 'table-row';
        for (let i = 0; i < choiceCount; i++) addChoiceInput();

        addChoiceBtn.onclick = () => {
            if (choiceInputs.children.length < maxChoices) addChoiceInput();
            else alert(`選択肢は最大 ${maxChoices} 個までです`);
        }
    }

    function addChoiceInput() {
        const index = choiceInputs.children.length;
        const div = document.createElement('div');
        div.classList.add('mb-2');
        div.innerHTML = `
        <input type="text" name="choices[${index}][choice_text]" class="border px-2 py-1 rounded w-64" placeholder="選択肢 ${index+1}" required>
        <label class="ml-2">正解 <input type="checkbox" name="choices[${index}][is_correct]" value="1"></label>
        <button type="button" class="removeChoice bg-red-400 text-white px-1 py-0.5 rounded ml-2 hover:bg-red-500 transition">削除</button>
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

    // 初期表示
    renderChoices();
    typeSelect.addEventListener('change', renderChoices);
</script>
@endsection

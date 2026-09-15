@extends('layouts.app')

@section('content')
    <div class="container max-w-5xl">
        <div class="bg-white rounded-lg shadow-md p-6 mx-auto">

            <h1 class="text-2xl font-bold mb-6 text-gray-800">
                クイズ問題 編集：{{ $quiz->title }}
            </h1>

            {{-- バリデーションエラー表示 --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.quizzes.quiz_questions.update', [$quiz->id, $quizQuestion->id]) }}">
                @csrf
                @method('PUT')

                {{-- type を必ず送る --}}
                {{-- <input type="hidden" name="type" value="{{ $quizQuestion->type }}"> --}}

                <table class="w-full table-auto border-collapse">
                    <tbody>

                        {{-- 問題タイプ --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">問題タイプ（変更不可）</th>
                            <td class="px-4 py-2">
                                <select style="pointer-events: none;" name="type" id="questionType"
                                    class="border rounded px-3 py-2 w-40">
                                    <option value="single_2" @selected($quizQuestion->type == 'single_2')>2択</option>
                                    <option value="single_4" @selected($quizQuestion->type == 'single_4')>4択</option>
                                    <option value="multi" @selected($quizQuestion->type == 'multi')>複数選択</option>
                                    <!-- <option value="text" @selected($quizQuestion->type == 'text')>記述式</option> -->
                                </select>
                            </td>
                        </tr>

                        {{-- 問題文 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                問題文
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <textarea name="question_text" rows="4" required class="w-full border rounded px-3 py-2">{{ old('question_text', $quizQuestion->question_text) }}</textarea>
                            </td>
                        </tr>

                        {{-- 配点 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">配点</th>
                            <td class="px-4 py-2">
                                <input type="number" name="score" min="0"
                                    value="{{ old('score', $quizQuestion->score) }}" class="border rounded px-3 py-2 w-32">
                            </td>
                        </tr>

                        {{-- 選択肢ブロック --}}
                        @if ($quizQuestion->type !== 'text')
                            <tr class="border-b" id="choiceBlockRow">
                                <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">選択肢</th>
                                <td class="px-4 py-2">
                                    @foreach ($quizQuestion->choices as $i => $choice)
                                        <div class="flex items-center gap-6">
                                            {{-- 選択肢テキスト --}}
                                            <input type="text" name="choices[{{ $i }}][choice_text]"
                                                value="{{ old("choices.$i.choice_text", $choice->choice_text) }}" required
                                                class="flex border rounded px-3 py-2 w-1/2">

                                            {{-- single --}}
                                            @if (in_array($quizQuestion->type, ['single_2', 'single_4']))
                                                <label class="flex items-center gap-1 font-bold text-blue-600">
                                                    <input type="radio" name="correct_choice" value="{{ $i }}"
                                                        @checked($choice->is_correct)>
                                                    正解
                                                </label>
                                            @endif

                                            {{-- multi --}}
                                            @if ($quizQuestion->type === 'multi')
                                                <label class="flex items-center gap-1 font-bold text-blue-600">
                                                    <input type="checkbox" name="choices[{{ $i }}][is_correct]"
                                                        value="1" @checked($choice->is_correct)>
                                                    正解
                                                </label>
                                            @endif
                                        </div>
                                    @endforeach

                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

                {{-- ボタン --}}
                <div class="mt-6 flex gap-3">
                    <button type="submit"
                        class="save bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                        更新
                    </button>

                    <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                        class="back bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition">
                        クイズ詳細に戻る
                    </a>
                </div>

            </form>

        </div>
    </div>
@endsection

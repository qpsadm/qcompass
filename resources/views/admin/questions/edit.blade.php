@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">質問編集</h1>

        <form action="{{ route('admin.questions.update', $Question->id) }}" method="POST"
            x-data="questionForm()" x-init="init()">
            @csrf
            @method('PUT')

            <table class="table-auto w-full border-collapse">
                <tbody>
                    {{-- 質問タイトル --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">質問タイトル</th>
                        <td class="px-4 py-2">
                            <input type="text" name="title" value="{{ old('title', $Question->title) }}"
                                class="border px-2 py-1 w-full rounded">
                            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 講座 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">講座</th>
                        <td class="px-4 py-2">
                            <select name="course_id" x-model="selectedCourse" @change="filterTeachers()"
                                class="border rounded px-3 py-2 w-full">
                                <option value="">選択してください</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id', $Question->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_name }} ({{ $course->course_code }})
                                </option>
                                @endforeach
                            </select>
                            @error('course_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 回答講師 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">回答講師
                        </th>
                        <td class="px-4 py-2">
                            <select name="responder_id" class="border rounded px-3 py-2 w-full">
                                <option value="">選択してください</option>
                                <template x-for="teacher in teachers" :key="teacher.id">
                                    <option :value="teacher.id"
                                        :selected="teacher.id == {{ old('responder_id', $Question->responder_id) }}"
                                        x-text="teacher.name"></option>
                                </template>
                            </select>
                            @error('responder_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 質問内容 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">質問内容</th>
                        <td class="px-4 py-2">
                            <textarea name="content" class="border px-2 py-1 w-full rounded">{{ old('content', $Question->content) }}</textarea>
                            @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 回答内容 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">回答内容</th>
                        <td class="px-4 py-2">
                            <textarea name="answer" class="border px-2 py-1 w-full rounded">{{ old('answer', $Question->answer) }}</textarea>
                            @error('answer') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 公開/非公開 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">公開/非公開</th>
                        <td class="px-4 py-2">
                            <select name="is_show" class="border rounded px-3 py-2 w-full">
                                <option value="1" {{ old('is_show', $Question->is_show) == 1 ? 'selected' : '' }}>公開</option>
                                <option value="0" {{ old('is_show', $Question->is_show) == 0 ? 'selected' : '' }}>非公開</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 flex gap-2">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
                <a href="{{ route('admin.questions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">戻る</a>
            </div>
        </form>
    </div>
</div>


<script>
    function questionForm() {
        return {
            selectedCourse: @json(old('course_id')),
            coursesTeachers: @json($coursesTeachers),
            teachers: [],
            init() {
                this.filterTeachers();
            },
            filterTeachers() {
                const key = String(this.selectedCourse).trim();
                this.teachers = this.coursesTeachers[key] || [];
            }
        }
    }
</script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 flex justify-center">

        <div class="bg-white rounded-lg shadow-md w-full max-w-2xl p-6">
            <h1 class="text-2xl font-bold mb-4">アジェンダ編集</h1>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST" x-data="agendaCourses()">
                @csrf
                @method('PUT')

                {{-- 講座タグ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">講座</label>

                    {{-- 選択済みタグ --}}
                    <div class="flex flex-wrap gap-2 mb-2">
                        <template x-for="course in selected" :key="course.id">
                            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded flex items-center">
                                <span x-text="course.course_name"></span>
                                <button type="button" class="ml-1 text-red-500" @click="removeCourse(course.id)">×</button>
                                <input type="hidden" :name="'course_id[]'" :value="course.id">
                            </span>
                        </template>
                    </div>

                    {{-- 選択用セレクト --}}
                    <select @change="addCourse($event)" class="border px-2 py-1 w-100 rounded">
                        <option value="">選択してください</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- アジェンダ名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">アジェンダ名</label>
                    <input type="text" name="agenda_name" value="{{ old('agenda_name', $agenda->agenda_name) }}"
                        class="border px-2 py-1 w-full rounded" required>
                </div>

                {{-- カテゴリ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">カテゴリ</label>
                    <select name="category_id" class="border px-2 py-1 w-100 rounded">
                        <option value="">選択してください</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}"
                                {{ old('category_id', $agenda->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>
                                {{ $cat['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_show" value="1"
                            {{ old('is_show', $agenda->is_show) ? 'checked' : '' }} class="mr-2">
                        表示する
                    </label>
                </div>

                {{-- 承認 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">承認状態</label>
                    <select name="accept" class="border px-2 py-1 w-100 rounded" required>
                        <option value="yes" {{ old('accept', $agenda->accept) == 'yes' ? 'selected' : '' }}>承認済み</option>
                        <option value="no" {{ old('accept', $agenda->accept) == 'no' ? 'selected' : '' }}>下書き</option>
                    </select>
                </div>

                {{-- 内容・概要 (CKEditor) --}}
                <div class="mb-4">
                    <label for="description" class="block font-medium mb-1">内容・概要</label>
                    <textarea name="description" id="description" class="border px-2 py-1 w-full rounded">{{ old('description', $agenda->description ?? '') }}</textarea>
                </div>

                <div class="flex gap-2 mt-4">
                    <!-- 更新ボタン -->
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        更新
                    </button>

                    <!-- 一覧に戻るボタン -->
                    <a href="{{ route('admin.agendas.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>

        {{-- CKEditor 4 CDN --}}
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('description', {
                language: 'ja',
                allowedContent: true,
            });
        </script>

        {{-- Alpine.js 講座タグ用 --}}
        <script>
            function agendaCourses() {
                return {
                    courses: @json($courses),
                    selected: @json($selectedCourses ?? []),
                    addCourse(event) {
                        const id = parseInt(event.target.value);
                        if (!id) return;
                        const course = this.courses.find(c => c.id === id);
                        if (course && !this.selected.some(c => c.id === id)) {
                            this.selected.push(course);
                        }
                        event.target.value = '';
                    },
                    removeCourse(id) {
                        this.selected = this.selected.filter(c => c.id !== id);
                    }
                }
            }
        </script>
    @endsection

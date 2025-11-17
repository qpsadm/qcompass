@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">お知らせ編集</h1>

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

    <form action="{{ route('admin.notices.update', ['notice' => $agenda->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- 講座 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">講座</label>
            <select name="course_id" class="border px-2 py-1 w-full rounded" required>
                <option value="">選択してください</option>
                @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    {{ isset($agenda) && $agenda->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->course_name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- お知らせ名 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">お知らせ名</label>
            <input type="text" name="agenda_name" value="{{ old('agenda_name', $agenda->agenda_name) }}" class="border px-2 py-1 w-full rounded" required>
        </div>

        {{-- 説明 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">説明</label>
            <textarea name="description" id="description" class="border px-2 py-1 w-full rounded">{{ old('description', $agenda->description) }}</textarea>
        </div>

        {{-- 表示 --}}
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_show" value="1" {{ old('is_show', $agenda->is_show) ? 'checked' : '' }} class="mr-2">
                表示する
            </label>
        </div>

        {{-- 承認状態 --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">承認状態</label>
            <select name="accept" class="border px-2 py-1 w-full rounded" required>
                <option value="yes" {{ old('accept', $agenda->accept) == 'yes' ? 'selected' : '' }}>承認済み</option>
                <option value="no" {{ old('accept', $agenda->accept) == 'no' ? 'selected' : '' }}>下書き</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
    </form>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
        language: 'ja',
        allowedContent: true
    });
</script>
@endsection

<div class="mb-4">
    <label class="block">タイトル</label>
    <input type="text" name="title" value="{{ old('title', $announcement->title ?? '') }}" class="border p-2 w-full">
</div>

<div class="mb-4">
    <label class="block">カテゴリ</label>
    <select name="type_id" class="border p-2 w-full">
        @foreach($types as $type)
        <option value="{{ $type->id }}"
            @selected(old('type_id', $announcement->type_id ?? '') == $type->id)
            >
            {{ $type->type_name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block">講座</label>
    <select name="course_id" class="border p-2 w-full">
        @foreach($courses as $course)
        <option value="{{ $course->id }}"
            @selected(old('course_id', $announcement->course_id ?? '') == $course->id)
            >
            {{ $course->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block">本文</label>
    <textarea name="content" class="border p-2 w-full" rows="5">{{ old('content', $announcement->content ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block">表示する？</label>
    <select name="is_show" class="border p-2">
        <option value="1" @selected(old('is_show', $announcement->is_show ?? 1) == 1)>表示</option>
        <option value="0" @selected(old('is_show', $announcement->is_show ?? 1) == 0)>非表示</option>
    </select>
</div>

<div class="mb-4">
    <label class="block">状態（status）</label>
    <input type="number" name="status" value="{{ old('status', $announcement->status ?? 0) }}" class="border p-2 w-full">
</div>

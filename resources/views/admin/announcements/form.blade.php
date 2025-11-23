<table class="w-full table-auto border-collapse">
    <tbody>
        {{-- タイトル --}}
        <tr class="border-b">
            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">タイトル
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
            </th>
            <td class="px-4 py-2">
                <input type="text" name="title" value="{{ old('title', $announcement->title ?? '') }}"
                    class="border rounded px-3 py-2 w-full">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </td>
        </tr>

        {{-- カテゴリ --}}
        <tr class="border-b">
            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">カテゴリ</th>
            <td class="px-4 py-2">
                <select name="type_id" class="border rounded px-3 py-2 w-64">
                    <option value="">選択してください</option>
                    @foreach ($types as $type)
                    <option value="{{ $type->id }}" @selected(old('type_id', $announcement->type_id ?? '') == $type->id)>
                        {{ $type->type_name }}
                    </option>
                    @endforeach
                </select>
                @error('type_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </td>
        </tr>

        {{-- 講座 --}}
        <tr class="border-b">
            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座</th>
            <td class="px-4 py-2">
                <select name="course_id" class="border rounded px-3 py-2 w-64">
                    <option value="0" @selected(old('course_id', $announcement->course_id ?? 0) == 0)>全員向け</option>
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}" @selected(old('course_id', $announcement->course_id ?? 0) == $course->id)>
                        {{ $course->course_name }}
                    </option>
                    @endforeach
                </select>
                @error('course_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </td>
        </tr>

        {{-- 本文 --}}
        <tr class="border-b">
            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">本文</th>
            <td class="px-4 py-2">
                <textarea name="content" rows="5" class="border rounded px-3 py-2 w-full">{{ old('content', $announcement->content ?? '') }}</textarea>
                @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </td>
        </tr>

        {{-- 表示 --}}
        <tr class="border-b">
            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示する？</th>
            <td class="px-4 py-2 flex items-center">
                <input type="checkbox" id="is_show" name="is_show" value="1"
                    @if(old('is_show', $announcement->is_show ?? 1)) checked @endif
                class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="is_show" class="ml-2">表示</label>
                @error('is_show') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </td>
        </tr>

        {{-- 状態 --}}
        <tr class="border-b">
            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">状態（status）</th>
            <td class="px-4 py-2">
                <select name="status" class="border rounded px-3 py-2 w-32">
                    <option value="1" @selected(old('status', $announcement->status ?? 2) == 1)>承認待ち</option>
                    <option value="2" @selected(old('status', $announcement->status ?? 2) == 2)>承認済み</option>
                </select>
                @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </td>
        </tr>
    </tbody>
</table>

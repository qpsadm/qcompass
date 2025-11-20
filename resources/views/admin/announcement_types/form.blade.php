<div class="mb-4">
    <label class="block">種別名</label>
    <input type="text" name="type_name" value="{{ old('type_name', $type->type_name ?? '') }}" class="border p-2 w-full">
</div>

<div class="mb-4">
    <label class="block">表示フラグ</label>
    <select name="is_show" class="border p-2 w-full">
        <option value="1" @selected(old('is_show', $type->is_show ?? 1) == 1)>表示</option>
        <option value="0" @selected(old('is_show', $type->is_show ?? 1) == 0)>非表示</option>
    </select>
</div>

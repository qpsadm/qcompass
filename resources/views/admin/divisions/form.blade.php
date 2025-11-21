@csrf

<div class="mb-3">
    <label class="block font-semibold">部署コード</label>
    <input type="text" name="code" value="{{ old('code', $division->code ?? '') }}"
        class="border p-2 w-full">
</div>

<div class="mb-3">
    <label class="block font-semibold">部署名</label>
    <input type="text" name="name" value="{{ old('name', $division->name ?? '') }}"
        class="border p-2 w-full">
</div>

<div class="mb-3">
    <label class="block font-semibold">電話番号</label>
    <input type="text" name="tel" value="{{ old('tel', $division->tel ?? '') }}"
        class="border p-2 w-full">
</div>

<div class="mb-3">
    <label class="block font-semibold">郵便番号</label>
    <input type="text" name="post_code" value="{{ old('post_code', $division->post_code ?? '') }}"
        class="border p-2 w-full">
</div>

<div class="mb-3">
    <label class="block font-semibold">住所</label>
    <input type="text" name="address" value="{{ old('address', $division->address ?? '') }}"
        class="border p-2 w-full">
</div>

<div class="mb-3">
    <label class="block font-semibold">表示する？</label>
    <input type="checkbox" name="is_show" value="1"
        {{ old('is_show', $division->is_show ?? true) ? 'checked' : '' }}>
</div>

<div class="mb-3">
    <label class="block font-semibold">備考</label>
    <textarea name="memo" class="border p-2 w-full">{{ old('memo', $division->memo ?? '') }}</textarea>
</div>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
    保存
</button>

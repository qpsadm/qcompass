<div class="mb-4">
    <label class="block font-medium mb-1">種別名</label>
    <input type="text" name="type_name" value="{{ old('type_name', $type->type_name ?? '') }}"
        class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>


<div class="mb-4" x-data="{ is_show: {{ old('is_show', $JobOffer->is_show ?? 0) }} }">
    <span class="font-medium mr-2">表示フラグ</span>
    <div class="flex gap-2">
        <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
            公開
        </label>

        <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
            <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
            非公開
        </label>
    </div>
</div>
</div>

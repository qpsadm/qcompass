<div class="mb-4">
    <label class="block font-medium mb-1">種別名</label>
    <input type="text" name="type_name" value="{{ old('type_name', $type->type_name ?? '') }}"
        class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

<div class="mb-4">
    <label class="block font-medium mb-1">表示フラグ</label>
    <div class="flex items-center space-x-2">
        {{-- チェックOFFでも値を送る --}}
        <input type="hidden" name="is_show" value="0">
        <input type="checkbox" id="is_show" name="is_show" value="1"
            @if(old('is_show', $type->is_show ?? 1)) checked @endif
        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
        <label for="is_show" class="font-medium">表示</label>
    </div>
</div>

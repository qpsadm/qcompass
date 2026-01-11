<table class="w-full table-auto border-collapse">
    <tbody>
        {{-- 種別名 --}}
        <tr class="border-b">
            <th class="px-4 py-2 bg-gray-100 text-right font-medium w-1/4">
                種別名
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">
                    必須
                </span>
            </th>
            <td class="px-4 py-2">
                <input
                    type="text"
                    name="type_name"
                    value="{{ old('type_name', $type->type_name ?? '') }}"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </td>
        </tr>

        {{-- 表示フラグ --}}
        <tr class="border-b">
            <th class="px-4 py-2 bg-gray-100 text-right font-medium">
                表示フラグ
            </th>
            <td class="px-4 py-2"
                x-data="{ is_show: {{ old('is_show', $type->is_show ?? 0) }} }">
                <div class="flex gap-2">
                    <label
                        :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                        <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                        公開
                    </label>

                    <label
                        :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                        <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                        非公開
                    </label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

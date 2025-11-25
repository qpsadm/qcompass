<div class="container mx-auto p-6 max-w-5xl">
    <h1 class="text-3xl font-bold mb-6">{{ isset($division) ? '部署編集' : '部署新規作成' }}</h1>
    <form
        action="{{ isset($division) ? route('admin.divisions.update', $division->id) : route('admin.divisions.store') }}"
        method="POST">
        @csrf
        @if (isset($division))
            @method('PUT')
        @endif

        <table class="w-full table-auto border-collapse">
            <tbody>
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">部署コード</th>
                    <td class="px-4 py-2">
                        <input type="text" name="code" value="{{ old('code', $division->code ?? '') }}"
                            class="border rounded px-3 py-2 w-64">
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">部署名</th>
                    <td class="px-4 py-2">
                        <input type="text" name="name" value="{{ old('name', $division->name ?? '') }}"
                            class="border rounded px-3 py-2 w-64">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">電話番号</th>
                    <td class="px-4 py-2">
                        <input type="text" name="tel" value="{{ old('tel', $division->tel ?? '') }}"
                            class="border rounded px-3 py-2 w-64">
                        @error('tel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">郵便番号</th>
                    <td class="px-4 py-2">
                        <input type="text" name="post_code"
                            value="{{ old('post_code', $division->post_code ?? '') }}"
                            class="border rounded px-3 py-2 w-64">
                        @error('post_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="w-1/ px-4 py-2 bg-gray-100 text-right font-medium">住所</th>
                    <td class="px-4 py-2">
                        <input type="text" name="address" value="{{ old('address', $division->address ?? '') }}"
                            class="border rounded px-3 py-2 w-full">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示する</th>
                    <td class="px-4 py-2">
                        <input type="checkbox" name="is_show" value="1"
                            {{ old('is_show', $division->is_show ?? true) ? 'checked' : '' }} class="mr-2">
                    </td>
                </tr>

                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">備考</th>
                    <td class="px-4 py-2">
                        <textarea name="memo" class="border rounded px-3 py-2 w-64">{{ old('memo', $division->memo ?? '') }}</textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                保存
            </button>
            <a href="{{ route('admin.divisions.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                一覧に戻る
            </a>
        </div>
    </form>
</div>

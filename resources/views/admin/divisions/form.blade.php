@csrf

<div class="bg-white rounded-lg shadow-md p-6 max-w-lg mx-auto space-y-4">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">{{ isset($division) ? '部署編集' : '部署新規作成' }}</h1>

    {{-- 部署コード --}}
    <div>
        <label class="block font-semibold mb-1">部署コード</label>
        <input type="text" name="code" value="{{ old('code', $division->code ?? '') }}"
            class="w-full border rounded px-3 py-2">
        @error('code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- 部署名 --}}
    <div>
        <label class="block font-semibold mb-1">部署名</label>
        <input type="text" name="name" value="{{ old('name', $division->name ?? '') }}"
            class="w-full border rounded px-3 py-2">
        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- 電話番号 --}}
    <div>
        <label class="block font-semibold mb-1">電話番号</label>
        <input type="text" name="tel" value="{{ old('tel', $division->tel ?? '') }}"
            class="w-full border rounded px-3 py-2">
        @error('tel') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- 郵便番号 --}}
    <div>
        <label class="block font-semibold mb-1">郵便番号</label>
        <input type="text" name="post_code" value="{{ old('post_code', $division->post_code ?? '') }}"
            class="w-full border rounded px-3 py-2">
        @error('post_code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- 住所 --}}
    <div>
        <label class="block font-semibold mb-1">住所</label>
        <input type="text" name="address" value="{{ old('address', $division->address ?? '') }}"
            class="w-full border rounded px-3 py-2">
        @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- 表示する --}}
    <div class="flex items-center">
        <input type="checkbox" name="is_show" value="1"
            {{ old('is_show', $division->is_show ?? true) ? 'checked' : '' }}
            class="mr-2">
        <label class="font-semibold">表示する？</label>
    </div>

    {{-- 備考 --}}
    <div>
        <label class="block font-semibold mb-1">備考</label>
        <textarea name="memo" class="w-full border rounded px-3 py-2">{{ old('memo', $division->memo ?? '') }}</textarea>
    </div>

    {{-- ボタン --}}
    <div class="flex gap-3 mt-4">
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition">
            保存
        </button>
        <a href="{{ route('admin.divisions.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition">
            一覧に戻る
        </a>
    </div>
</div>

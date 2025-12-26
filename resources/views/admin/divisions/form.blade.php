<div class="container mx-auto p-6 max-w-5xl"
    x-data="{ open: false }">

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h1 class="text-3xl font-bold mb-6">
            {{ isset($division) ? '部署編集' : '部署新規作成' }}
        </h1>

        {{-- 保存フォーム --}}
        <form
            action="{{ isset($division)
                ? route('admin.divisions.update', $division->id)
                : route('admin.divisions.store') }}"
            method="POST">
            @csrf
            @isset($division)
            @method('PUT')
            @endisset

            <table class="w-full table-auto border-collapse">
                <tbody>
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right">部署コード</th>
                        <td class="px-4 py-2">
                            <input type="text" name="code"
                                value="{{ old('code', $division->code ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                            @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">部署名</th>
                        <td class="px-4 py-2">
                            <input type="text" name="name"
                                value="{{ old('name', $division->name ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">電話番号</th>
                        <td class="px-4 py-2">
                            <input type="text" name="tel"
                                value="{{ old('tel', $division->tel ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">郵便番号</th>
                        <td class="px-4 py-2">
                            <input type="text" name="post_code"
                                value="{{ old('post_code', $division->post_code ?? '') }}"
                                class="border rounded px-3 py-2 w-64">
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">住所</th>
                        <td class="px-4 py-2">
                            <input type="text" name="address"
                                value="{{ old('address', $division->address ?? '') }}"
                                class="border rounded px-3 py-2 w-full">
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">表示フラグ</th>
                        <td class="px-4 py-2"
                            x-data="{ is_show: '{{ old('is_show', $division->is_show ?? 1) }}' }">
                            <div class="flex gap-2">
                                <label
                                    :class="is_show == 1
                                        ? 'bg-green-600 text-white'
                                        : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer">
                                    <input type="radio" name="is_show" value="1"
                                        class="hidden" x-model="is_show">
                                    公開
                                </label>

                                <label
                                    :class="is_show == 0
                                        ? 'bg-red-500 text-white'
                                        : 'bg-gray-200 text-gray-700'"
                                    class="px-4 py-2 rounded-full cursor-pointer">
                                    <input type="radio" name="is_show" value="0"
                                        class="hidden" x-model="is_show">
                                    非公開
                                </label>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right">備考</th>
                        <td class="px-4 py-2">
                            <textarea name="memo"
                                class="border rounded px-3 py-2 w-64">{{ old('memo', $division->memo ?? '') }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- ボタン --}}
            <div class="mt-6 flex gap-3 items-center">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    保存
                </button>

                @isset($division)
                <button type="button"
                    @click="open = true"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded">
                    削除
                </button>
                @endisset

                <a href="{{ route('admin.divisions.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>

    {{-- 削除確認モーダル（同じ x-data スコープ内！） --}}
    @isset($division)
    <div x-show="open" x-cloak x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div x-show="open" x-transition.scale
            class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">

            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>

            <p class="text-gray-700 text-center mb-5">
                「{{ $division->name }}」を削除しますか？
            </p>

            <div class="flex justify-center gap-4">
                <button type="button"
                    @click="open = false"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    キャンセル
                </button>

                <form action="{{ route('admin.divisions.destroy', $division->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endisset
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

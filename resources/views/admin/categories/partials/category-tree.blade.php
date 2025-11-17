@props(['categories', 'level' => 0, 'showActions' => true, 'radioName' => null])

<ul class="space-y-2">
    @foreach ($categories as $category)
        <li x-data="{ open: false }">
            <div class="flex items-center justify-between bg-white rounded-md shadow-sm py-2 px-3 hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div style="margin-left: {{ $level * 1 }}rem"></div>

                    {{-- 展開ボタン --}}
                    @if ($category->childrenRecursive->isNotEmpty())
                        <button @click="open = !open"
                            class="w-6 h-6 flex justify-center items-center bg-gray-100 rounded">
                            <span x-text="open ? '▼' : '▶'"></span>
                        </button>
                    @else
                        <span class="w-6 h-6 inline-block"></span>
                    @endif

                    {{-- 親選択用ラジオ --}}
                    @if ($radioName)
                        <input type="radio" name="{{ $radioName }}" value="{{ $category->id }}" class="mr-2">
                    @endif

                    {{-- カテゴリー名・ID --}}
                    <div class="flex flex-col">
                        <span class="font-medium text-gray-800">{{ $category->name }}</span>
                        <span class="text-xs text-gray-500">
                            ID: {{ $category->id }} /コード: {{ $category->code }}
                            @if ($category->children->count())
                                /子: {{ $category->children->count() }}
                            @endif
                        </span>
                    </div>
                </div>

                @if ($showActions)
                    <div class="flex items-center gap-2">
                        @if (!empty($category->theme_color))
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded"
                                style="background-color: {{ $category->theme_color }}; color: #fff;">
                                {{ $category->theme_color }}
                            </span>
                        @endif

                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                            class="px-2 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                            編集
                        </a>

                        <button type="button" onclick="openDeleteModal({{ $category->id }}, '{{ $category->name }}')"
                            class="px-2 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                            削除
                        </button>
                    </div>
                @endif
            </div>

            {{-- 子があれば再帰表示 --}}
            @if ($category->childrenRecursive->isNotEmpty())
                <div class="mt-2 ml-6" x-show="open" x-transition>
                    @include('admin.categories.partials.category-tree', [
                        'categories' => $category->childrenRecursive,
                        'level' => $level + 1,
                        'showActions' => $showActions,
                        'radioName' => $radioName,
                    ])
                </div>
            @endif
        </li>
    @endforeach
</ul>

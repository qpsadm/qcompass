@props(['categories', 'level' => 0])

<ul class="space-y-2">
    @foreach ($categories as $category)
        <li class="pl-{{ $level * 4 }}">
            <div class="flex items-center justify-between bg-gray-50 rounded py-1 pr-4 hover:bg-gray-100">
                <div class="flex items-center gap-2">
                    @if ($category->childrenRecursive && $category->childrenRecursive->isNotEmpty())
                        <button class="toggle-children transform transition-transform duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @else
                        <span class="w-4"></span> <!-- 子なしはスペース調整用 -->
                    @endif
                    <span class="font-medium">{{ $category->name }}</span>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                        class="px-2 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                        編集
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                            削除
                        </button>
                    </form>
                </div>
            </div>

            @if ($category->childrenRecursive && $category->childrenRecursive->isNotEmpty())
                <div class="ml-4 mt-1 hidden children-container">
                    @include('admin.categories.partials.category-tree', [
                        'categories' => $category->childrenRecursive,
                        'level' => $level + 1,
                    ])
                </div>
            @endif
        </li>
    @endforeach
</ul>

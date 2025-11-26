<div class="content-list">
    <table>
        @foreach ($items as $item)
        @php
        // 講座名の決定
        $courseName = $item->course?->name ?: '本講座';
        if (empty($courseName)) {
        $courseName = '全講座';
        }
        @endphp

        <tr>
            {{-- 日付 --}}
            <td class="date">
                {{ $item->created_at->format('Y/m/d') }}
            </td>

            {{-- カテゴリー --}}
            <td class="category">
                <p class="category-{{ $item->type?->slug ?? 'default' }}">
                    {{ $courseName }}
                </p>
            </td>

            {{-- タイトル（講座名 + カテゴリー名 + タイトル） --}}
            <td class="title">
                <a href="{{ route('user.announcements.show', $item->id) }}">
                    【{{ $item->type?->type_name ?? '未分類' }}】
                    {{ $item->title }}
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>

<div class="content-list">
    <table>
        @foreach ($items as $item)
        @if ($item->status===2) {{-- status が true の場合のみ --}}
        @php
        $courseName = $item->course?->name ?: '本講座';
        if (empty($courseName)) {
        $courseName = '全講座';
        }
        @endphp

        <tr>
            <td class="date">{{ $item->created_at->format('Y/m/d') }}</td>
            <td class="category">
                <p class="category-{{ $item->type?->slug ?? 'default' }}">{{ $courseName }}</p>
            </td>
            <td class="title">
                <a href="{{ route('user.news.news_info', $item->id) }}">
                    【{{ $item->type?->type_name ?? '未分類' }}】{{ $item->title }}
                </a>
            </td>
        </tr>
        @endif
        @endforeach

    </table>
</div>

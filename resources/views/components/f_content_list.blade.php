<div class="content-list">
    <table>
        @foreach ($items as $item)
        @php
        // course_name が空でなければ "本講座" にする
        $courseName = $item->course?->course_name;
        if (!empty($courseName)) {
        $courseName = '本講座';
        } else {
        $courseName = '全講座';
        }
        @endphp
        <tr>
            <td class="date">{{ $item->created_at->format('Y/m/d') }}</td>
            <td class="category">
                <p class="category-{{ $item->type?->slug ?? 'default' }} {{ !empty($item->course?->course_name) ? 'course-hon' : 'course-all' }}">
                    {{ $courseName }}
                </p>
            </td>
            <td class="title">
                <a href="{{ route('user.news.news_info', $item->id) }}">
                    【{{ $item->type?->type_name ?? '未分類' }}】{{ $item->title }}
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>

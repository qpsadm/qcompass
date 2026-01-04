@props([
'items',
'titleField' => 'title',
'linkRoute' => 'user.news.news_info',
'paramName' => 'announcement',
'isNews' => false,
])

<div class="content-list">
    <table>
        @foreach ($items as $item)
        @php
        // 日付
        $date = optional($item->created_at)->format('Y/m/d') ?? '';

        // タイトル
        $title = $item->{$titleField} ?? '未設定';

        // リンク
        $link = route($linkRoute, [$paramName => $item->id]);
        @endphp

        <tr>
            <td class="date">{{ $date }}</td>

            {{-- ニュースのみカテゴリ表示 --}}
            @if($isNews)
            @php
            $courseName = (!empty($item->course?->course_name)) ? '本講座' : '全体';
            $categorySlug = $item->type?->slug ?? 'default';
            @endphp
            <td class="category">
                <p class="category-{{ $categorySlug }} {{ $courseName === '本講座' ? 'course-hon' : 'course-all' }}">
                    {{ $courseName }}
                </p>
            </td>
            @endif

            <td class="title">
                <a href="{{ $link }}">
                    {{ $title }}
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>

<div class="content-list">
    <table>
        @foreach ($items as $item)
        @php
        // 日付
        $date = $item->created_at->format('Y/m/d');

        // タイトル用カラム（デフォルト 'title'）
        $titleField = $titleField ?? 'title';
        $title = $item->{$titleField} ?? '未設定';

        // リンク用ルートとパラメータ名（デフォルトはニュース）
        $linkRoute = $linkRoute ?? 'user.news.news_info';
        $paramName = $paramName ?? 'announcement';
        $link = route($linkRoute, [$paramName => $item->id]);

        // ニュースかAgendaかをフラグで判定
        $isAgenda = $isAgenda ?? false;
        @endphp

        <tr>
            <td class="date">{{ $date }}</td>

            @unless($isAgenda)
            @php
            // ニュース用カテゴリ
            $courseName = isset($item->course) && !empty($item->course->course_name) ? '本講座' : '全体';
            $categorySlug = $item->type?->slug ?? 'default';
            @endphp
            <td class="category">
                <p class="category-{{ $categorySlug }} {{ $courseName === '本講座' ? 'course-hon' : 'course-all' }}">
                    {{ $courseName }}
                </p>
            </td>
            @endunless

            <td class="title">
                <a href="{{ $link }}">
                    {{ $title }}
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>

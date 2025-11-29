<div class="content-list">
    <table>
        @foreach ($items as $item)
        @php
        // 日付
        $date = $item->created_at->format('Y/m/d');

        // タイトル用カラム（デフォルト 'title'）
        $titleField = $titleField ?? 'title';
        $title = $item->{$titleField} ?? '未設定';

        // リンク用ルート（ニュースなら news_info、それ以外は外部で指定可能）
        $linkRoute = $linkRoute ?? 'user.news.news_info';
        $paramName = $paramName ?? 'announcement';
        $link = route($linkRoute, [$paramName => $item->id]);

        // ニュースかどうかをフラグで判定（外から渡すか自動判定）
        $isNews = $isNews ?? false;
        @endphp

        <tr>
            <td class="date">{{ $date }}</td>

            {{-- ニュースだけカテゴリ表示 --}}
            @if($isNews)
            @php
            $courseName = isset($item->course) && !empty($item->course->course_name) ? '本講座' : '全体';
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

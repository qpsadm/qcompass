@props([
'items',
'titleField' => 'title',
'linkRoute' => 'user.news.news_info', // デフォルトルート
'paramName' => 'announcement', // デフォルトのルートパラメータ名
'isNews' => false,
])

<div class="content-list">
    <table>
        @foreach ($items as $item)
        @php
        // 日付
        $date = optional($item->updated_at)->format('Y/m/d') ?? '';

        // タイトル
        $title = $item->{$titleField} ?? '未設定';

        // ルートパラメータを自動判定
        if ($item instanceof \App\Models\JobOffer) {
        $paramKey = 'jobOffer';
        } elseif ($item instanceof \App\Models\Agenda) {
        $paramKey = 'agenda';
        } else {
        $paramKey = $paramName;
        }

        // リンク生成
        $link = route($linkRoute, [$paramKey => $item->id]);
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

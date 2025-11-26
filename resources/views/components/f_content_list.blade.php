{{-- <div class="content-list">
    <table>
        <tr>
            <td class="date">2025/10/29</td>
            <td class="category">
                <p class="category-news">WEBシステム</p>
            </td>
            <td class="title"><a href="">【お知らせ】明日（11/20）休講のお知らせ</a></td>
        </tr>
        <tr>
            <td class="date">2025/10/29</td>
            <td class="category">
                <p class="category-agenda">全体</p>
            </td>
            <td class="title"><a href="">【イベント】講座体験イベントのご案内</a></td>
        </tr>
        <tr>
            <td class="date">2025/10/28</td>
            <td class="category">
                <p class="category-agenda">全体</p>
            </td>
            <td class="title"><a href="">【就職支援】就職支援講座のご案内</a></td>
        </tr>
        <tr>
            <td class="date">2025/10/24</td>
            <td class="category">
                <p class="category-agenda">全体</p>
            </td>
            <td class="title"><a href="">【お知らせ】施設内環境の保全について</a></td>
        </tr>
        <tr>
            <td class="date">2025/10/22</td>
            <td class="category">
                <p class="category-news">WEBシステム</p>
            </td>
            <td class="title"><a href="news_info.html">【キャリコン】第2回キャリアコンサルティングについて</a></td>
        </tr>
    </table>
</div> --}}
@props(['items'])

<div class="content-list">
    <table>
        @foreach ($items as $item)
            <tr>
                <td class="date">
                    {{ $item->created_at->format('Y/m/d') }}
                </td>

                <td class="category">
                    <p class="category-{{ $item->type?->slug ?? 'default' }}">
                        {{ $item->type?->name ?? '未分類' }}
                    </p>
                </td>

                <td class="title">
                    <a href="{{ route('user.announcements.show', $item->id) }}">
                        {{ $item->title }}
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</div>

@extends('layouts.f_layout')

@section('title', '就職支援')

@section('main-content')
<div class="container">
    {{-- f_page_title の検索フォームを活用 --}}
    <x-f_page_title
        :search="true"
        title="就職支援"
        :searchName="'keyword'"
        :searchPlaceholder="'キーワードで求人検索'" />

    @php
        $currentTab = request('tab', 'offers');
    @endphp

    <div x-data="{ tab: '{{ $currentTab }}' }">

        {{-- タブボタン --}}
        <div class="tab-container mb-4">
            <div class="btn-tab flex gap-2">
                <button class="tab-button"
                        :class="{ 'active': tab === 'offers' }"
                        @click="tab = 'offers'; changeTab('offers')">
                    ハローワークの求人票
                </button>
                <button class="tab-button"
                        :class="{ 'active': tab === 'download' }"
                        @click="tab = 'download'; changeTab('download')">
                    履歴書・職務経歴書のダウンロード
                </button>
            </div>
        </div>

        {{-- 求人票タブ --}}
        <div x-show="tab === 'offers'" class="content-box" x-cloak>

            <div class="content-list">
                <table>
                    @forelse ($jobs as $job)
                        <tr>
                            <td class="date">{{ $job->created_at->format('Y/m/d') }}</td>
                            <td class="title">
                                <a href="{{ url('user/job/' . $job->id) }}">{{ $job->title }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-gray-500 py-4">
                                該当する求人はありません
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>
            <x-f_pagination :paginator="$jobs" />
        </div>

        {{-- ダウンロードタブ --}}
        <div x-show="tab === 'download'" class="content-box" x-cloak>
            <div class="content-list">
                <table>
                    @forelse ($agendas as $agenda)
                        <tr>
                            <td class="date">{{ $agenda->created_at->format('Y/m/d') }}</td>
                            <td class="title">
                                <a href="{{ route('user.agenda.info', $agenda->id) }}">{{ $agenda->agenda_name }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-gray-500 py-4">
                                ダウンロード可能な資料はありません
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>
            <x-f_pagination :paginator="$agendas" />
        </div>

    </div>

    <x-f_bread_crumbs />
</div>
@endsection

@section('code-page-js')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function changeTab(tabName) {
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName); // タブをURLにセット
        url.searchParams.delete('page'); // ページ番号をリセット
        window.location.href = url; // 1ページ目を表示
    }
</script>
@endsection

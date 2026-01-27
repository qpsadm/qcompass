@extends('layouts.f_layout')

@section('title', '就職支援')

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームあり） -->
        <x-f_page_title title="就職支援" :search="true" :searchName="'keyword'" :searchPlaceholder="'キーワード検索'" />

        @php
            $currentTab = request('tab', 'offers');
        @endphp

        <div x-data="{ tab: '{{ $currentTab }}' }">

            <!-- カテゴリ一覧 -->
            <div class="tab-container">
                <div class="btn-tab">
                    <button class="tab-button" :class="{ 'active': tab === 'offers' }"
                        @click="tab = 'offers'; changeTab('offers')">
                        ハローワークの求人票
                    </button>
                    <button class="tab-button" :class="{ 'active': tab === 'download' }"
                        @click="tab = 'download'; changeTab('download')">
                        履歴書・職務経歴書のダウンロード
                    </button>
                </div>
            </div>

            <!-- 求人票一覧ページ -->
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
                                <td colspan="2">
                                    該当する求人はありません
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
                <x-f_pagination :paginator="$jobs" />
            </div>

            <!-- ダウンロード一覧ページ -->
            <div x-show="tab === 'download'" class="content-box" x-cloak>
                <div class="content-list">
                    <table>
                        @forelse ($agendas as $agenda)
                            <tr>
                                <td class="date">{{ $agenda->created_at->format('Y/m/d') }}</td>
                                <td class="title">
                                    @if ($agenda->category_id == 52)
                                        <a href="{{ route('user.job.job_dl_info', ['agenda' => $agenda->id]) }}">
                                            {{ $agenda->agenda_name }}
                                        </a>
                                    @else
                                        <a href="{{ route('user.agenda.info', $agenda->id) }}">
                                            {{ $agenda->agenda_name }}
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    ダウンロード可能な資料はありません
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>

                <!-- ページネーション -->
                <x-f_pagination :paginator="$agendas" />

            </div>
        </div>

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection

@section('code-page-js')

    <!-- CDN読み込み（Alpine.js） -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function changeTab(tabName) {
            const url = new URL(window.location);

            // タブをURLにセット
            url.searchParams.set('tab', tabName);

            // ページ番号をリセット
            url.searchParams.delete('page');

            // 1ページ目を表示
            window.location.href = url;
        }
    </script>
@endsection

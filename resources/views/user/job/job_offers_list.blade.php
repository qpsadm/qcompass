@extends('layouts.f_layout')
@section('main-content')
<div class="container">
    <x-f_page_title :search="true" title="就職支援" />

    {{-- 現在のタブをリクエストから取得 --}}
    @php
    $currentTab = request('tab', 'offers');
    @endphp

    <div x-data="{ tab: '{{ $currentTab }}' }">

        <div class="tab-container">
            <div class="btn-tab">
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
                    @foreach ($jobs as $job)
                    <tr>
                        <td class="date">{{ $job->created_at->format('Y/m/d') }}</td>
                        <td class="title"><a href="{{ url('user/job/' . $job->id) }}">{{ $job->title }}</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <x-f_pagination :paginator="$jobs" />
        </div>

        {{-- ダウンロードタブ --}}
        <div x-show="tab === 'download'" class="content-box" x-cloak>
            <div class="content-list">
                <table>
                    @foreach ($agendas as $agenda)
                    <tr>
                        <td class="date">{{ $agenda->created_at->format('Y/m/d') }}</td>
                        <td class="title">
                            <a href="{{ route('user.agenda.info', $agenda->id) }}">{{ $agenda->agenda_name }}</a>
                        </td>
                    </tr>
                    @endforeach
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
        window.location.href = url; // ページリロードで1ページ目表示
    }
</script>
@endsection

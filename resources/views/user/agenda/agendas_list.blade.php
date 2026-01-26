@extends('layouts.f_layout')

@section('title', '最新のアジェンダ一覧')

@section('main-content')
    <div class="container">

        <!-- ページタイトル（検索フォームあり） -->
        <x-f_page_title
            title="最新のアジェンダ一覧{{ $selectedCategoryId !== null && $selectedCategoryName ? '：' . $selectedCategoryName : '' }}"
            :search="true" :searchAction="route('user.agenda.agendas_list')" searchName="search" searchPlaceholder="キーワード検索" />

        <!-- カテゴリ一覧 -->
        <x-f_category_accordion :categories="$categories" :selectedCategoryId="$selectedCategoryId" :routeFunction="fn($category) => $category
            ? route('user.agenda.agendas_list', ['category_id' => $category->id])
            : route('user.agenda.agendas_list')" />

        <!-- コンテンツ一覧 -->
        <div class="content-list">
            <table>
                @forelse ($agendas as $agenda)
                    <tr>
                        <td class="date">{{ \Carbon\Carbon::parse($agenda->created_at)->format('Y/m/d') }}</td>
                        <td class="title">
                            <a href="{{ route('user.agenda.info', $agenda) }}">
                                {{ $agenda->agenda_name }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            該当するアジェンダはありません
                        </td>
                    </tr>
                @endforelse
            </table>
        </div>

        <!-- ページネーション -->
        <x-f_pagination :paginator="$agendas" />

        <!-- パンくずリスト -->
        <x-f_bread_crumbs />

    </div>
@endsection

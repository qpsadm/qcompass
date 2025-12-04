@extends('layouts.f_layout')

@section('title', '最新のアジェンダ一覧')

@section('main-content')
<div class="container">
    <x-f_page_title
        title="最新のアジェンダ一覧{{ ($selectedCategoryId !== null && $selectedCategoryName) ? '：' . $selectedCategoryName : '' }}"
        :search="true"
        :searchAction="route('user.agenda.agendas_list')"
        searchName="search"
        searchPlaceholder="アジェンダを検索" />

    <x-f_category_accordion
        :categories="$categories"
        :selectedCategoryId="$selectedCategoryId" />

    <div class="content-list">
        <table>
            @forelse ($agendas as $agenda)
            <tr>
                <td class="date">{{ \Carbon\Carbon::parse($agenda->created_at)->format('Y/m/d') }}</td>
                <td class="title">
                    <a href="{{ route('user.agenda.info', ['id' => $agenda->id]) }}">
                        {{ $agenda->agenda_name }}
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center text-gray-500 py-4">
                    該当するアジェンダはありません
                </td>
            </tr>
            @endforelse
        </table>
    </div>

    <x-f_pagination :paginator="$agendas" />
    <x-f_bread_crumbs />
</div>
@endsection

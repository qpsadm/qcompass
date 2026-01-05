@php
$routeName = request()->route()->getName();
$agenda = request()->route('agenda'); // ← Model Binding
@endphp

<div class="bread-crumbs">
    @if ($routeName === 'user.agenda.info' && $agenda)

    @if ($agenda->category_id == 52)
    {{ Breadcrumbs::render('auto', '求人詳細') }}

    @elseif ($agenda->category_id == 53)
    {{ Breadcrumbs::render('auto', 'ダウンロード詳細') }}

    @else
    {{ Breadcrumbs::render('auto', $agenda->agenda_name) }}
    @endif

    @else
    {{ Breadcrumbs::render('auto', $breadcrumbTitle ?? null) }}
    @endif
</div>

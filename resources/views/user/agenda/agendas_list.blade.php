@extends('layouts.f_layout')

@section('main-content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">自分の講座アジェンダ一覧</h1>

        @if ($agendasByCategory->isEmpty())
            <p>表示できるアジェンダはありません。</p>
        @else
            @foreach ($agendasByCategory as $categoryId => $agendas)
                {{-- <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">カテゴリーID: {{ $categoryId }}</h2>
                    <ul class="list-disc ml-5">
                        @foreach ($agendas as $agenda)
                            <li>
                                <a href="{{ route('user.agenda.detail', ['id' => $agenda->id]) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $agenda->agenda_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}
            @endforeach
        @endif
    </div>
@endsection
@extends('layouts.f_layout')

@section('main-content')
    <div class="container">
        <x-f_page_title :search="true" title="新着情報一覧" />
        <x-f_category_list />

        <x-f_content_list :items="$agendasByCategory" />

        <x-f_pagination />
        <x-f_bread_crumbs />
    </div>
@endsection

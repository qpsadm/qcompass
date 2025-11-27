@extends('layouts.f_layout')

@section('main-content')
    <div class="container">
        <x-f_page_title :search="true" title="最新のアジェンダ一覧" />

        {{-- <x-f_category_accordion /> --}}

        @empty($agendas)
        @else
            @foreach ($agendas as $categoryId => $agenda)
                <div class="content-list">
                    <table>
                        {{-- @foreach ($agenda as $item) --}}
                        <tr>
                            {{-- <td class="date">{{ $agenda->created_at }}</td> --}}
                            <td class="date">{{ \Carbon\Carbon::parse($agenda->created_at)->format('Y/m/d') }}</td>

                            <td class="title">
                                <a href="{{ route('user.agenda.info', ['id' => $agenda->id]) }}">
                                    {{ $agenda->agenda_name }}
                                </a>
                            </td>
                        </tr>
                        {{-- @endforeach --}}
                    </table>
                </div>
            @endforeach
        @endempty

        <x-f_pagination />
        <x-f_bread_crumbs />
    </div>
@endsection

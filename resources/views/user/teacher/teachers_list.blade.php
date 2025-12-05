@extends('layouts.f_layout')

@section('title', '講師一覧')

@section('code-page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/f_course.css') }}">
@endsection

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="講師一覧" />


        <div class="teacher-list">
            @if ($teachers->isEmpty())
                <p class="text-gray-500 mt-4">あなたの講座に担当の先生はいません。</p>
            @else
                <ul>
                    @foreach ($teachers as $index => $teacher)
                        {{-- 連番 --}}
                        {{-- <span class="absolute top-2 left-2 text-sm text-gray-500">
                        {{ ($teachers->currentPage() - 1) * $teachers->perPage() + $index + 1 }}
                    </span> --}}
                        <li>
                            <a href="{{ route('user.teacher.teachers_info', $teacher->id) }}">
                                <p>{{ $teacher->name }}（{{ $teacher->furigana }}）先生</p>
                                {{-- <div class="text-sm text-gray-600 mt-1">
                            所属：{{ $teacher->division->name ?? '未設定' }}
                        </div> --}}
                            </a>
                        </li>
                    @endforeach
                </ul>
                {{-- ページネーション --}}
                <div class="mt-6">
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>

        <x-f_btn_list :prevBtn="false" :listBtn="true" :nextBtn="false" listUrl="{{ route('user.top') }}"
            listLabel="トップへもどる" />

        <x-f_bread_crumbs />

    </div>
@endsection

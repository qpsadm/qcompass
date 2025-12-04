@extends('layouts.f_layout')

@section('title', '講師一覧')

@section('main-content')
    <div class="container">

        <x-f_page_title :search="false" title="講師一覧" />

        @if ($teachers->isEmpty())
            <p class="text-gray-500 mt-4">あなたの講座に担当の先生はいません。</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                @foreach ($teachers as $index => $teacher)
                    <div class="bg-white border rounded-lg shadow p-4 hover:shadow-lg transition relative">
                        {{-- 連番 --}}
                        <span class="absolute top-2 left-2 text-sm text-gray-500">
                            {{ ($teachers->currentPage() - 1) * $teachers->perPage() + $index + 1 }}
                        </span>

                        <a href="{{ route('user.teacher.teachers_info', $teacher->id) }}">
                            <div class="text-lg font-semibold text-gray-800">{{ $teacher->name }}</div>
                            <div class="text-sm text-gray-600 mt-1">
                                所属：{{ $teacher->division->name ?? '未設定' }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            <div class="mt-6">
                {{ $teachers->links() }}
            </div>
        @endif

    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">管理者ダッシュボード</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- 開催中の講座 --}}
        <div class="bg-white shadow rounded p-5">
            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <img src="{{ asset('assets/images/icon/b_course.svg') }}" class="w-4 h-4 mr-2">
                開催中の講座
            </h2>

            @if($ongoingCourses->isEmpty())
            <p class="text-gray-500">現在開催中の講座はありません。</p>
            @else
            <ul class="space-y-2">
                @foreach($ongoingCourses as $course)
                <li class="border-b pb-2">
                    <div class="font-medium">{{ $course->course_name }}</div>
                    <div class="text-sm text-gray-500">
                        {{ $course->start_date }} 〜 {{ $course->end_date }}
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        {{-- 最新アジェンダ --}}
        <div class="bg-white shadow rounded p-5">
            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4 mr-2">
                最新アジェンダ
            </h2>

            @if($latestAgendas->isEmpty())
            <p class="text-gray-500">アジェンダはありません。</p>
            @else
            <ul class="space-y-2">
                @foreach($latestAgendas as $agenda)
                <li class="border-b pb-2">
                    <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="font-medium text-blue-600 hover:underline">
                        {{ $agenda->agenda_name }}
                    </a>
                    <div class="text-sm text-gray-500">{{ $agenda->created_at->format('Y-m-d') }}</div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        {{-- 最新お知らせ --}}
        <div class="bg-white shadow rounded p-5">
            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <img src="{{ asset('assets/images/icon/b_information.svg') }}" class="w-4 h-4 mr-2">
                最新のお知らせ
            </h2>

            @if($latestAnnouncements->isEmpty())
            <p class="text-gray-500">お知らせはありません。</p>
            @else
            <ul class="space-y-2">
                @foreach($latestAnnouncements as $ann)
                <li class="border-b pb-2">
                    <a href="{{ route('admin.announcements.show', $ann->id) }}" class="font-medium text-blue-600 hover:underline">
                        {{ $ann->title }}
                    </a>
                    <div class="text-sm text-gray-500">{{ $ann->created_at->format('Y-m-d') }}</div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        {{-- 最新日報 --}}
        {{-- 最新日報 --}}
        <div class="bg-white shadow rounded p-5">
            <h2 class="text-lg font-semibold mb-3 flex items-center">
                <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4 mr-2">
                最新日報
            </h2>

            @if($latestReports->isEmpty())
            <p class="text-gray-500">日報はありません。</p>
            @else
            <ul class="space-y-2">
                @foreach($latestReports as $report)
                <li class="border-b pb-2">
                    <a href="{{ route('admin.reports.show', $report->id) }}" class="font-medium text-blue-600 hover:underline">
                        {{ $report->title }}
                    </a>
                    <div class="text-sm text-gray-500">
                        {{ $report->created_at->format('Y-m-d') }} - {{ $report->user->name ?? '不明' }}
                        @if($report->course)
                        <span class="ml-2 text-gray-400">({{ $report->course->course_name }})</span>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>


    </div>
</div>
@endsection

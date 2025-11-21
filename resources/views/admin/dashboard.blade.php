@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">管理者ダッシュボード</h1>

    <div class="bg-white shadow rounded p-4 mt-4">
        <h2 class="font-semibold text-lg mb-2">開催中の講座</h2>
        @if($ongoingCourses->isEmpty())
        <p class="text-gray-500">現在開催中の講座はありません。</p>
        @else
        <ul class="list-disc list-inside">
            @foreach($ongoingCourses as $course)
            <li>
                <span class="font-medium">{{ $course->course_name }}</span>
                <span class="text-gray-500 text-sm">({{ $course->start_date }} 〜 {{ $course->end_date }})</span>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    <!-- 最新情報セクション -->
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold text-lg mb-2">最新のお知らせ</h2>
        @if($latestAnnouncements->isEmpty())
        <p class="text-gray-500">お知らせはありません。</p>
        @else
        <ul class="list-disc list-inside">
            @foreach($latestAnnouncements as $announcement)
            <li>
                <a href="{{ route('admin.announcements.show', $announcement->id) }}"
                    class="font-medium text-blue-600 hover:underline">
                    {{ $announcement->title }}
                </a>
                <span class="text-gray-500 text-sm">
                    ({{ $announcement->created_at->format('Y-m-d') }})
                </span>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
    <!-- 最新アジェンダセクション -->
    <div class="bg-white shadow rounded p-4 mt-4">
        <h2 class="font-semibold text-lg mb-2">最新のアジェンダ</h2>
        @if($latestAgendas->isEmpty())
        <p class="text-gray-500">アジェンダはありません。</p>
        @else
        <ul class="list-disc list-inside">
            @foreach($latestAgendas as $agenda)
            <li>
                <a href="{{ route('admin.agendas.show', $agenda->id) }}"
                    class="font-medium text-blue-600 hover:underline">
                    {{ $agenda->title }}
                </a>
                <span class="text-gray-500 text-sm">
                    ({{ $agenda->created_at->format('Y-m-d') }})
                </span>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

</div>
@endsection

@extends('layouts.app')

@section('content')
    {{-- <div class="container py-6 max-w-5xl"> --}}
    <div class="container p-6 bg-white rounded-lg shadow-md max-w-5xl">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">ダッシュボード
            <span class="text-gray-500 text-lg ml-4">({{ date('Y年n月j日', strtotime($today)) }})</span>
        </h1>

        <div class="dashboard grid grid-cols-1 gap-4">

            {{-- 最新お知らせ --}}
            <div class="bg-white border border-gray-400 rounded-md">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center border-b border-gray-400 p-4">
                    <img src="{{ asset('assets/images/icon/b_information.svg') }}" class="w-4 h-4 mr-2">
                    最新のお知らせ
                </h2>

                @if ($latestAnnouncements->isEmpty())
                    <p class="text-gray-500 p-6">お知らせはありません。</p>
                @else
                    <ul class="space-y-2 p-6 pb-0">
                        @foreach ($latestAnnouncements as $ann)
                            <li class="flex flex-row gap-2 pb-0 items-center">
                                <div class="text-sm text-gray-500">{{ $ann->updated_at->format('Y-m-d H:i') }}</div>
                                <a href="{{ route('admin.announcements.show', $ann->id) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ $ann->title }}</a>
                                <span class="text-sm text-gray-500 ml-4">
                                    【&nbsp;カテゴリー：{{ $ann->type->type_name }}、対象：
                                    {{ $ann->course_id ? $ann->course->course_name : '全体向け' }}&nbsp;】
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 text-right pt-1 p-6">
                        <a href="{{ route('admin.announcements.index') }}"
                            class="text-blue-600 hover:underline font-medium">
                            もっと見る &rarr;
                        </a>
                    </div>
                @endif
            </div>

            {{-- 開催中の講座 --}}
            <div class="bg-white border border-gray-400 rounded-md">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center border-b border-gray-400 p-4">
                    <img src="{{ asset('assets/images/icon/b_course.svg') }}" class="w-4 h-4 mr-2">
                    開催中の講座
                </h2>

                @if ($ongoingCourses->isEmpty())
                    <p class="text-gray-500 p-6">現在開催中の講座はありません。</p>
                @else
                    <ul class="space-y-2 p-6 pb-0">
                        @foreach ($ongoingCourses as $course)
                            <li class="flex flex-row gap-2 pb-0 items-center">
                                <div class="text-sm text-gray-500">{{ $course->created_at->format('Y-m-d H:i') }}</div>
                                <a href="{{ route('admin.courses.show', $course->id) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ $course->course_name }}
                                </a>
                                <div class="text-sm text-gray-500 ml-4">
                                    【&nbsp;期間：{{ $course->start_date }} 〜
                                    {{ $course->end_date }}、入校人数：{{ $course->entering }}&nbsp;】
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 text-right pt-1 p-6">
                        <a href="{{ route('admin.courses.index') }}" class="text-blue-600 hover:underline font-medium">
                            もっと見る &rarr;
                        </a>
                    </div>
                @endif
            </div>

            {{-- 最新アジェンダ --}}
            <div class="bg-white border border-gray-400 rounded-md">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center border-b border-gray-400 p-4">
                    <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4 mr-2">
                    最新アジェンダ
                </h2>

                @if ($latestAgendas->isEmpty())
                    <p class="text-gray-500 p-6">アジェンダはありません。</p>
                @else
                    <ul class="space-y-2 p-6 pb-0">
                        @foreach ($latestAgendas as $agenda)
                            <li class="flex flex-row gap-2 pb-0 items-center">
                                <div class="text-sm text-gray-500">{{ $agenda->updated_at->format('Y-m-d H:i') }}</div>
                                <a href="{{ route('admin.agendas.show', $agenda->id) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ $agenda->agenda_name }}
                                </a>
                                <span
                                    class="text-sm text-gray-500 ml-4">【&nbsp;カテゴリー：{{ $agenda->category->name }}&nbsp;】</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 text-right p-6 pt-1">
                        <a href="{{ route('admin.agendas.index') }}"
                            class="more text-blue-600 hover:underline font-medium">
                            もっと見る &rarr;
                        </a>
                    </div>
                @endif
            </div>

            {{-- 最新日報 --}}
            <div class="bg-white border border-gray-400 rounded-md">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center border-b border-gray-400 p-4">
                    <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4 mr-2">
                    最新日報
                </h2>

                @if ($latestReports->isEmpty())
                    <p class="text-gray-500 p-6">日報はありません。</p>
                @else
                    <ul class="space-y-2 p-6 pb-0">
                        @foreach ($latestReports as $report)
                            <li class="flex flex-row gap-2 pb-0 items-center">
                                <div class="text-sm text-gray-500">
                                    {{ $report->created_at->format('Y-m-d H:i') }}
                                    {{-- @if ($report->course)
                                        <span class="ml-2 text-gray-400">({{ $report->course->course_name }})</span>
                                    @endif --}}
                                </div>
                                <a href="{{ route('admin.reports.show', $report->id) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ $report->title }} 【{{ $report->user->name ?? '氏名不明' }}】
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 text-right pt-1 p-6">
                        <a href="{{ route('admin.reports.index') }}?course_id={{ $selectedCourseId }}"
                            class="text-blue-600 hover:underline font-medium">
                            もっと見る &rarr;
                        </a>
                    </div>
                @endif
            </div>

            {{-- 受講者一覧 --}}
            <div class="bg-white border border-gray-400 rounded-md">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center border-b border-gray-400 p-4">
                    <img src="{{ asset('assets/images/icon/b_course.svg') }}" class="w-4 h-4 mr-2">
                    受講者一覧 <span class="text-gray-600 px-4">({{ count($users) }}人)</span>
                </h2>

                @if ($users->isEmpty())
                    <p class="text-gray-500 p-6">受講者は登録されていません。</p>
                @else
                    <ul class="space-y-2 p-6 pb-0">
                        @forelse ($users as $user)
                            <li class="flex flex-row items-center gap-2 pb-0">
                                <!-- 作成日時 -->
                                <div class="text-sm text-gray-500">
                                    {{ $user->created_at?->format('Y-m-d H:i') }}
                                </div>

                                <!-- ユーザー名（詳細リンク） -->
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ $user->name }}
                                </a>

                                <!-- 詳細情報（Nullsafe 演算子で安全化） -->
                                <div class="text-sm ml-4 text-gray-500">
                                    【&nbsp;電話：{{ $user->detail?->phone1 ?? '電話番号未登録' }}、
                                    所属：{{ $user->division?->name ?? '所属なし' }}&nbsp;】
                                    <span class="text-red-500 font-bold">
                                        {{-- 日付が正しく入っているかチェック（1900年以降等の判定） --}}
                                        {{ $user->detail?->leaving_date && \Carbon\Carbon::parse($user->detail->leaving_date)->year > 1900
                                            ? '※' . $user->detail->leaving_date->format('Y-m-d') . ' 退校'
                                            : '' }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 py-2">
                                該当する受講者はいません。
                            </li>
                        @endforelse
                    </ul>
                    <div class="mt-3 text-right pt-1 p-6">
                        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline font-medium">
                            もっと見る &rarr;
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

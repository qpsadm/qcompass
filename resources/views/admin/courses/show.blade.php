@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">講座詳細</h1>

        <table class="table-auto border-collapse border w-full mb-4">
            <tbody>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium w-1/4">講座コード</td>
                    <td class="border px-4 py-2">{{ $Course->course_code }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">講座分野</td>
                    <td class="border px-4 py-2">{{ $Course->course_type_ID }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">講座種類</td>
                    <td class="border px-4 py-2">{{ $Course->Level_id }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">主催者</td>
                    <td class="border px-4 py-2">{{ $Course->organizer_id }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">講座名</td>
                    <td class="border px-4 py-2">{{ $Course->course_name }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">実施会場</td>
                    <td class="border px-4 py-2">{{ $Course->venue }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">申請日</td>
                    <td class="border px-4 py-2">
                        {{ $Course->application_date ? \Carbon\Carbon::parse($Course->application_date)->format('Y-m-d') : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">認定日</td>
                    <td class="border px-4 py-2">
                        {{ $Course->certification_date ? \Carbon\Carbon::parse($Course->certification_date)->format('Y-m-d') : '' }}
                    </td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">認定番号</td>
                    <td class="border px-4 py-2">{{ $Course->certification_number }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">開始日</td>
                    <td class="border px-4 py-2">
                        {{ $Course->start_date ? \Carbon\Carbon::parse($Course->start_date)->format('Y-m-d') : '' }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">終了日</td>
                    <td class="border px-4 py-2">
                        {{ $Course->end_date ? \Carbon\Carbon::parse($Course->end_date)->format('Y-m-d') : '' }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">総授業時間</td>
                    <td class="border px-4 py-2">{{ $Course->total_hours }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">時限数</td>
                    <td class="border px-4 py-2">{{ $Course->periods }}</td>
                </tr>

                <tr>
                    <td class="border px-4 py-2 font-medium">開始時刻</td>
                    <td class="border px-4 py-2">{{ $Course->start_time }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">終了時刻</td>
                    <td class="border px-4 py-2">{{ $Course->finish_time }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">閲覧開始日</td>
                    <td class="border px-4 py-2">
                        {{ $Course->start_viewing ? \Carbon\Carbon::parse($Course->start_viewing)->format('Y-m-d') : '' }}
                    </td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">閲覧終了日</td>
                    <td class="border px-4 py-2">
                        {{ $Course->finish_viewing ? \Carbon\Carbon::parse($Course->finish_viewing)->format('Y-m-d') : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">日別計画書パス</td>
                    <td class="border px-4 py-2">{{ $Course->plan_path }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">チラシパス</td>
                    <td class="border px-4 py-2">{{ $Course->flier_path }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">定員</td>
                    <td class="border px-4 py-2">{{ $Course->capacity }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">入校者数</td>
                    <td class="border px-4 py-2">{{ $Course->entering }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">修了者数</td>
                    <td class="border px-4 py-2">{{ $Course->completed }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td class="border px-4 py-2 font-medium">概要・説明</td>
                    <td class="border px-4 py-2">{{ $Course->description }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2 font-medium">状態</td>
                    <td class="border px-4 py-2">{{ $Course->status }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex gap-2 mb-8">
            <a href="{{ route('admin.courses.edit', $Course->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.courses.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
        </div>
    </div>
@endsection

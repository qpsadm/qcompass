@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-3xl font-bold mb-6">
            講座詳細：{{ $course->course_name }}
            <span class="text-sm text-gray-500">
                （全 {{ $total }} 件中 {{ $position }} 件目）
            </span>
        </h1>
        {{-- 講座詳細テーブル --}}
        <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <tbody>
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座コード</th>
                        <td class="px-4 py-2">{{ $course->course_code }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">講座分野</th>
                        <td class="px-4 py-2">{{ $course->courseType->name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">講座種類</th>
                        <td class="px-4 py-2">{{ $course->level->name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">主催者</th>
                        <td class="px-4 py-2">{{ $course->organizer->name ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">講座名</th>
                        <td class="px-4 py-2">{{ $course->course_name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">実施会場</th>
                        <td class="px-4 py-2">{{ $course->venue }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">申請日</th>
                        <td class="px-4 py-2">
                            {{ $course->application_date ? \Carbon\Carbon::parse($course->application_date)->format('Y-m-d') : '-' }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">認定日</th>
                        <td class="px-4 py-2">
                            {{ $course->certification_date ? \Carbon\Carbon::parse($course->certification_date)->format('Y-m-d') : '-' }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">認定番号</th>
                        <td class="px-4 py-2">{{ $course->certification_number ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">期間</th>
                        <td class="px-4 py-2">
                            {{ $course->start_date ?? '-' }} 〜 {{ $course->end_date ?? '-' }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">時間</th>
                        <td class="px-4 py-2">
                            {{ $course->start_time ?? '-' }} 〜 {{ $course->finish_time ?? '-' }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">総授業時間 / 時限数</th>
                        <td class="px-4 py-2">
                            {{ $course->total_hours ?? '-' }} / {{ $course->periods ?? '-' }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">閲覧期間</th>
                        <td class="px-4 py-2">
                            {{ $course->start_viewing ? \Carbon\Carbon::parse($course->start_viewing)->format('Y-m-d') : '-' }}
                            〜
                            {{ $course->finish_viewing ? \Carbon\Carbon::parse($course->finish_viewing)->format('Y-m-d') : '-' }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">日別計画書</th>
                        <td class="px-4 py-2">
                            @if ($course->plan_path)
                                <a href="{{ asset('storage/' . $course->plan_path) }}" target="_blank"
                                    class="text-blue-500 underline">ファイルを確認</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">フライヤー</th>
                        <td class="px-4 py-2">
                            @if ($course->flier_path)
                                <a href="{{ asset('storage/' . $course->flier_path) }}" target="_blank"
                                    class="text-blue-500 underline">ファイルを確認</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">定員 / 入校者 / 修了者</th>
                        <td class="px-4 py-2">{{ $course->capacity ?? '-' }} / {{ $course->entering ?? '-' }} /
                            {{ $course->completed ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">日報送信先</th>
                        <td class="px-4 py-2">{{ $course->mail_address ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">CC</th>
                        <td class="px-4 py-2">{{ $course->cc_address ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">表示</th>
                        <td class="px-4 py-2">{{ $course->is_show ? '表示' : '非表示' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">概要・説明</th>
                        <td class="px-4 py-2">{{ $course->description ?? '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">状態</th>
                        <td class="px-4 py-2">{{ \App\Models\Course::STATUS[(int) $course->status] ?? '不明' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ボタン --}}
        <div class="flex gap-2 mt-6">
            <a href="{{ route('admin.courses.edit', $course->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                編集
            </a>
            <a href="{{ route('admin.courses.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                一覧に戻る
            </a>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Course作成</h1>
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            @php
                $fields = [
                    ['name' => 'course_code', 'label' => '講座コード', 'type' => 'text'],
                    [
                        'name' => 'course_type_ID',
                        'label' => '講座分野',
                        'type' => 'select',
                        'options' => [1 => 'IT', 2 => 'ビジネス', 3 => '語学'],
                    ],
                    [
                        'name' => 'Level_id',
                        'label' => '講座種類',
                        'type' => 'select',
                        'options' => [1 => '初級', 2 => '中級', 3 => '上級'],
                    ],
                    ['name' => 'organizer_id', 'label' => '実施主体（主催者名）', 'type' => 'text'],
                    ['name' => 'course_name', 'label' => '講座名', 'type' => 'text'],
                    ['name' => 'venue', 'label' => '実施会場', 'type' => 'text'],
                    ['name' => 'application_date', 'label' => '申請日', 'type' => 'date'],
                    ['name' => 'certification_date', 'label' => '認定日', 'type' => 'date'],
                    ['name' => 'certification_number', 'label' => '認定番号', 'type' => 'text'],
                    ['name' => 'start_date', 'label' => '開始日', 'type' => 'date'],
                    ['name' => 'end_date', 'label' => '終了日', 'type' => 'date'],
                    ['name' => 'total_hours', 'label' => '総授業時間', 'type' => 'text'],
                    ['name' => 'periods', 'label' => '時限数', 'type' => 'text'],
                    ['name' => 'start_time', 'label' => '開始時間', 'type' => 'time'],
                    ['name' => 'finish_time', 'label' => '終了時間', 'type' => 'time'],
                    ['name' => 'start_viewing', 'label' => '閲覧期間開始', 'type' => 'date'],
                    ['name' => 'finish_viewing', 'label' => '閲覧期間終了', 'type' => 'date'],
                    ['name' => 'plan_path', 'label' => '日別計画書のパス', 'type' => 'text'],
                    ['name' => 'flier_path', 'label' => 'フライヤーのパス', 'type' => 'text'],
                    ['name' => 'capacity', 'label' => '定員数', 'type' => 'text'],
                    ['name' => 'entering', 'label' => '入校数', 'type' => 'text'],
                    ['name' => 'completed', 'label' => '修了数', 'type' => 'text'],
                    ['name' => 'description', 'label' => '概要・説明', 'type' => 'text'],
                    ['name' => 'status', 'label' => '状態', 'type' => 'text'],
                    ['name' => 'created_user_id', 'label' => '作成者名', 'type' => 'text'],
                ];
            @endphp

            @foreach ($fields as $field)
                <div class="mb-4">
                    <label class="block font-medium mb-1">{{ $field['label'] }}</label>

                    @if ($field['type'] === 'text' || $field['type'] === 'date' || $field['type'] === 'time')
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                            value="{{ old($field['name'], $Course->{$field['name']} ?? '') }}"
                            class="border px-2 py-1 md:w-1/2 rounded">
                    @elseif($field['type'] === 'select')
                        <select name="{{ $field['name'] }}" class="border px-2 py-1 md:w-1/2 rounded">
                            @foreach ($field['options'] as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old($field['name'], $Course->{$field['name']} ?? '') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endforeach


            <div class="flex gap-2 mb-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
                <a href="{{ route('admin.courses.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">一覧に戻る</a>
            </div>
        </form>
    </div>
@endsection

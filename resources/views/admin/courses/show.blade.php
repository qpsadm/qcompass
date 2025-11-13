@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Course詳細</h1>
    <div class="border p-4 rounded mb-4">
        <p><strong>course_code:</strong> {{ $Course->course_code }}</p>
        <p><strong>course_type_ID:</strong> {{ $Course->course_type_ID }}</p>
        <p><strong>Level_id:</strong> {{ $Course->Level_id }}</p>
        <p><strong>organizer_id:</strong> {{ $Course->organizer_id }}</p>
        <p><strong>course_name:</strong> {{ $Course->course_name }}</p>
        <p><strong>venue:</strong> {{ $Course->venue }}</p>
        <p><strong>application_date:</strong> {{ $Course->application_date }}</p>
        <p><strong>certification_date:</strong> {{ $Course->certification_date }}</p>
        <p><strong>certification_number:</strong> {{ $Course->certification_number }}</p>
        <p><strong>start_date:</strong> {{ $Course->start_date }}</p>
        <p><strong>end_date:</strong> {{ $Course->end_date }}</p>
        <p><strong>total_hours:</strong> {{ $Course->total_hours }}</p>
        <p><strong>periods:</strong> {{ $Course->periods }}</p>
        <p><strong>start_time:</strong> {{ $Course->start_time }}</p>
        <p><strong>finish_time:</strong> {{ $Course->finish_time }}</p>
        <p><strong>start_viewing:</strong> {{ $Course->start_viewing }}</p>
        <p><strong>finish_viewing:</strong> {{ $Course->finish_viewing }}</p>
        <p><strong>plan_path:</strong> {{ $Course->plan_path }}</p>
        <p><strong>flier_path:</strong> {{ $Course->flier_path }}</p>
        <p><strong>capacity:</strong> {{ $Course->capacity }}</p>
        <p><strong>entering:</strong> {{ $Course->entering }}</p>
        <p><strong>completed:</strong> {{ $Course->completed }}</p>
        <p><strong>description:</strong> {{ $Course->description }}</p>
        <p><strong>status:</strong> {{ $Course->status }}</p>
        <p><strong>created_user_id:</strong> {{ $Course->created_user_id }}</p>
        <p><strong>updated_user_id:</strong> {{ $Course->updated_user_id }}</p>
        <p><strong>deleted_at:</strong> {{ $Course->deleted_at }}</p>
        <p><strong>deleted_user_id:</strong> {{ $Course->deleted_user_id }}</p>

    </div>
    <a href="{{ route('admin.courses.edit', $Course->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
    <a href="{{ route('admin.courses.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Course作成</h1>
    <form action="{{ route('admin.courses.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1">course_code</label>
            <input type="text" name="course_code" value="{{ old('course_code', $Course->course_code ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">course_type_ID</label>
            <input type="text" name="course_type_ID" value="{{ old('course_type_ID', $Course->course_type_ID ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">Level_id</label>
            <input type="text" name="Level_id" value="{{ old('Level_id', $Course->Level_id ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">organizer_id</label>
            <input type="text" name="organizer_id" value="{{ old('organizer_id', $Course->organizer_id ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">course_name</label>
            <input type="text" name="course_name" value="{{ old('course_name', $Course->course_name ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">venue</label>
            <input type="text" name="venue" value="{{ old('venue', $Course->venue ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">application_date</label>
            <input type="text" name="application_date" value="{{ old('application_date', $Course->application_date ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">certification_date</label>
            <input type="text" name="certification_date" value="{{ old('certification_date', $Course->certification_date ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">certification_number</label>
            <input type="text" name="certification_number" value="{{ old('certification_number', $Course->certification_number ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">start_date</label>
            <input type="text" name="start_date" value="{{ old('start_date', $Course->start_date ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">end_date</label>
            <input type="text" name="end_date" value="{{ old('end_date', $Course->end_date ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">total_hours</label>
            <input type="text" name="total_hours" value="{{ old('total_hours', $Course->total_hours ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">periods</label>
            <input type="text" name="periods" value="{{ old('periods', $Course->periods ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">start_time</label>
            <input type="text" name="start_time" value="{{ old('start_time', $Course->start_time ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">finish_time</label>
            <input type="text" name="finish_time" value="{{ old('finish_time', $Course->finish_time ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">start_viewing</label>
            <input type="text" name="start_viewing" value="{{ old('start_viewing', $Course->start_viewing ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">finish_viewing</label>
            <input type="text" name="finish_viewing" value="{{ old('finish_viewing', $Course->finish_viewing ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">plan_path</label>
            <input type="text" name="plan_path" value="{{ old('plan_path', $Course->plan_path ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">flier_path</label>
            <input type="text" name="flier_path" value="{{ old('flier_path', $Course->flier_path ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">capacity</label>
            <input type="text" name="capacity" value="{{ old('capacity', $Course->capacity ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">entering</label>
            <input type="text" name="entering" value="{{ old('entering', $Course->entering ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">completed</label>
            <input type="text" name="completed" value="{{ old('completed', $Course->completed ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">description</label>
            <input type="text" name="description" value="{{ old('description', $Course->description ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">status</label>
            <input type="text" name="status" value="{{ old('status', $Course->status ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">created_user_id</label>
            <input type="text" name="created_user_id" value="{{ old('created_user_id', $Course->created_user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">updated_user_id</label>
            <input type="text" name="updated_user_id" value="{{ old('updated_user_id', $Course->updated_user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">deleted_at</label>
            <input type="text" name="deleted_at" value="{{ old('deleted_at', $Course->deleted_at ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">deleted_user_id</label>
            <input type="text" name="deleted_user_id" value="{{ old('deleted_user_id', $Course->deleted_user_id ?? '') }}" class="border px-2 py-1 w-full rounded">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
    </form>
</div>
@endsection

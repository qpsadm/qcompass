@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座アジェンダ作成</h1>
            <form action="{{ route('course_agendas.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium mb-1">講座ID</label>
                    <input type="text" name="course_id" value="{{ old('course_id', $CourseAgenda->course_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">アジェンダID</label>
                    <input type="text" name="target_id" value="{{ old('target_id', $CourseAgenda->target_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">並び順</label>
                    <input type="text" name="order_no" value="{{ old('order_no', $CourseAgenda->order_no ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">備考</label>
                    <input type="text" name="note" value="{{ old('note', $CourseAgenda->note ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">削除日</label>
                    <input type="text" name="deleted_at" value="{{ old('deleted_at', $CourseAgenda->deleted_at ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
            </form>
        </div>
    @endsection

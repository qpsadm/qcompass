@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">講座アジェンダ編集</h1>
        <form action="{{ route('course_agendas.update', $CourseAgenda->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">講座ID</label>
                <input type="text" name="course_id" value="{{ old('course_id', $CourseAgenda->course_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">アジェンダID</label>
                <input type="text" name="agenda_id" value="{{ old('agenda_id', $CourseAgenda->agenda_id ?? '') }}"
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

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection

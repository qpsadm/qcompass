@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">日報作成</h1>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reports.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label>講座</label>
                <select name="course_id" class="border p-1 w-full">
                    @foreach (\App\Models\Course::all() as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>日報対象日</label>
                <input type="date" name="date" class="border p-1 w-full">
            </div>
            <div class="mb-2">
                <label>タイトル</label>
                <input type="text" name="title" class="border p-1 w-full">
            </div>
            <div class="mb-2">
                <label>日報内容</label>
                <textarea name="content" class="border p-1 w-full"></textarea>
            </div>
            <div class="mb-2">
                <label>感想・気付き・質問</label>
                <textarea name="impression" class="border p-1 w-full"></textarea>
            </div>
            <div class="mb-2">
                <label>連絡事項</label>
                <textarea name="notice" class="border p-1 w-full"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">登録</button>
        </form>
    </div>
@endsection

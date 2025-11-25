@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座分野詳細</h1>

            <div class="border p-4 rounded mb-4 space-y-2">
                <p><strong>名前:</strong> {{ $CourseType->name }}</p>
                <p><strong>実施団体:</strong> {{ $CourseType->organizer->name ?? '-' }}</p>
                <p><strong>表示:</strong>
                    @if ($CourseType->is_show)
                        表示
                    @else
                        非表示
                    @endif
                </p>
            </div>

            <a href="{{ route('admin.course_type.edit', $CourseType->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
            <a href="{{ route('admin.course_type.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
        </div>
    </div>
@endsection

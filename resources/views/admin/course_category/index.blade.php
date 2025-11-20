@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座カテゴリ一覧</h1>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">講座ID</th>
                        <th class="border px-4 py-2">講座名</th>
                        <th class="border px-4 py-2">設定されているカテゴリ</th>
                        <th class="border px-4 py-2">操作</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($courses as $course)
                        <tr>
                            <td class="border px-4 py-2">{{ $course->id }}</td>
                            <td class="border px-4 py-2">{{ $course->course_name }}</td>

                            <td class="border px-4 py-2">
                                @if ($course->categories->count())
                                    {{ $course->categories->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-gray-500">カテゴリなし</span>
                                @endif
                            </td>

                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.course_category.create', $course->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded">
                                    カテゴリ設定
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

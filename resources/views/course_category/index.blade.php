@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">CourseCategory一覧</h1>
    <a href="{{ route('course_category.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>course_id</th>
<th class='border px-4 py-2'>category_id</th>
<th class='border px-4 py-2'>note</th>
<th class='border px-4 py-2'>is_show</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course_category as $CourseCategory)
            <tr>
                <td class='border px-4 py-2'>{{ $CourseCategory->course_id }}</td>
<td class='border px-4 py-2'>{{ $CourseCategory->category_id }}</td>
<td class='border px-4 py-2'>{{ $CourseCategory->note }}</td>
<td class='border px-4 py-2'>{{ $CourseCategory->is_show }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('course_category.show', $CourseCategory->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('course_category.edit', $CourseCategory->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('course_category.destroy', $CourseCategory->id) }}" method="POST" class="inline-block ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
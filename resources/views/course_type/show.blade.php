@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">講座分野詳細</h1>

        <div class="bg-white rounded-lg shadow-md p-6">

            {{-- 詳細情報のブロック (元々あったborderを維持) --}}
            <div class="border p-4 rounded mb-4">
                <p><strong>講座名:</strong> {{ $CourseType->name }}</p>
                {{-- 必要に応じて他の詳細情報をここに追加できます --}}
            </div>

            {{-- ボタン --}}
            <div class="flex gap-2">
                <a href="{{ route('course_type.edit', $CourseType->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">編集</a>
                <a href="{{ route('course_type.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">一覧に戻る</a>
            </div>

        </div>
        </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">講座分野作成</h1>

            {{-- 🚨 バリデーションエラー表示 --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.course_type.store') }}" method="POST">
                @csrf

                {{-- 実施主体 --}}
                <div class="mb-4">
                    <label for="organizer_id" class="block font-medium mb-1">実施主体</label>
                    <select name="organizer_id" id="organizer_id"
                        class="border-gray-300 border px-2 py-1 w-[200px] rounded-md
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">選択してください</option>
                        @foreach ($organizers as $organizer)
                            <option value="{{ $organizer->id }}"
                                {{ old('organizer_id') == $organizer->id ? 'selected' : '' }}>
                                {{ $organizer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 名前 --}}
                <div class="mb-4">
                    <label for="name" class="block font-medium mb-1">名前</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="border-gray-300 border px-2 py-1 w-[300px] rounded-md
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">表示フラグ</label>
                    <input type="checkbox" name="is_show" value="1" {{ old('is_show', 1) ? 'checked' : '' }}>
                    表示
                </div>

                {{-- ボタン --}}
                <div class="flex gap-2 mt-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                        保存
                    </button>
                    <a href="{{ route('admin.course_type.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                        一覧に戻る
                    </a>
                </div>
            </form>

        </div>
    </div>
@endsection

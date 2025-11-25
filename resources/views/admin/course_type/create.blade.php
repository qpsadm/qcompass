@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">講座分野作成</h1>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.course_type.store') }}" method="POST">
                @csrf
                <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-md">
                    <tbody>
                        {{-- 実施主体 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                実施主体
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <select name="organizer_id" id="organizer_id"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">選択してください</option>
                                    @foreach ($organizers as $organizer)
                                        <option value="{{ $organizer->id }}"
                                            {{ old('organizer_id') == $organizer->id ? 'selected' : '' }}>
                                            {{ $organizer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organizer_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 名前 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                名前
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>

                        {{-- 表示フラグ --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示設定</th>
                            <td class="px-4 py-2">
                                <input type="checkbox" name="is_show" value="1"
                                    {{ old('is_show', 1) ? 'checked' : '' }} class="h-4 w-4">
                                <label class="font-semibold">表示する</label>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex gap-3 mt-6 justify-center">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded shadow-sm transition">
                        保存する
                    </button>
                    <a href="{{ route('admin.course_type.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow-sm transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

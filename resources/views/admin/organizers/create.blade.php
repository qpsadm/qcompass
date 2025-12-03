@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 min-h-screen">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">講座開催者作成</h1>

            {{-- バリデーションエラー --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.organizers.store') }}" method="POST">
                @csrf

                <table class="w-full table-auto border-collapse bg-white rounded-lg shadow-md">
                    <tbody>
                        {{-- 開催者名 --}}
                        <tr class="border-b">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                開催者名
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $Organizer->name ?? '') }}"
                                    class="border rounded px-3 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded shadow-sm transition">
                        保存する
                    </button>
                    <a href="{{ route('admin.organizers.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow-sm transition">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">実績編集</h1>

        {{-- バリデーションエラー --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.achievements.update', $Achievement->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- 実績名 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">実績名</th>
                        <td class="px-4 py-2">
                            <input type="text" name="title" value="{{ old('title', $Achievement->title ?? '') }}" class="border rounded px-3 py-2 w-full">
                            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 条件説明 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">条件説明</th>
                        <td class="px-4 py-2">
                            <input type="text" name="description" value="{{ old('description', $Achievement->description ?? '') }}" class="border rounded px-3 py-2 w-full">
                            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 達成条件タイプ --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">達成条件タイプ</th>
                        <td class="px-4 py-2">
                            <select name="condition_type" class="border rounded px-3 py-2 w-full">
                                @php
                                $types = ['attendance'=>'出席','score'=>'点数','report'=>'レポート','custom'=>'カスタム'];
                                @endphp
                                @foreach($types as $key => $label)
                                <option value="{{ $key }}" @selected(old('condition_type', $Achievement->condition_type ?? '') == $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('condition_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 条件値 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">条件値</th>
                        <td class="px-4 py-2">
                            <input type="text" name="condition_value" value="{{ old('condition_value', $Achievement->condition_value ?? '') }}" class="border rounded px-3 py-2 w-full">
                            @error('condition_value') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded shadow">更新</button>
                <a href="{{ route('admin.achievements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow">一覧に戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection

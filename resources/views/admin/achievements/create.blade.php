@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">{{ isset($Achievement->id) ? '実績編集' : '実績作成' }}</h1>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ isset($Achievement->id) ? route('admin.achievements.update', $Achievement->id) : route('admin.achievements.store') }}" method="POST">
            @csrf
            @if(isset($Achievement->id))
            @method('PUT')
            @endif

            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- 実績名 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                            実績名
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="title" value="{{ old('title', $Achievement->title ?? '') }}" class="border rounded px-3 py-2 w-full">
                            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 条件説明 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">条件説明</th>
                        <td class="px-4 py-2">
                            <textarea name="description" rows="3" class="border rounded px-3 py-2 w-full">{{ old('description', $Achievement->description ?? '') }}</textarea>
                            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 達成条件タイプ --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">達成条件タイプ</th>
                        <td class="px-4 py-2">
                            <select name="condition_type" class="border px-3 py-2 rounded w-full">
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
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded shadow">
                    {{ isset($Achievement->id) ? '更新' : '保存' }}
                </button>
                <a href="{{ route('admin.achievements.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow">
                    一覧に戻る
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

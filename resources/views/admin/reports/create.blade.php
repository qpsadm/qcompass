@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">日報作成</h1>

    <form id="reportForm" action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
        @csrf
        <table class="w-full table-auto border-collapse">
            <tbody>
                {{-- 講座 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">講座
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <select name="course_id" class="border rounded px-3 py-2 w-64">
                            <option value="">選択してください</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id', $courses->count() === 1 ? $courses->first()->id : null) == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 日付 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">日付
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <input type="date" name="date" value="{{ old('date') }}" class="border rounded px-3 py-2 w-64">
                        @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- タイトル --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">タイトル
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <input type="text" name="title" value="{{ old('title') }}" class="border rounded px-3 py-2 w-full">
                        @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 日報内容 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">日報内容
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <textarea name="content" rows="4" class="border rounded px-3 py-2 w-full">{{ old('content') }}</textarea>
                        @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 感想・気付き・質問 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">感想・気付き・質問
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">必須</span>
                    </th>
                    <td class="px-4 py-2">
                        <textarea name="impression" rows="3" class="border rounded px-3 py-2 w-full">{{ old('impression') }}</textarea>
                        @error('impression') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </td>
                </tr>

                {{-- 連絡事項 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">連絡事項</th>
                    <td class="px-4 py-2">
                        <textarea name="notice" rows="2" class="border rounded px-3 py-2 w-full">{{ old('notice') }}</textarea>
                        @error('notice') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded w-1/2">登録</button>
            <button type="button" onclick="previewReport()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded w-1/2">プレビュー</button>
        </div>
    </form>
</div>

<script>
    function previewReport() {
        const form = document.getElementById('reportForm');
        const previewForm = document.createElement('form');

        previewForm.method = 'POST';
        previewForm.action = "{{ route('admin.reports.previewBlade') }}";
        previewForm.target = "_blank";

        // CSRF
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = "_token";
        token.value = "{{ csrf_token() }}";
        previewForm.appendChild(token);

        // フォームのデータをコピー
        new FormData(form).forEach((value, key) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            previewForm.appendChild(input);
        });

        document.body.appendChild(previewForm);
        previewForm.submit();
        document.body.removeChild(previewForm);
    }
</script>
@endsection

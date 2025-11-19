@extends('layouts.app')
@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">日報作成</h1>

            <form id="reportForm" action="{{ route('admin.reports.store') }}" method="POST">
                @csrf

                {{-- 講座 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">講座</label>
                    <select name="course_id" class="border px-2 py-1 w-150 rounded" required>
                        <option value="">選択してください</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ isset($agenda) && $agenda->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 日付 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">日付</label>
                    <input type="date" name="date"
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200">
                </div>

                {{-- タイトル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">タイトル</label>
                    <input type="text" name="title"
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200">
                </div>

                {{-- 日報内容 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">日報内容</label>
                    <textarea name="content" class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200"
                        rows="4"></textarea>
                </div>

                {{-- 感想・気付き・質問 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">感想・気付き・質問</label>
                    <textarea name="impression" class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200"
                        rows="3"></textarea>
                </div>

                {{-- 連絡事項 --}}
                <div class="mb-6">
                    <label class="block font-medium mb-1">連絡事項</label>
                    <textarea name="notice" class="border border-gray-300 rounded px-3 py-2 w-full focus:ring focus:ring-blue-200"
                        rows="2"></textarea>
                </div>

                {{-- ボタン --}}
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                        登録
                    </button>

                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 w-full"
                        onclick="previewReport()">
                        プレビュー
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewReport() {
            const form = document.getElementById('reportForm');
            const formData = new FormData(form);
            const params = new URLSearchParams();

            formData.forEach((value, key) => {
                if (value !== null) params.append(key, value);
            });

            window.open("{{ route('admin.reports.previewBlade') }}?" + params.toString(), "_blank");
        }
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">

            {{-- アジェンダ作成フォーム --}}
            <form action="{{ route('admin.agendas.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block font-medium mb-1">講座</label>
                        <select name="course_id" class="border px-2 py-1 w-full rounded" required>
                            <option value="">選択してください</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ isset($agenda) && $agenda->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">アジェンダ名</label>
                        <input type="text" name="agenda_name" value="{{ old('agenda_name') }}"
                            class="border px-2 py-1 w-full rounded" required>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">カテゴリ</label>
                        <select name="category_id" class="border px-2 py-1 w-full rounded">
                            <option value="">選択してください</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat['id'] }}"
                                    {{ old('category_id', $agenda->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>
                                    {{ $cat['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">内容・概要</label>
                        <textarea name="description" id="agenda-description" class="border px-2 py-1 w-full rounded">{{ old('description', $agenda->description ?? '') }}</textarea>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_show" value="1" {{ old('is_show') ? 'checked' : '' }}
                            class="mr-2">
                        <label>表示する</label>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">承認状態</label>
                        <select name="accept" class="border px-2 py-1 w-[200] rounded" required>
                            <option value="yes" {{ old('accept') == 'yes' ? 'selected' : '' }}>承認済み</option>
                            <option value="no" {{ old('accept') == 'no' ? 'selected' : '' }}>下書き</option>
                        </select>
                    </div>

                    {{-- 保存・一覧ボタン --}}
                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-bold">
                            保存
                        </button>
                        <a href="{{ route('admin.agendas.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            一覧に戻る
                        </a>
                    </div>
                </div>
            </form>

            {{-- アップロードフォームは別フォームとして独立 --}}
            <form action="{{ route('admin.agendas.upload') }}" method="POST" enctype="multipart/form-data"
                class="mt-6 space-y-4">
                @csrf
                <input type="file" name="file"
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded shadow-lg transition transform hover:-translate-y-0.5">
                    アップロード
                </button>
            </form>

        </div>

        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('agenda-description', {
                filebrowserUploadUrl: "{{ route('admin.agendas.upload') }}",
                filebrowserUploadMethod: 'form',
                language: 'ja',
                allowedContent: true,
                extraPlugins: 'uploadimage',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        </script>
    </div>
@endsection

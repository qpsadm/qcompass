@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">
                {{ isset($agenda->id) ? 'アジェンダ編集' : 'アジェンダ作成' }}
            </h1>

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

            {{-- 作成・編集フォーム --}}
            <form id="agenda-form"
                action="{{ isset($agenda->id) ? route('admin.agendas.update', $agenda->id) : route('admin.agendas.store') }}"
                method="POST">
                @csrf
                @if (isset($agenda->id))
                    @method('PUT')
                @endif

                {{-- アジェンダ名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">アジェンダ名</label>
                    <input type="text" name="agenda_name" value="{{ old('agenda_name', $agenda->agenda_name ?? '') }}"
                        class="border px-2 py-1 w-full rounded" required>
                </div>

                {{-- カテゴリ --}}
                <div class="mb-4">
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

                {{-- 内容・概要 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">内容・概要</label>
                    <textarea name="content" id="agenda-content" class="border px-2 py-1 w-full rounded">{{ old('content', $agenda->content ?? '') }}</textarea>
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_show" value="1"
                            {{ old('is_show', $agenda->is_show ?? 0) ? 'checked' : '' }} class="mr-2">
                        表示する
                    </label>
                </div>

                {{-- 承認状態 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">承認状態</label>
                    <select name="status" class="border px-2 py-1 w-full rounded" required>
                        <option value="yes" {{ old('status', $agenda->status ?? '') == 'yes' ? 'selected' : '' }}>承認済み
                        </option>
                        <option value="no" {{ old('status', $agenda->status ?? '') == 'no' ? 'selected' : '' }}>下書き
                        </option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    {{ isset($agenda->id) ? '更新' : '保存' }}
                </button>
            </form>
        </div>

        {{-- CKEditor 4 --}}
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            var editor = CKEDITOR.replace('agenda-content', {
                language: 'ja',
                allowedContent: true,
            });

            // フォーム送信前に CKEditor の内容を textarea に反映
            document.getElementById('agenda-form').addEventListener('submit', function(e) {
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });
        </script>
    </div>
@endsection

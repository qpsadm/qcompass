@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 flex justify-center">

        <div class="bg-white rounded-lg shadow-md w-full max-w-2xl p-6">
            <h1 class="text-2xl font-bold mb-4">アジェンダ編集</h1>

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

            <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST" x-data="agendaCourses()">
                @csrf
                @method('PUT')

                {{-- アジェンダ名 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">アジェンダ名</label>
                    <input type="text" name="agenda_name" value="{{ old('agenda_name', $agenda->agenda_name) }}"
                        class="border px-2 py-1 w-full rounded" required>
                </div>

                {{-- カテゴリ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">カテゴリ</label>
                    <select name="category_id" class="border px-2 py-1 w-100 rounded">
                        <option value="">選択してください</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}"
                                {{ old('category_id', $agenda->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>
                                {{ $cat['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_show" value="1"
                            {{ old('is_show', $agenda->is_show) ? 'checked' : '' }} class="mr-2">
                        表示する
                    </label>
                </div>

                {{-- 承認 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">承認状態</label>
                    <select name="status" class="border px-2 py-1 w-100 rounded" required>
                        <option value="yes" {{ old('status', $agenda->status) == 'yes' ? 'selected' : '' }}>承認済み</option>
                        <option value="no" {{ old('status', $agenda->status) == 'no' ? 'selected' : '' }}>下書き</option>
                    </select>
                </div>

                {{-- 内容・概要 (CKEditor) --}}
                <div class="mb-4">
                    <label for="content" class="block font-medium mb-1">内容・概要</label>
                    <textarea name="content" id="content" class="border px-2 py-1 w-full rounded">{{ old('content', $agenda->content ?? '') }}</textarea>
                </div>
                {{-- 画像一覧 --}}
                <table class="w-full border-collapse mt-4">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="p-2 text-left">プレビュー</th>
                            <th class="p-2 text-left">ファイル名</th>
                            <th class="p-2 text-left">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agenda->files as $file)
                            <tr class="border-b">
                                <td class="p-2">
                                    <img src="{{ asset('storage/' . $file->file_path) }}" class="h-16 object-cover">
                                </td>
                                <td class="p-2">
                                    {{ $file->file_name }}
                                </td>
                                <td class="p-2 flex gap-2">
                                    <!-- URLコピー -->
                                    <button type="button" class="text-blue-500 underline"
                                        onclick="copyToClipboard('{{ asset('storage/' . $file->file_path) }}')">
                                        URLコピー
                                    </button>
                                    <!-- 別ウィンドウプレビュー -->
                                    <button type="button" class="text-green-500 underline"
                                        onclick="openPreview('{{ asset('storage/' . $file->file_path) }}')">
                                        プレビュー
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <script>
                    function copyToClipboard(text) {
                        navigator.clipboard.writeText(text).then(() => {
                            alert('URLをコピーしました！');
                        }).catch(err => {
                            alert('コピーに失敗しました');
                            console.error(err);
                        });
                    }

                    function openPreview(url) {
                        window.open(url, '_blank', 'width=800,height=600,resizable=yes,scrollbars=yes');
                    }
                </script>






                <div class="flex gap-2 mt-4">
                    <!-- 更新ボタン -->
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        更新
                    </button>

                    <!-- 一覧に戻るボタン -->
                    <a href="{{ route('admin.agendas.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>

        {{-- CKEditor 4 CDN --}}
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('content', {
                language: 'ja',
                allowedContent: true,
            });
        </script>
    </div>
@endsection

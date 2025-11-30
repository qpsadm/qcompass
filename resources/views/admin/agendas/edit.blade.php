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
            <div class="mb-4" x-data="{ is_show: {{ old('is_show', $JobOffer->is_show ?? 0) }} }">
                <span class="font-medium mr-2">表示フラグ</span>
                <div class="flex gap-2">
                    <label :class="is_show == 1 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                        <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                        公開
                    </label>

                    <label :class="is_show == 0 ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                        class="px-4 py-2 rounded-full cursor-pointer transition-colors duration-200">
                        <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                        非公開
                    </label>
                </div>
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
            @php
            // .env からストレージ URL を取得
            $storageBaseUrl = env('APP_STORAGE_URL', url('/storage'));
            @endphp

            @if ($agenda->files->isNotEmpty())
            <div class="mt-6 bg-gray-50 p-4 rounded">
                <h2 class="text-lg font-semibold mb-2">登録済みファイル一覧</h2>
                <table class="w-full table-auto border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-3 py-2">ファイル名</th>
                            <th class="border px-3 py-2">サイズ</th>
                            <th class="border px-3 py-2">プレビュー</th>
                            <th class="border px-3 py-2">URLコピー</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agenda->files as $file)
                        @php
                        // storage/app/public/... の相対パスを取得
                        $relativePath = str_replace('public/', '', $file->file_path);
                        // 固定 IP / ドメイン用の URL を生成
                        $fileUrl = rtrim($storageBaseUrl, '/') . '/' . $relativePath;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">{{ $file->file_name }}</td>
                            <td class="border px-3 py-2">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                            <td class="border px-3 py-2">
                                @if (Str::startsWith($file->file_type, 'image/'))
                                <a href="{{ $fileUrl }}" target="_blank">
                                    <img src="{{ $fileUrl }}" class="w-20 h-20 object-cover rounded" alt="プレビュー">
                                </a>
                                @else
                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-500 hover:text-blue-700 underline text-sm">
                                    プレビュー
                                </a>
                                @endif
                            </td>
                            <td class="border px-3 py-2">
                                <button type="button"
                                    class="bg-gray-200 px-2 py-1 rounded text-sm hover:bg-gray-300"
                                    onclick="navigator.clipboard.writeText('{{ $fileUrl }}').then(() => { alert('URLをコピーしました'); });">
                                    URLコピー
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif







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
<style>
    .cke_notifications_area {
        display: none !important;
    }
</style>
@endsection

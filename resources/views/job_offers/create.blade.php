@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">
                {{ isset($JobOffer) ? '求人票編集' : '求人票作成' }}（管理画面）
            </h1>

            {{-- エラー表示 --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ isset($JobOffer) ? route('admin.job_offers.update', $JobOffer->id) : route('admin.job_offers.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($JobOffer))
                    @method('PUT')
                @endif

                {{-- 求人タイトル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">求人タイトル<span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $JobOffer->title ?? '') }}"
                        class="border px-2 py-1 w-full rounded" required>
                </div>

                {{-- 説明文 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明文</label>
                    <textarea name="description" class="border px-2 py-1 w-full rounded">{{ old('description', $JobOffer->description ?? '') }}</textarea>
                </div>

                {{-- PDFファイルパス --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">PDFファイル</label>

                    @if (isset($JobOffer) && $JobOffer->file_path)
                        <p>現在のファイル: <a href="{{ asset('storage/' . $JobOffer->file_path) }}" target="_blank">確認</a></p>
                    @endif

                    <input type="file" name="pdf_file" class="border px-2 py-1 w-full rounded">
                </div>


                {{-- 表示開始日時 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示開始日時</label>
                    <input type="date" name="start_datetime"
                        value="{{ old('start_datetime', isset($JobOffer) ? $JobOffer->start_datetime->format('Y-m-d') : '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 表示終了日時 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示終了日時</label>
                    <input type="date" name="end_datetime"
                        value="{{ old('end_datetime', isset($JobOffer) ? $JobOffer->end_datetime->format('Y-m-d') : '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 表示フラグ --}}
<div class="mb-4">
    <span class="font-medium mr-2">表示フラグ</span>
    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" name="is_show" value="1" class="hidden" id="is_show_checkbox"
            {{ old('is_show', $JobOffer->is_show ?? 0) ? 'checked' : '' }}>
        <span id="is_show_label"
            class="px-4 py-2 rounded-full text-white transition-colors duration-200
                {{ old('is_show', $JobOffer->is_show ?? 0) ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-400 hover:bg-gray-500' }}">
            公開する
        </span>
    </label>
</div>

<script>
    // チェックボックスの状態に応じて色を切り替える
    const checkbox = document.getElementById('is_show_checkbox');
    const label = document.getElementById('is_show_label');

    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            label.classList.remove('bg-gray-400', 'hover:bg-gray-500');
            label.classList.add('bg-green-500', 'hover:bg-green-600');
        } else {
            label.classList.remove('bg-green-500', 'hover:bg-green-600');
            label.classList.add('bg-gray-400', 'hover:bg-gray-500');
        }
    });
</script>


                {{-- 更新者ID --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">更新者名</label>
                    <input type="text" name="created_user_name"
                        value="{{ old('user_id', $JobOffer->created_user_name ?? auth()->id()) }}"
                        class="border px-2 py-1 w-full rounded" readonly>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    {{ isset($JobOffer) ? '更新する' : '保存する' }}
                </button>
                <a href="{{ route('admin.job_offers.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    一覧に戻る
                </a>
        </div>
        </form>
    </div>
    </div>
@endsection

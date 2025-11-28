@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票編集</h1>

            <form action="{{ route('admin.job_offers.update', $job_offer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">求人タイトル</label>
                    <input type="text" name="title" value="{{ old('title', $job_offer->title) }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">説明文</label>
                    <textarea name="description" class="border px-2 py-1 w-full rounded">{{ old('description', $job_offer->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">PDFファイル</label>
                    @if ($job_offer->file_path)
                        <p>現在のファイル: <a href="{{ asset('storage/' . $job_offer->file_path) }}" target="_blank">確認</a></p>
                    @endif
                    <input type="file" name="pdf_file" class="border px-2 py-1 w-full rounded">
                </div>

<div class="mb-4">
    <span class="font-medium mr-2">表示フラグ<br>※非公開の場合はグレー</span>
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

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新する</button>
                <a href="{{ route('admin.job_offers.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    一覧に戻る
                </a>
        </div>
        </form>
    </div>
    </div>
@endsection

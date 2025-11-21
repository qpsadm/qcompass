@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票作成（管理画面）</h1>

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

            <form action="{{ route('admin.job_offers.store') }}" method="POST">
                @csrf

                {{-- 求人タイトル --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">求人タイトル<span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $JobOffer->title ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 説明文 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">説明文</label>
                    <input type="text" name="description" value="{{ old('description', $JobOffer->description ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- PDFファイルパス --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">PDFファイル保存パス</label>
                    <input type="text" name="file_path" value="{{ old('file_path', $JobOffer->file_path ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 表示開始日時 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示開始日時</label>
                    <input type="date" name="start_datetime"
                        value="{{ old('start_datetime', $JobOffer->start_datetime ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 表示終了日時 --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示終了日時</label>
                    <input type="date" name="end_datetime"
                        value="{{ old('end_datetime', $JobOffer->end_datetime ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                {{-- 表示フラグ --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">表示フラグ</label>
                    <input type="checkbox" name="display_flag" value="1"
                        {{ old('display_flag', $JobOffer->display_flag ?? 0) ? 'checked' : '' }}>
                    <span>表示する</span>
                </div>

                {{-- 更新者ID --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">更新者ID</label>
                    <input type="text" name="user_id" value="{{ old('user_id', $JobOffer->user_id ?? auth()->id()) }}"
                        class="border px-2 py-1 w-full rounded" readonly>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    保存する
                </button>
            </form>
        </div>
    </div>
@endsection

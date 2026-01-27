@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-5xl">

    <h1 class="text-3xl font-bold mb-6">
        {{ isset($JobOffer) ? '求人票編集' : '求人票作成' }}
    </h1>

    {{-- エラー表示 --}}
    @if ($errors->any())
    <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form
        action="{{ isset($JobOffer) ? route('admin.job_offers.update', $JobOffer->id) : route('admin.job_offers.store') }}"
        method="POST"
        enctype="multipart/form-data"
        x-data="{
            description: $refs.descriptionTextarea?.value ?? '',
            previewWindow: null,
            openPreview() {
                if (!this.previewWindow || this.previewWindow.closed) {
                    this.previewWindow = window.open('', 'preview', 'width=800,height=600');
                    this.previewWindow.document.head.innerHTML =
                        '<style>body{font-family:sans-serif;padding:1rem;} p{margin-bottom:1em;} a{color:blue;}</style>';
                }
                this.updatePreview();
            },
            updatePreview() {
                if (this.previewWindow && !this.previewWindow.closed) {
                    this.previewWindow.document.body.innerHTML = this.description;
                }
            }
        }"
        x-init="$watch('description', () => updatePreview())">
        @csrf
        @if(isset($JobOffer))
        @method('PUT')
        @endif

        <table class="w-full table-auto border-collapse">

            {{-- 求人タイトル --}}
            <tr class="border-b">
                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                    求人タイトル<span class="text-red-500 ml-1">*</span>
                </th>
                <td class="px-4 py-3">
                    <input type="text" name="title"
                        value="{{ old('title', $JobOffer->title ?? '') }}"
                        class="border rounded px-3 py-2 w-full" required>
                </td>
            </tr>

            {{-- 説明文 --}}
            <tr class="border-b">
                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                    説明文
                </th>
                <td class="px-4 py-3">
                    <textarea
                        x-ref="descriptionTextarea"
                        x-model="description"
                        name="description"
                        rows="8"
                        class="border rounded px-3 py-2 w-full">{{ old('description', $JobOffer->description ?? '') }}</textarea>

                    <div class="mt-3">
                        <button type="button"
                            @click="openPreview()"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            プレビューを別ウィンドウで開く
                        </button>
                    </div>
                </td>
            </tr>

            {{-- PDFファイル --}}
            @foreach(range(1,5) as $i)
            @php
            $column = $i === 1 ? 'file_path' : 'file_path'.$i;
            $inputName = 'pdf_file'.$i;
            $deleteName = 'delete_pdf'.$i;
            @endphp

            <tr class="border-b"
                x-data="{
        fileName: '',
        baseUrl: '{{ asset('storage/job_offers') }}',
        jobId: '{{ $JobOffer->id ?? 'temp' }}'
    }">
                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                    PDFファイル{{ $i }}
                </th>

                <td class="px-4 py-3 space-y-2">

                    {{-- ファイル選択 --}}
                    <input type="file"
                        name="{{ $inputName }}"
                        class="border rounded px-3 py-2 w-full"
                        @change="fileName = $event.target.files[0]?.name ?? ''">

                    {{-- 保存前でも出る予定URL --}}
                    <template x-if="fileName">
                        <div class="flex items-start gap-2 text-sm break-all"
                            x-data="{
            copied:false,
            url: `${baseUrl}/${jobId}/${fileName}`,
            copy() {
                navigator.clipboard.writeText(this.url).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                });
            }
         }">
                            <span class="text-gray-600 shrink-0">予定URL：</span>

                            <a
                                :href="url"
                                target="_blank"
                                class="text-blue-600 underline break-all"
                                x-text="url"></a>

                            <button
                                type="button"
                                @click="copy()"
                                class="shrink-0 px-2 py-1 text-xs bg-gray-200 rounded hover:bg-gray-300">
                                コピー
                            </button>

                            <span
                                x-show="copied"
                                x-transition
                                class="text-green-600 text-xs shrink-0">
                                コピーしました
                            </span>
                        </div>
                    </template>

                    {{-- 既存PDF --}}
                    @if(isset($JobOffer) && $JobOffer->$column)
                    <p class="text-sm break-all">
                        現在：
                        <a href="{{ asset('storage/' . $JobOffer->$column) }}"
                            target="_blank"
                            class="text-blue-600 underline">
                            {{ asset('storage/' . $JobOffer->$column) }}
                        </a>
                    </p>

                    {{-- 削除チェック --}}
                    <label class="inline-flex items-center gap-2 text-sm text-red-600">
                        <input type="checkbox" name="{{ $deleteName }}" value="1">
                        このPDFを削除する
                    </label>
                    @endif

                </td>
            </tr>
            @endforeach


            {{-- 表示期間 --}}
            <tr class="border-b">
                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                    表示期間
                </th>
                <td class="px-4 py-3 flex items-center gap-2">
                    <input type="date" name="start_datetime"
                        value="{{ old('start_datetime', isset($JobOffer) && $JobOffer->start_datetime ? $JobOffer->start_datetime->format('Y-m-d') : '') }}"
                        class="border rounded px-3 py-2">
                    ～
                    <input type="date" name="end_datetime"
                        value="{{ old('end_datetime', isset($JobOffer) && $JobOffer->end_datetime ? $JobOffer->end_datetime->format('Y-m-d') : '') }}"
                        class="border rounded px-3 py-2">
                </td>
            </tr>

            {{-- 表示フラグ --}}
            <tr class="border-b">
                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                    表示フラグ
                </th>
                <td class="px-4 py-3">
                    <div x-data="{ is_show: Number('{{ old('is_show', $JobOffer->is_show ?? 0) }}') }" class="flex gap-2">
                        <label :class="is_show === 1 ? 'bg-green-600 text-white' : 'bg-gray-200'"
                            class="px-4 py-2 rounded-full cursor-pointer">
                            <input type="radio" name="is_show" value="1" class="hidden" x-model="is_show">
                            公開
                        </label>
                        <label :class="is_show === 0 ? 'bg-red-500 text-white' : 'bg-gray-200'"
                            class="px-4 py-2 rounded-full cursor-pointer">
                            <input type="radio" name="is_show" value="0" class="hidden" x-model="is_show">
                            非公開
                        </label>
                    </div>
                </td>
            </tr>

            {{-- 作成者名 --}}
            <tr class="border-b">
                <th class="w-1/4 px-4 py-3 bg-gray-100 text-right font-medium">
                    作成者名
                </th>
                <td class="px-4 py-3">
                    <input type="text" name="created_user_name"
                        value="{{ old('created_user_name', $JobOffer->created_user_name ?? auth()->user()->name) }}"
                        class="border rounded px-3 py-2 w-full bg-gray-100" readonly>
                </td>
            </tr>

        </table>

        {{-- 操作ボタン --}}
        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                {{ isset($JobOffer) ? '更新する' : '保存する' }}
            </button>
            <a href="{{ route('admin.job_offers.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                一覧に戻る
            </a>
        </div>
    </form>

    {{-- 危険操作 --}}
    @if(isset($JobOffer))
    <div class="mt-12 pt-6 border-t border-red-200" x-data="{ open:false }">
        <h2 class="text-red-600 font-semibold mb-2">⚠ 危険な操作</h2>
        <p class="text-sm text-gray-600 mb-4">この求人票を削除すると元に戻せません。</p>

        <button @click="open=true"
            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
            削除する
        </button>

        <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm">
                <h3 class="text-lg font-semibold text-center mb-4">削除確認</h3>
                <p class="text-center mb-6">「{{ $JobOffer->title }}」を削除しますか？</p>

                <div class="flex justify-center gap-4">
                    <button @click="open=false"
                        class="bg-gray-300 px-4 py-2 rounded">
                        キャンセル
                    </button>
                    <form action="{{ route('admin.job_offers.destroy', $JobOffer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            削除する
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
</div>
@endsection

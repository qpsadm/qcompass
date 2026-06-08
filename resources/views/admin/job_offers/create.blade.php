@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">
                {{ isset($JobOffer) ? '求人票編集（管理画面）' : '求人票作成（管理画面）' }}
            </h1>

            {{-- エラー表示 --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ isset($JobOffer) ? route('admin.job_offers.update', $JobOffer->id) : route('admin.job_offers.store') }}"
                method="POST" enctype="multipart/form-data" x-data="{
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
                }" x-init="$watch('description', () => updatePreview())">
                @csrf
                @if (isset($JobOffer))
                    @method('PUT')
                @endif

                <table class="w-full table-auto border-collapse">

                    {{-- 求人タイトル --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                            求人タイトル
                            <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span>
                        </th>
                        <td class="px-4 py-2">
                            <input type="text" name="title" value="{{ old('title', $JobOffer->title ?? '') }}"
                                class="border rounded px-3 py-2 w-full" required>
                        </td>
                    </tr>

                    {{-- 説明文 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">説明文</th>
                        <td class="px-4 py-2">
                            <textarea x-ref="descriptionTextarea" x-model="description" name="description" rows="5"
                                class="border rounded px-3 py-2 w-full">{{ old('description', $JobOffer->description ?? '') }}</textarea>

                            <button type="button" @click="openPreview()"
                                class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                プレビュー
                            </button>
                        </td>
                    </tr>

                    {{-- PDFファイル --}}
                    @foreach (range(1, 5) as $i)
                        @php
                            // $column = $i === 1 ? 'file_path' : 'file_path'.$i;
                            $column = 'file_path' . $i;
                            $inputName = 'pdf_file' . $i;
                            $deleteName = 'delete_pdf' . $i;
                            $newFileName = 'newFileName' . $i;

                            // $today = now()->format('Ymd'); // 新規用日付
                            $virtualfilename = 'f' . now()->format('YmdHis') . '_' . $i; // 日付+時刻+連番

                        @endphp
                        <tr class="border-b" x-data="{
                            fileName: '',
                            baseUrl: '{{ asset('storage/job_offers') }}',
                            {{-- jobId: '{{ isset($JobOffer) ? $JobOffer->id : $today }}', --}}
                            jobId: '{{ isset($JobOffer) ? $JobOffer->id : $virtualfilename }}',
                            sanitizedFileName() {
                                if (!this.fileName) return '';
                                // 拡張子を保持
                                let parts = this.fileName.split('.');
                                let ext = parts.length > 1 ? '.' + parts.pop().toLowerCase() : '';
                                let name = parts.join('.').toLowerCase().replace(/[^a-z0-9]/g, '');
                                {{-- return name + ext; --}}
                                {{-- 拡張子だけ出力 --}}
                                return ext;
                            }
                        }">
                            <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">
                                PDFファイル{{ $i }}
                            </th>
                            <td class="px-4 py-2 space-y-2">
                                <input type="file" id="{{ $inputName }}" name="{{ $inputName }}"
                                    class="border rounded px-3 py-2 w-full"
                                    @change="fileName = $event.target.files[0]?.name ?? ''"
                                    onchange="generateCustomName('{{ $inputName }}','{{ $newFileName }}','{{ $virtualfilename }}')">

                                {{-- 別名を隠し保存 --}}
                                <input type="hidden" id="{{ $newFileName }}" name="{{ $newFileName }}" value="">

                                {{-- 保存前でも出る予定URL --}}
                                <template x-if="fileName">
                                    <div class="flex items-start gap-2 text-sm break-all" x-data="{
                                        copied: false,
                                        copy() {
                                            navigator.clipboard.writeText(`${baseUrl}/${jobId}${sanitizedFileName()}`).then(() => {
                                                this.copied = true;
                                                setTimeout(() => this.copied = false, 2000);
                                            });
                                        }
                                    }">
                                        <span class="text-gray-600 shrink-0">予定URL：</span>
                                        <a :href="`${baseUrl}/${jobId}${sanitizedFileName()}`" target="_blank"
                                            class="text-blue-600 underline break-all"
                                            x-text="`${baseUrl}/${jobId}${sanitizedFileName()}`"></a>
                                        <button type="button" @click="copy()"
                                            class="shrink-0 px-2 py-1 text-xs bg-gray-200 rounded hover:bg-gray-300">コピー</button>
                                        <span x-show="copied" x-transition
                                            class="text-green-600 text-xs shrink-0">コピーしました</span>
                                    </div>

                                </template>

                                {{-- 既存PDF --}}
                                @if (isset($JobOffer))
                                    <p class="text-sm break-all">
                                        現在：
                                        <a href="{{ asset('storage/' . $JobOffer->{$column}) }}" target="_blank"
                                            class="text-blue-600 underline">
                                            {{ asset('storage/' . $JobOffer->{$column}) }}
                                        </a>
                                    </p>
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
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示期間</th>
                        <td class="px-4 py-2 flex items-center gap-2">
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
                    <tr>
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示状態
                        </th>
                        <td class="px-4 py-2">
                            <div x-data="{ is_show: Number('{{ old('is_show', $JobOffer->is_show ?? 0) }}') }" class="flex gap-2">
                                <label :class="is_show === 1 ? 'bg-green-600 text-white' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-full cursor-pointer">
                                    <input type="radio" name="is_show" value="1" class="hidden"
                                        x-model.number="is_show">
                                    公開
                                </label>
                                <label :class="is_show === 0 ? 'bg-red-500 text-white' : 'bg-gray-200'"
                                    class="px-4 py-2 rounded-full cursor-pointer">
                                    <input type="radio" name="is_show" value="0" class="hidden"
                                        x-model.number="is_show">
                                    非公開
                                </label>
                            </div>
                        </td>
                    </tr>

                    {{-- 作成者名 --}}
                    <tr class="border-b">
                        <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">作成者名</th>
                        <td class="px-4 py-2">
                            <input type="text" name="created_user_name"
                                value="{{ old('created_user_name', $JobOffer->created_user_name ?? auth()->user()->name) }}"
                                class="border rounded px-3 py-2 w-full bg-gray-100" readonly>
                        </td>
                    </tr>

                </table>

                {{-- ボタン --}}
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        {{ isset($JobOffer) ? '更新する' : '保存する' }}
                    </button>
                    <a href="{{ route('admin.job_offers.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important
        }
    </style>

@endsection

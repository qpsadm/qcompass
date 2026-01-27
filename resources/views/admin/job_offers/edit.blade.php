@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-5xl">

    <h1 class="text-3xl font-bold mb-6">求人票編集：{{ $job_offer->title ?? '新規作成' }}</h1>

    <form action="{{ isset($job_offer) ? route('admin.job_offers.update', $job_offer->id) : route('admin.job_offers.store') }}"
        method="POST" enctype="multipart/form-data"
        x-data="{
            description: $refs.descriptionTextarea.value,
            previewWindow: null,
            openPreview() {
                if (!this.previewWindow || this.previewWindow.closed) {
                    this.previewWindow = window.open('', 'preview', 'width=800,height=600');
                    this.previewWindow.document.head.innerHTML = '<style>body{font-family:sans-serif;padding:1rem;} a{color:blue;text-decoration:underline;} p{margin-bottom:1em;}</style>';
                }
                this.updatePreview();
            },
            updatePreview() {
                if (this.previewWindow && !this.previewWindow.closed) {
                    this.previewWindow.document.body.innerHTML = this.description;
                }
            }
          }"
        x-init="$watch('description', value => updatePreview());">
        @csrf
        @if(isset($job_offer))
        @method('PUT')
        @endif

        <table class="w-full table-auto border-collapse">
            <tbody>
                {{-- 求人タイトル --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">求人タイトル <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded ml-1">必須</span></th>
                    <td class="px-4 py-2">
                        <input type="text" name="title" value="{{ old('title', $job_offer->title ?? '') }}" class="border rounded px-3 py-2 w-full">
                        @error('title')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </td>
                </tr>

                {{-- 説明文 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">説明文</th>
                    <td class="px-4 py-2">
                        <textarea x-ref="descriptionTextarea" x-model="description" name="description"
                            class="border rounded px-3 py-2 w-full" rows="8">{{ old('description', $job_offer->description ?? '') }}</textarea>
                        @error('description')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror

                        <div class="mt-2">
                            <button type="button" @click="openPreview()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                プレビューを別ウィンドウで開く
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- PDFファイル 1～5 --}}
                {{-- PDFファイル 1～5 --}}
                @foreach(range(1,5) as $i)
                @php
                $column = $i === 1 ? 'file_path' : 'file_path'.$i;
                $inputName = 'pdf_file'.$i;
                $today = now()->format('Ymd'); // 日付プレフィックス
                @endphp
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">PDFファイル{{ $i }}</th>
                    <td class="px-4 py-2 flex flex-col gap-2"
                        x-data="{
            fileName: '',
            copied:false,
            baseUrl: '{{ asset('storage/job_offers') }}',
            get sanitizedFileName() {
                if(!this.fileName) return '';
                let parts = this.fileName.split('.');
                let ext = parts.length > 1 ? '.' + parts.pop().toLowerCase() : '';
                let name = parts.join('.').toLowerCase().replace(/[^a-z0-9]/g,'');
                return name + ext;
            },
            get virtualUrl() {
                return `${this.baseUrl}/${'{{ $today }}'}-${this.sanitizedFileName}`;
            },
            copy(url) {
                navigator.clipboard.writeText(url).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 1500);
                });
            }
        }">
                        <input type="file" name="{{ $inputName }}" class="border rounded px-3 py-2"
                            @change="fileName = $event.target.files[0]?.name ?? ''">

                        {{-- 仮想URL --}}
                        <template x-if="fileName">
                            <div class="flex items-center gap-2 text-sm break-all">
                                <span class="text-gray-600 shrink-0">予定URL：</span>
                                <a :href="virtualUrl" target="_blank" class="text-blue-600 underline break-all" x-text="virtualUrl"></a>
                                <button type="button" @click="copy(virtualUrl)"
                                    class="shrink-0 px-2 py-1 text-xs bg-gray-200 rounded hover:bg-gray-300">コピー</button>
                                <span x-show="copied" x-transition class="text-green-600 text-xs shrink-0">コピーしました</span>
                            </div>
                        </template>

                        {{-- 既存PDF --}}
                        @if(isset($job_offer) && $job_offer->$column)
                        <div class="flex items-center gap-2">
                            <a href="{{ asset('storage/' . $job_offer->$column) }}" target="_blank"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200">
                                確認
                            </a>
                            <button type="button" @click="copy('{{ asset('storage/' . $job_offer->$column) }}')"
                                class="px-3 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
                                URLコピー
                            </button>
                        </div>
                        @endif

                        @error($inputName)
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </td>
                </tr>
                @endforeach


                {{-- 表示期間 --}}
                <tr class="border-b">
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示期間</th>
                    <td class="px-4 py-2 flex gap-2 items-center">
                        <input type="date" name="start_datetime" value="{{ old('start_datetime', $job_offer->start_datetime?->format('Y-m-d')) }}" class="border rounded px-3 py-2">
                        ～
                        <input type="date" name="end_datetime" value="{{ old('end_datetime', $job_offer->end_datetime?->format('Y-m-d')) }}" class="border rounded px-3 py-2">
                    </td>
                </tr>

                {{-- 表示フラグ --}}
                <tr>
                    <th class="w-1/4 px-4 py-2 bg-gray-100 text-right font-medium">表示状態
                    </th>
                    <td class="px-4 py-2">
                        <div x-data="{ is_show: Number('{{ old('is_show', $JobOffer->is_show ?? 0) }}') }" class="flex gap-2">
                            <label :class="is_show === 1 ? 'bg-green-600 text-white' : 'bg-gray-200'" class="px-4 py-2 rounded cursor-pointer">
                                <input type="radio" name="is_show" value="1" class="hidden" x-model.number="is_show">
                                公開
                            </label>
                            <label :class="is_show === 0 ? 'bg-red-500 text-white' : 'bg-gray-200'" class="px-4 py-2 rounded cursor-pointer">
                                <input type="radio" name="is_show" value="0" class="hidden" x-model.number="is_show">
                                非公開
                            </label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- フォーム操作ボタン --}}
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">更新する</button>
            <a href="{{ route('admin.job_offers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
        </div>
    </form>

    {{-- 危険操作ゾーン --}}
    @if(isset($job_offer))
    <div class="mt-10 pt-6 border-t border-red-200" x-data="{ deleteOpen: false }">
        <h2 class="text-red-600 font-semibold mb-2">⚠ 危険な操作</h2>
        <p class="text-sm text-gray-600 mb-4">
            この求人票を削除すると元に戻せません。
        </p>
        <button @click="deleteOpen = true" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">削除する</button>

        {{-- 削除確認モーダル --}}
        <div x-show="deleteOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div x-show="deleteOpen" x-transition.scale.duration.200ms class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                <p class="text-gray-700 text-center mb-5">「{{ $job_offer->title ?? 'この求人票' }}」を削除しますか？</p>
                <div class="flex justify-center gap-4">
                    <button @click="deleteOpen = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">キャンセル</button>
                    <form action="{{ route('admin.job_offers.destroy', $job_offer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">削除する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</div>
@endsection

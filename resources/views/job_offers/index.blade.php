@extends('layouts.app')

@section('content')
    <div x-data="{ open: false, deleteUrl: '', deleteName: '' }" class="container mx-auto p-6">

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票一覧</h1>

            <a href="{{ route('admin.job_offers.create') }}"
                class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition inline-flex justify-center max-w-xs mb-4">
                新規作成
            </a>

            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">求人タイトル</th>
                        <th class="border px-4 py-2">説明</th>
                        <th class="border px-4 py-2">PDF</th>
                        <th class="border px-4 py-2">更新者</th>
                        <th class="border px-4 py-2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($job_offers as $jobOffer)
                        <tr>
                            <td class="border px-4 py-2">{{ $jobOffer->title }}</td>
                            <td class="border px-4 py-2">{{ $jobOffer->description }}</td>

                            {{-- PDFアイコン --}}
                            <td class="border px-4 py-2 text-center">
                                @if ($jobOffer->file_path)
                                    <a href="{{ url('storage/' . $jobOffer->file_path) }}" target="_blank">
                                        <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" alt="PDF"
                                            class="w-6 h-6 inline-block">
                                    </a>
                                @else
                                    ❌
                                @endif
                            </td>

                            {{-- 更新者 --}}
                            <td class="border px-4 py-2">{{ $jobOffer->updated_user_name }}</td>

                            {{-- 操作 --}}
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.job_offers.edit', $jobOffer->id) }}"
                                    class="text-blue-600 hover:underline">
                                    編集
                                </a>
                                <a href="#"
                                    @click.prevent="open = true; deleteUrl='{{ route('admin.job_offers.destroy', $jobOffer->id) }}'; deleteName='{{ $jobOffer->title }}';"
                                    class="text-red-600 hover:underline ml-4">
                                    削除
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    {{-- データがない場合 --}}
                    @if ($job_offers->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center border px-4 py-2">求人票がありません。</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- モーダル（テーブル外） -->
        <div x-show="open" x-cloak x-transition.opacity.duration.200ms
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div x-show="open" x-transition.scale.duration.200ms
                class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
                <p class="text-gray-700 text-center mb-5">
                    「<span x-text="deleteName"></span>」を削除しますか？
                </p>
                <div class="flex justify-center space-x-4">
                    <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        キャンセル
                    </button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            削除する
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

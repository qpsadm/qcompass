@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">求人票一覧</h1>

            <a href="{{ route('admin.job_offers.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
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
                                    <a href="{{ url('storage/' . $jobOffer->file_path) }}" target="_blank">📄</a>
                                @else
                                    ❌
                                @endif
                            </td>

                            {{-- 更新者 --}}
                            <td class="border px-4 py-2">{{ $jobOffer->updated_user_name }}</td>

                            {{-- 操作 --}}
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.job_offers.edit', $jobOffer->id) }}" class="text-blue-600">編集</a>
                                <form action="{{ route('admin.job_offers.destroy', $jobOffer->id) }}" method="POST"
                                    class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600"
                                        onclick="return confirm('削除しますか？')">削除</button>
                                </form>
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
    </div>
@endsection

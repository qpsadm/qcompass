@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">
            {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} ファイル作成
        </h1>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST"
            action="{{ route('admin.files.store', ['type' => $type, 'targetId' => $target->id ?? 0]) }}"
            enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="target_type" value="{{ $type }}">
            <input type="hidden" name="target_id" value="{{ $target->id ?? '' }}">

            @if (!empty($returnUrl))
            <input type="hidden" name="return_url" value="{{ $returnUrl }}">
            @endif

            <table class="w-full border-collapse">
                <tbody>
                    <tr>
                        <th class="border px-4 py-2 bg-gray-100 text-right">ファイル</th>
                        <td class="border px-4 py-2">
                            <input type="file" name="file_path" required>
                        </td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100 text-right">ファイル名</th>
                        <td class="border px-4 py-2">
                            <input type="text" name="file_name"
                                value="{{ old('file_name', $defaultFileName ?? '') }}"
                                placeholder="アップロードファイルの拡張子が付きます"
                                class="w-full border px-2 py-1" required>
                        </td>
                    </tr>

                    <tr>
                        <th class="border px-4 py-2 bg-gray-100 text-right">説明</th>
                        <td class="border px-4 py-2">
                            <input type="text" name="description" class="w-full border px-2 py-1">
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button class="bg-blue-500 text-white px-6 py-2 rounded">
                    保存
                </button>

                @if (!empty($returnUrl))
                <a href="{{ $returnUrl }}"
                    class="bg-gray-500 text-white px-6 py-2 rounded">
                    {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} に戻る
                </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

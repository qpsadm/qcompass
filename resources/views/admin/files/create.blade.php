@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">
                {{ $type === 'agenda' ? 'アジェンダ' : 'お知らせ' }} ファイル作成
            </h1>

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

            {{-- form action に type と targetId を渡す --}}
            <form action="{{ route('admin.files.store', ['type' => $type, 'targetId' => $target->id ?? 0]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="target_type" value="{{ $type }}">
                <input type="hidden" name="target_id" value="{{ $target->id ?? 0 }}">

                <table class="w-full table-auto border-collapse">
                    <tbody>
                        {{-- 対象選択（target_idが未指定の場合だけ） --}}
                        @if (!isset($target) || $target->id == 0)
                            <tr class="border-b">
                                <th class="px-4 py-2 bg-gray-100 text-right font-medium">対象</th>
                                <td class="px-4 py-2">
                                    @if ($type === 'agenda')
                                        <select name="target_id" class="border rounded px-3 py-2 w-80" required>
                                            <option value="">選択してください</option>
                                            @foreach (\App\Models\Agenda::all() as $agenda)
                                                <option value="{{ $agenda->id }}">{{ $agenda->agenda_name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="target_id" class="border rounded px-3 py-2 w-80" required>
                                            <option value="">選択してください</option>
                                            @foreach (\App\Models\Announcement::all() as $announcement)
                                                <option value="{{ $announcement->id }}">
                                                    {{ $announcement->title ?? 'タイトルなし' }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </td>
                            </tr>
                        @endif

                        {{-- ファイル --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">ファイル</th>
                            <td class="px-4 py-2">
                                <input type="file" name="file_path" class="border rounded px-3 py-2 w-full" required>
                            </td>
                        </tr>

                        {{-- ファイル名 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">ファイル名</th>
                            <td class="px-4 py-2">
                                <input type="text" name="file_name" class="border rounded px-3 py-2 w-full" required>
                            </td>
                        </tr>

                        {{-- 説明 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">説明</th>
                            <td class="px-4 py-2">
                                <input type="text" name="description" class="border rounded px-3 py-2 w-full">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                        保存
                    </button>
                    <a href="{{ route('admin.files.index', ['type' => $type, 'targetId' => $target->id ?? 0]) }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        一覧に戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

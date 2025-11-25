@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">
                {{ isset($agenda->id) ? 'アジェンダ編集' : 'アジェンダ作成' }}
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

            <form id="agenda-form"
                action="{{ isset($agenda->id) ? route('admin.agendas.update', $agenda->id) : route('admin.agendas.store') }}"
                method="POST">
                @csrf
                @if (isset($agenda->id))
                    @method('PUT')
                @endif

                <table class="w-full table-auto border-collapse">
                    <tbody>
                        {{-- アジェンダ名 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">アジェンダ名
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded ml-1">必須</span>
                            </th>
                            <td class="px-4 py-2">
                                <input type="text" name="agenda_name"
                                    value="{{ old('agenda_name', $agenda->agenda_name ?? '') }}"
                                    class="border rounded px-3 py-2 w-full">
                            </td>
                        </tr>

                        {{-- カテゴリ --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">カテゴリ</th>
                            <td class="px-4 py-2">
                                <select name="category_id" class="border rounded px-3 py-2 w-80">
                                    <option value="">選択してください</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat['id'] }}"
                                            {{ old('category_id', $agenda->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>
                                            {{ $cat['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        {{-- 内容・概要 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">内容・概要</th>
                            <td class="px-4 py-2">
                                <textarea name="content" id="agenda-content" rows="6" class="border rounded px-3 py-2 w-full">{{ old('content', $agenda->content ?? '') }}</textarea>
                            </td>
                        </tr>

                        {{-- 表示フラグ --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">表示フラグ</th>
                            <td class="px-4 py-2">
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" name="is_show" value="1"
                                        {{ old('is_show', $agenda->is_show ?? 0) ? 'checked' : '' }} class="border rounded">
                                    <span>表示する</span>
                                </label>
                            </td>
                        </tr>

                        {{-- 承認状態 --}}
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-100 text-right font-medium">承認状態</th>
                            <td class="px-4 py-2">
                                <select name="status" class="border rounded px-3 py-2 w-60">
                                    <option value="yes"
                                        {{ old('status', $agenda->status ?? '') == 'yes' ? 'selected' : '' }}>承認済み</option>
                                    <option value="no"
                                        {{ old('status', $agenda->status ?? '') == 'no' ? 'selected' : '' }}>下書き</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>

                </table>


                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                        {{ isset($agenda->id) ? '更新' : '保存' }}
                    </button>
                    <a href="{{ route('admin.agendas.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
                </div>
            </form>
        </div>

        {{-- CKEditor --}}
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            var editor = CKEDITOR.replace('agenda-content', {
                language: 'ja',
                allowedContent: true,
            });

            document.getElementById('agenda-form').addEventListener('submit', function(e) {
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });
        </script>
    </div>
@endsection

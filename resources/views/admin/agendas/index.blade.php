@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 min-h-screen bg-white rounded-lg shadow-md" x-data="{ open: false, deleteUrl: '', deleteName: '' }">
    <h1 class="text-2xl font-bold mb-4">アジェンダ一覧</h1>

    {{-- 上部操作ボタン --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.agendas.create') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_create.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">新規作成</span>
            </a>
        </div>

        {{-- 検索 --}}
        <div x-data="searchBox()" class="flex items-center space-x-2">
            <form :action="url" method="GET" class="relative flex-1">
                <input type="text" name="search" x-model="search" placeholder="アジェンダ名で検索" @keydown.enter.prevent="submit()" class="w-full border px-2 py-1 rounded pr-8">
                <button type="button" x-show="search" @click="clear()" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">&times;</button>
            </form>
            <button @click="submit()" class="bg-blue-500 px-4 py-1 rounded hover:bg-blue-600 hover:text-white transition flex items-center space-x-1">
                <img src="{{ asset('assets/images/icon/b_dustbox.svg') }}" class="w-4 h-4">
                <span class="hidden lg:inline ml-1">検索</span>
            </button>
        </div>
    </div>

    <script>
        function searchBox() {
            return {
                search: "{{ request('search') }}",
                url: "{{ route('admin.agendas.index') }}",
                submit() {
                    const form = document.createElement('form');
                    form.method = 'GET';
                    form.action = this.url;
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'search';
                    input.value = this.search;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                },
                clear() {
                    this.search = '';
                    this.submit();
                }
            }
        }
    </script>

    {{-- アジェンダテーブル --}}
    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">アジェンダ名</th>
                    <th class="border px-4 py-2">表示</th>
                    <th class="border px-4 py-2">承認</th>
                    <th class="border px-4 py-2">作成者</th>
                    <th class="border px-4 py-2 text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($agendas as $agenda)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $agenda->agenda_name }}</td>
                    {{-- 表示/非表示 --}}
                    <td class="border px-4 py-2 text-center">
                        @if($agenda->is_show )
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                        @else
                        <span class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $agenda->status === 'yes' ? '承認済み' : '下書き' }}</td>
                    <td class="border px-4 py-2">{{ $agenda->created_user_name ?? '不明' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex items-center justify-center flex-nowrap space-x-2">
                            {{-- プレビューボタン --}}
                            <button type="button"
                                class="flex items-center text-green-600 hover:text-green-700 preview-button"
                                data-content='@json($agenda->content)'>
                                <img src="{{ asset('assets/images/icon/b_agenda.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">プレビュー</span>
                            </button>

                            {{-- 詳細 --}}
                            <a href="{{ route('admin.agendas.show', $agenda->id) }}" class="flex items-center text-blue-600 hover:text-blue-700">
                                <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">詳細</span>
                            </a>

                            {{-- 編集 --}}
                            <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="flex items-center text-blue-600 hover:text-blue-700">
                                <img src="{{ asset('assets/images/icon/b_report.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">編集</span>
                            </a>

                            {{-- 削除 --}}
                            <button @click="open = true; deleteUrl='{{ route('admin.agendas.destroy', $agenda->id) }}'; deleteName='{{ $agenda->agenda_name }}';"
                                class="flex items-center text-red-600 hover:text-red-700">
                                <img src="{{ asset('assets/images/icon/b_dust.svg') }}" class="w-4 h-4">
                                <span class="hidden lg:inline ml-1">削除</span>
                            </button>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">アジェンダはまだ登録されていません。</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ページネーション --}}
        <div class="mt-4">
            {{ $agendas->links() }}
        </div>
    </div>

    {{-- 共通削除モーダル --}}
    <div x-show="open" x-cloak x-transition.opacity.duration.200ms class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-show="open" x-transition.scale.duration.200ms class="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-3 text-center">削除確認</h2>
            <p class="text-gray-700 text-center mb-5">
                「<span x-text="deleteName"></span>」を削除しますか？
            </p>
            <div class="flex justify-center space-x-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">キャンセル</button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">削除する</button>
                </form>
            </div>
        </div>
    </div>

</div>

{{-- プレビュー用スクリプト --}}
<script>
    document.querySelectorAll('.preview-button').forEach(btn => {
        btn.addEventListener('click', function() {
            // JSON文字列として取得してパース
            let contentHTML = this.dataset.content;
            try {
                contentHTML = JSON.parse(contentHTML);
            } catch (e) {
                console.error('JSON parse error', e);
                contentHTML = '';
            }

            const previewWindow = window.open('', 'PreviewWindow', 'width=800,height=600');
            if (!previewWindow) {
                alert('ポップアップブロックを解除してください。');
                return;
            }

            previewWindow.document.open();
            previewWindow.document.write(`
            <!DOCTYPE html>
            <html lang="ja">
            <head>
                <meta charset="UTF-8">
                <title>内容・概要 プレビュー</title>
                <link rel="stylesheet" href="/css/app.css">
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
            </head>
            <body class="p-6">
                <h2 class="text-xl font-bold mb-4">内容・概要 プレビュー</h2>
                <div class="prose">${contentHTML}</div>
            </body>
            </html>
        `);
            previewWindow.document.close();
        });
    });
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endsection

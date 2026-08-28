@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツ詳細</h1>

            @php
                $typeLabels = [
                    '1' => '参考書籍',
                    '2' => '参考サイト',
                    '3' => 'IT資格',
                    '4' => '制作品',
                ];

                $levelLabels = [
                    1 => '初級',
                    2 => '中級',
                    3 => '上級',
                ];

                // $tags = [
                //     1 => 'WEB制作',
                //     2 => 'WEBデザイン',
                //     3 => 'プログラミング',
                //     4 => 'OA',
                //     5 => 'その他',
                // ];

            @endphp

            <div class="border p-4 rounded mb-6 space-y-3">
                <p><strong>タイトル:</strong>
                    {{ $learning->title }}</p>
                <p><strong>種別:</strong>
                    {{ $typeLabels[$learning->type] ?? $learning->type }}</p>
                <p><strong>タグ:</strong>
                    {{-- {{ $tags[$learning->tag_id] ?? '未設定' }}</p> --}}
                    {{ $learning->tag->name ?? '未設定' }}</p>
                <p><strong>レベル:</strong>
                    {{ $levelLabels[$learning->level] ?? '未設定' }}</p>

                <p><strong>説明:</strong><br>
                    {!! $learning->description ? nl2br(e($learning->description)) : 'なし' !!}</p>

                {{-- @if ($learning->type == '4') --}}
                <p><strong>訓練科名:</strong>
                    {{ blank($learning->course_name ?? null) ? '-' : $learning->course_name }}</p>
                <p><strong>訓練期間:</strong>
                    {{-- {{ $learning->priod ?? '-' }}</p> --}}
                    {{ blank($learning->priod ?? null) ? '-' : $learning->priod }}</p>
                {{-- @endif --}}

                <p><strong>表示状態:</strong>
                    {{ $learning->is_show ? '公開' : '非公開' }}</p>

                @if ($learning->url)
                    <p><strong>参照URL:</strong>
                        <a href="{{ $learning->url }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $learning->url }}
                        </a>
                    </p>
                @endif
            </div>

            {{-- 画像表示 --}}
            @if ($learning->image)
                <div class="mb-4 text-left px-4 py-4">
                    <p><strong>画像:</strong></p>
                    <a href="{{ asset('storage/' . $learning->image) }}" target="_blank"
                        onclick="window.open().document.write('<body style=\'margin:0; background:#0e0e0e; display:flex; justify-content:center; align-items:center; min-height:100vh;\'><img src=\'{{ asset('storage/' . $learning->image) }}\' style=\'max-width:80vw; max-height:80vh; object-fit:contain;\'></body>'); return false;">
                        <img src="{{ asset('storage/' . $learning->image) }}"
                            class="w-60 object-cover rounded inline-block py-2">
                    </a>
                    <p class="text-sm mt-1">クリックで拡大表示</p>
                </div>
            @endif

            <div class="flex gap-2">
                <a href="{{ route('admin.learnings.edit', $learning->id) }}"
                    class="save bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    編集
                </a>
                <a href="{{ route('admin.learnings.index') }}"
                    class="back bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    一覧に戻る
                </a>
            </div>
        </div>
    </div>
@endsection

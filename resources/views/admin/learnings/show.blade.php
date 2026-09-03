@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">学習コンテンツの詳細</h1>

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
                <p><span class="inline-block w-32 text-right font-bold px-4">タイトル:</span>
                    {{ $learning->title }}</p>
                <p><span class="inline-block w-32 text-right font-bold px-4">種別:</span>
                    {{ $typeLabels[$learning->type] ?? $learning->type }}</p>
                <p><span class="inline-block w-32 text-right font-bold px-4">タグ:</span>
                    {{-- {{ $tags[$learning->tag_id] ?? '未設定' }}</p> --}}
                    {{ $learning->tag->name ?? '未設定' }}</p>
                <p><span class="inline-block w-32 text-right font-bold px-4">レベル:</span>
                    {{ $levelLabels[$learning->level] ?? '未設定' }}</p>

                <div class="flex flex-row">
                    <p class="w-32 text-right font-bold px-4">説明:</p>
                    <p>{!! $learning->description ? nl2br(e($learning->description)) : 'なし' !!}</p>
                </div>

                {{-- @if ($learning->type == '4') --}}
                <p><span class="inline-block w-32 text-right font-bold px-4">訓練科名:</span>
                    {{ blank($learning->course_name ?? null) ? '-' : $learning->course_name }}</p>
                <p><span class="inline-block w-32 text-right font-bold px-4">訓練期間:</span>
                    {{-- {{ $learning->priod ?? '-' }}</p> --}}
                    {{ blank($learning->priod ?? null) ? '-' : $learning->priod }}</p>
                {{-- @endif --}}

                <p><span class="inline-block w-32 text-right font-bold px-4">表示状態:</span>
                    {{ $learning->is_show ? '公開' : '非公開' }}</p>

                @if ($learning->url)
                    <p><span class="inline-block w-32 text-right font-bold px-4">参照URL:</span>
                        <a href="{{ $learning->url }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $learning->url }}
                        </a>
                    </p>
                @endif

                {{-- 画像表示 --}}
                @if ($learning->image)
                    <div class="flex flex-row">
                        <p><span class="inline-block w-32 text-right font-bold px-4">画像:</span></p>

                        <div>
                            <a href="{{ asset('storage/' . $learning->image) }}" target="_blank"
                                onclick="window.open().document.write('<body style=\'margin:0; background:#0e0e0e; display:flex; justify-content:center; align-items:center; min-height:100vh;\'><img src=\'{{ asset('storage/' . $learning->image) }}\' style=\'max-width:80vw; max-height:80vh; object-fit:contain;\'></body>'); return false;">
                                <img src="{{ asset('storage/' . $learning->image) }}"
                                    class="w-60 object-cover rounded inline-block py-2">
                            </a>
                            <p class="text-sm mt-1">クリックで拡大表示</p>
                        </div>


                    </div>
                @endif

            </div>



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

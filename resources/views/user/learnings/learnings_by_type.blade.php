@extends('layouts.f_layout')

@section('title', $typeName . '一覧')

@section('code-page-css')
<link rel="stylesheet" href="{{ asset('assets/css/f_learnings.css') }}">
@endsection

@section('main-content')
<div class="container">

    {{-- ページタイトル --}}
    <x-f_page_title :search="true" title="{{ $typeName }}一覧" />

    {{-- タイプ別学習リソース --}}
    <div class="learnings-list mt-4">
        @forelse($learnings as $learning)
        <div class="learning-item mb-4 p-4 border rounded hover:shadow">
            <h2 class="font-bold text-xl mb-2">
                {{-- 詳細ページへのリンクを正しいルート名に修正 --}}
                <a href="{{ route('user.learnings.learnings_info', ['learning' => $learning->id]) }}">
                    {{ $learning->title }}
                </a>
            </h2>
            <p>{{ Str::limit($learning->description, 100) }}</p>
            @if($learning->tag)
            <span class="text-sm text-gray-500">{{ $learning->tag->name }}</span>
            @endif
        </div>
        @empty
        <p>このタイプの学習リソースはまだ登録されていません。</p>
        @endforelse
    </div>

    {{-- ページネーション --}}
    <div class="mt-4">
        {{ $learnings->links() }}
    </div>

    {{-- 一覧ページに戻るリンク --}}
    <div class="mt-4">
        <a href="{{ route('user.learnings.learnings_list') }}" class="btn btn-secondary">全件一覧に戻る</a>
    </div>

</div>
@endsection

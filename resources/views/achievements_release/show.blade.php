@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">実績解除詳細</h1>
        <div class="border p-4 rounded mb-4">
            <p><strong>ユーザーID:</strong> {{ $AchievementsRelease->user_id }}</p>
            <p><strong>実績マスタID:</strong> {{ $AchievementsRelease->achievement_master_id }}</p>
            <p><strong>達成日時:</strong> {{ $AchievementsRelease->unlocked_at }}</p>
            <p><strong>達成条件詳細:</strong> {{ $AchievementsRelease->condition_met }}</p>

        </div>
        <a href="{{ route('achievements_release.edit', $AchievementsRelease->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded">編集</a>
        <a href="{{ route('achievements_release.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">一覧に戻る</a>
    </div>
@endsection

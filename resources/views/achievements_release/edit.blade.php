@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">実績解除編集</h1>
        <form action="{{ route('achievements_release.update', $AchievementsRelease->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">ユーザーID</label>
                <input type="text" name="user_id" value="{{ old('user_id', $AchievementsRelease->user_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">実績マスタID</label>
                <input type="text" name="achievement_master_id"
                    value="{{ old('achievement_master_id', $AchievementsRelease->achievement_master_id ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">達成日時</label>
                <input type="text" name="unlocked_at"
                    value="{{ old('unlocked_at', $AchievementsRelease->unlocked_at ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">達成条件詳細</label>
                <input type="text" name="condition_met"
                    value="{{ old('condition_met', $AchievementsRelease->condition_met ?? '') }}"
                    class="border px-2 py-1 w-full rounded">
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
@endsection

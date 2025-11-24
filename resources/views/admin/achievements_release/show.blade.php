@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">実績解除詳細</h1>

        <table class="w-full table-auto border-collapse border mb-6">
            <tbody>
                {{-- ユーザー --}}
                <tr class="border-b">
                    <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">ユーザー</th>
                    <td class="px-4 py-2">{{ $AchievementsRelease->user->name ?? 'なし' }}</td>
                </tr>

                {{-- 実績 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">実績</th>
                    <td class="px-4 py-2">{{ $AchievementsRelease->achievement->title ?? 'なし' }}</td>
                </tr>

                {{-- 達成日時 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">達成日時</th>
                    <td class="px-4 py-2">{{ $AchievementsRelease->unlocked_at ?? 'なし' }}</td>
                </tr>

                {{-- 達成条件詳細 --}}
                <tr class="border-b">
                    <th class="px-4 py-2 bg-gray-100 text-right font-medium">達成条件詳細</th>
                    <td class="px-4 py-2">{{ $AchievementsRelease->condition_met ?? 'なし' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex gap-3">
            <a href="{{ route('admin.achievements_release.edit', $AchievementsRelease->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">編集</a>
            <a href="{{ route('admin.achievements_release.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
        </div>
    </div>
</div>
@endsection

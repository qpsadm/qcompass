@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">実績解除一覧</h1>
        <a href="{{ route('achievements_release.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

        <table class="table-auto border-collapse border w-full">
            <thead>
                <tr>
                    <th class='border px-4 py-2'>ユーザーID</th>
                    <th class='border px-4 py-2'>実績マスタID</th>
                    <th class='border px-4 py-2'>達成日時</th>
                    <th class='border px-4 py-2'>達成条件詳細</th>

                    <th class='border px-4 py-2'>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($achievements_release as $AchievementsRelease)
                    <tr>
                        <td class='border px-4 py-2'>{{ $AchievementsRelease->user_id }}</td>
                        <td class='border px-4 py-2'>{{ $AchievementsRelease->achievement_master_id }}</td>
                        <td class='border px-4 py-2'>{{ $AchievementsRelease->unlocked_at }}</td>
                        <td class='border px-4 py-2'>{{ $AchievementsRelease->condition_met }}</td>

                        <td class='border px-4 py-2'>
                            <a href="{{ route('achievements_release.show', $AchievementsRelease->id) }}"
                                class="text-green-600">詳細</a>
                            <a href="{{ route('achievements_release.edit', $AchievementsRelease->id) }}"
                                class="text-blue-600 ml-2">編集</a>
                            <form action="{{ route('achievements_release.destroy', $AchievementsRelease->id) }}"
                                method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">実績解除編集</h1>

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

        <form action="{{ route('admin.achievements_release.update', $AchievementsRelease->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="w-full table-auto border-collapse">
                <tbody>
                    {{-- ユーザー --}}
                    <tr class="border-b">
                        <th class="w-1/3 px-4 py-2 bg-gray-100 text-right font-medium">ユーザー</th>
                        <td class="px-4 py-2">
                            <select name="user_id" class="border rounded px-3 py-2 w-full">
                                <option value="">選択してください</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id', $AchievementsRelease->user_id) == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 実績 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">実績</th>
                        <td class="px-4 py-2">
                            <select name="achievement_master_id" class="border rounded px-3 py-2 w-full">
                                <option value="">選択してください</option>
                                @foreach($achievements as $achievement)
                                <option value="{{ $achievement->id }}" @selected(old('achievement_master_id', $AchievementsRelease->achievement_master_id) == $achievement->id)>{{ $achievement->title }}</option>
                                @endforeach
                            </select>
                            @error('achievement_master_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 達成日時 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">達成日時</th>
                        <td class="px-4 py-2">
                            <input type="datetime-local" name="unlocked_at"
                                value="{{ old('unlocked_at', $AchievementsRelease->unlocked_at ? date('Y-m-d\TH:i', strtotime($AchievementsRelease->unlocked_at)) : '') }}"
                                class="border rounded px-3 py-2 w-full">
                            @error('unlocked_at') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>

                    {{-- 達成条件詳細 --}}
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-gray-100 text-right font-medium">達成条件詳細</th>
                        <td class="px-4 py-2">
                            <input type="text" name="condition_met" value="{{ old('condition_met', $AchievementsRelease->condition_met) }}"
                                class="border rounded px-3 py-2 w-full">
                            @error('condition_met') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">更新</button>
                <a href="{{ route('admin.achievements_release.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">一覧に戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection

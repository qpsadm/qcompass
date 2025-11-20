@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 pb-24"> {{-- pb-24 でフッター分の余白 --}}
        <h1 class="text-2xl font-bold mb-6">権限一覧</h1>

        {{-- 権限一覧テーブル --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-700">
                        <th class="border-b px-4 py-2 text-center w-1/6">管理ID</th>
                        <th class="border-b px-4 py-2">役割名</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr class="hover:bg-gray-50" x-data="{ open: false, deleteName: '', deleteUrl: '' }">
                            <td class="border-b px-4 py-2 text-center">{{ $role->id }}</td>
                            <td class="border-b px-4 py-2">{{ $role->role_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">データがありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- x-cloak 用 --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection

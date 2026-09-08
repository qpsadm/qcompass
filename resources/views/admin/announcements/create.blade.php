@extends('layouts.app')

@section('content')
    <div class="container max-w-5xl">
        <div class="bg-white rounded-lg shadow-md p-6 mx-auto">

            <h1 class="text-2xl font-bold mb-6 text-gray-800">お知らせ 作成</h1>

            <form method="POST" action="{{ route('admin.announcements.store') }}">
                @csrf

                @include('admin.announcements.form')

                <button class="save bg-blue-600 text-white px-4 py-2 rounded">作成</button>

                <a href="{{ route('admin.announcements.index') }}"
                    class="back bg-red-400 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    一覧に戻る
                </a>
            </form>
        </div>
    </div>
@endsection

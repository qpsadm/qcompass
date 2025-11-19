@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">日報編集</h1>
            <form action="{{ route('admin.reports.update', $Report->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-medium mb-1">提出者ID</label>
                    <input type="text" name="user_id" value="{{ old('user_id', $Report->user_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">講座ID</label>
                    <input type="text" name="course_id" value="{{ old('course_id', $Report->course_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">日報対象日</label>
                    <input type="date" name="date" value="{{ old('date', $Report->date ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">タイトル</label>
                    <input type="text" name="title" value="{{ old('title', $Report->title ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">日報</label>
                    <input type="text" name="content" value="{{ old('content', $Report->content ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">感想・気づき・質問</label>
                    <input type="text" name="impression" value="{{ old('impression', $Report->impression ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">連絡事項</label>
                    <input type="text" name="notice" value="{{ old('notice', $Report->notice ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">作成者</label>
                    <input type="text" name="created_user_id"
                        value="{{ old('created_user_id', $Report->created_user_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">更新者</label>
                    <input type="text" name="updated_user_id"
                        value="{{ old('updated_user_id', $Report->updated_user_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">削除日</label>
                    <input type="text" name="deleted_at" value="{{ old('deleted_at', $Report->deleted_at ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">削除者</label>
                    <input type="text" name="deleted_user_id"
                        value="{{ old('deleted_user_id', $Report->deleted_user_id ?? '') }}"
                        class="border px-2 py-1 w-full rounded">
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">更新</button>
            </form>
        </div>
    @endsection

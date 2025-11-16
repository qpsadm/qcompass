@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Quiz詳細</h1>

    <div class="border p-6 rounded-lg space-y-3 bg-gray-50">
        <p><strong>コード:</strong> {{ $Quiz->code }}</p>
        <p><strong>タイトル:</strong> {{ $Quiz->title }}</p>
        <p><strong>説明:</strong> {{ $Quiz->description }}</p>
        <p><strong>コースID:</strong> {{ $Quiz->course_id }}</p>
        <p><strong>アジェンダID:</strong> {{ $Quiz->agenda_id }}</p>
        <p><strong>タイプ:</strong> {{ $Quiz->type }}</p>
        <p><strong>制限時間:</strong> {{ $Quiz->time_limit }}</p>
        <p><strong>合計点:</strong> {{ $Quiz->total_score }}</p>
        <p><strong>合格点:</strong> {{ $Quiz->passing_score }}</p>
        <p><strong>ランダム順:</strong> {{ $Quiz->random_order }}</p>
        <p><strong>有効開始:</strong> {{ $Quiz->active_from }}</p>
        <p><strong>有効終了:</strong> {{ $Quiz->active_to }}</p>
        <p><strong>作成者:</strong> {{ $Quiz->created_by }}</p>
        <p><strong>削除日時:</strong> {{ $Quiz->deleted_at }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.quizzes.edit', $Quiz->id) }}"
            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded shadow-sm transition">
            編集
        </a>
        <a href="{{ route('admin.quizzes.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow-sm transition">
            一覧に戻る
        </a>
    </div>
</div>
@endsection

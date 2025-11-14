@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">カテゴリー一覧</h1>

    @include('admin.categories.partials.category-tree', ['categories' => $categories])
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.toggle-children');

        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); // button type=submit 対策

                // li 内の子コンテナを取得
                const container = btn.closest('li').querySelector('.children-container');
                if (!container) return;

                // toggle hidden
                container.classList.toggle('hidden');

                // ボタンの回転
                btn.classList.toggle('rotate-90');
            });
        });
    });
</script>
<style>
    .rotate-90 {
        transform: rotate(90deg);
    }
</style>
@endsection

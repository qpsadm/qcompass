@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">部署 新規作成</h1>

    <form action="{{ route('admin.divisions.store') }}" method="POST">
        @include('admin.divisions.form')
    </form>
</div>
@endsection

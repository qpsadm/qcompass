@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <form action="{{ route('admin.divisions.update', $division->id) }}" method="POST">
        @method('PUT')
        @include('admin.divisions.form')
    </form>
</div>
@endsection

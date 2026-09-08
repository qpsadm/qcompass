@extends('layouts.app')

@section('content')
    <div class="container p-6">
        <form action="{{ route('admin.divisions.store') }}" method="POST">
            @include('admin.divisions.form')
        </form>
    </div>
@endsection

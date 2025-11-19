@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <!-- カード枠 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">開催者作成</h1>

            <form action="{{ route('admin.organizers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium mb-1">開催者名</label>
                    <input type="text" name="name" value="{{ old('name', $Organizer->name ?? '') }}"
                        class="border px-2 py-1 w-500 rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">保存</button>
            </form>
        </div>
    </div>
@endsection

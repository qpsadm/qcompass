@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">JobOffer一覧</h1>
    <a href="{{ route('job_offers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>title</th>
<th class='border px-4 py-2'>company</th>
<th class='border px-4 py-2'>file_path</th>
<th class='border px-4 py-2'>user_id</th>
<th class='border px-4 py-2'>deleted_at</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($job_offers as $JobOffer)
            <tr>
                <td class='border px-4 py-2'>{{ $JobOffer->title }}</td>
<td class='border px-4 py-2'>{{ $JobOffer->company }}</td>
<td class='border px-4 py-2'>{{ $JobOffer->file_path }}</td>
<td class='border px-4 py-2'>{{ $JobOffer->user_id }}</td>
<td class='border px-4 py-2'>{{ $JobOffer->deleted_at }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('job_offers.show', $JobOffer->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('job_offers.edit', $JobOffer->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('job_offers.destroy', $JobOffer->id) }}" method="POST" class="inline-block ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
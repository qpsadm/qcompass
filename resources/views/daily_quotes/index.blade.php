@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">DailyQuote一覧</h1>
    <a href="{{ route('daily_quotes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">新規作成</a>

    <table class="table-auto border-collapse border w-full">
        <thead>
            <tr>
                <th class='border px-4 py-2'>quote</th>
<th class='border px-4 py-2'>author</th>
<th class='border px-4 py-2'>display_date</th>
<th class='border px-4 py-2'>is_show</th>
<th class='border px-4 py-2'>deleted_at</th>

                <th class='border px-4 py-2'>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daily_quotes as $DailyQuote)
            <tr>
                <td class='border px-4 py-2'>{{ $DailyQuote->quote }}</td>
<td class='border px-4 py-2'>{{ $DailyQuote->author }}</td>
<td class='border px-4 py-2'>{{ $DailyQuote->display_date }}</td>
<td class='border px-4 py-2'>{{ $DailyQuote->is_show }}</td>
<td class='border px-4 py-2'>{{ $DailyQuote->deleted_at }}</td>

                <td class='border px-4 py-2'>
                    <a href="{{ route('daily_quotes.show', $DailyQuote->id) }}" class="text-green-600">詳細</a>
                    <a href="{{ route('daily_quotes.edit', $DailyQuote->id) }}" class="text-blue-600 ml-2">編集</a>
                    <form action="{{ route('daily_quotes.destroy', $DailyQuote->id) }}" method="POST" class="inline-block ml-2">
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
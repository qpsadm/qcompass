@extends('layouts.f_layout')

@section('title', '日報一覧')

@section('main-content')
    <h1>日報一覧</h1>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>日付</th>
                <th>タイトル</th>
                <th>日報</th>
                <th>感想・気付き・質問</th>
                <th>連絡事項</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->date }}</td>
                    <td>{{ $report->title }}</td>
                    <td>{{ $report->content }}</td>
                    <td>{{ $report->impression }}</td>
                    <td>{{ $report->notice }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">日報はありません</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

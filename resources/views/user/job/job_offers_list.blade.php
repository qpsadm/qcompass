@extends('layouts.f_layout')


@section('main-content')
    <div class="container">
        <x-f_page_title :search="false" title="求人一覧" />


        <div class="page-content">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">タイトル</th>
                        <th class="border px-4 py-2">説明文</th>
                        <th class="border px-4 py-2">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td class="border px-4 py-2">
                                <a href="{{ url('user/job/' . $job->id) }}" class="text-blue-600 underline">
                                    {{ $job->title }}
                                </a>
                            </td>
                            <td class="border px-4 py-2">{{ $job->description }}</td>
                            <td class="border px-4 py-2">
                                @if ($job->file_path)
                                    <a href="{{ asset($job->file_path) }}" target="_blank"
                                        class="text-blue-600 underline">PDF</a>
                                @else
                                    なし
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <x-f_btn_list :prevBtn="false" :listBtn="false" :nextBtn="false" />
        <x-f_bread_crumbs />
    </div>
@endsection

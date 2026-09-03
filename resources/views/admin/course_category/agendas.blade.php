@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-white rounded-lg shadow-md">

        {{-- タイトルと戻るボタン --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">{{ $course->course_name }} のアジェンダ一覧</h1>

            <a href="{{ url()->previous() }}"
                class="back px-4 py-3 bg-blue-600 text-white rounded hover:bg-gray-300 flex items-center space-x-1">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg> --}}
                <span>一覧画面に戻る</span>
            </a>
        </div>

        @foreach ($course->categories as $category)
            <div class="mt-6 p-4 border rounded bg-gray-100">
                <div class="font-semibold text-lg pb-1"><span class="text-sm text-gray-500">カテゴリ名：</span>{{ $category->name }}
                    ({{ $category->code }})
                </div>

                @if ($category->agendas->count())
                    <ul class="mt-2 space-y-2">
                        @foreach ($category->agendas as $agenda)
                            <li class="flex flex-row gap-4 items-center px-4 hover:bg-gray-100 transition w-full">
                                <span class="inline-block w-5 text-left">{{ $loop->iteration }}.</span>
                                <span class="inline-block w-1/3">
                                    <a href="{{ route('admin.agendas.preview', $agenda->id) }}" target="_blank"
                                        class="flex flex-row items-center text-blue-600 font-medium hover:underline">
                                        {{ $agenda->agenda_name }}
                                    </a>
                                </span>

                                <div class="flex flex-row justify-between items-center text-medium text-gray-600 gap-6">
                                    <div class="w-30 px-2 py-1">
                                        {{ $agenda->status === 'yes' ? '承認済み' : '下書き' }}
                                    </div>
                                    <div class="w-30">
                                        @if ($category->is_show)
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">表示</span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">非表示</span>
                                        @endif
                                    </div>

                                    <div class="px-2 py-1">
                                        更新日：{{ $agenda->updated_at->format('Y-m-d H:i') }}
                                    </div>
                                    <div class="px-2 py-1">
                                        更新者名：{{ $agenda->updated_user_name }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400 mt-2 italic">アジェンダなし</p>
                @endif
            </div>
        @endforeach

    </div>
@endsection

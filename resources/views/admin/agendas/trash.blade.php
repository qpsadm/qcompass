@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">アジェンダ（ゴミ箱）</h1>

    <a href="{{ route('admin.agendas.index') }}" class="text-blue-500 underline mb-4 inline-block">← 一覧へ戻る</a>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">アジェンダ名</th>
                    <th class="px-4 py-2 border">削除日</th>
                    <th class="px-4 py-2 border text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agendas as $agenda)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $agenda->agenda_name }}</td>
                    <td class="px-4 py-2 border">{{ $agenda->deleted_at }}</td>
                    <td class="px-4 py-2 border text-center flex gap-3 justify-center">

                        {{-- 復元 --}}
                        <form action="{{ route('admin.agendas.restore', $agenda->id) }}" method="POST">
                            @csrf
                            <button class="text-green-500 hover:underline">復元</button>
                        </form>

                    </td>
                </tr>
                @endforeach

                @if($agendas->isEmpty())
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">ゴミ箱は空です</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.print')

@section('content')
<h1>{{ $agenda->agenda_name }} </h1>
<h2>{{ $category->name }}</h2>

<div class="agenda-content">
    {!! $agenda->content !!}
</div>
@endsection

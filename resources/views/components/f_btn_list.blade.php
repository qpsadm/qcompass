@props([
'prevBtn',
'listBtn',
'nextBtn',
'listUrl',
'listLabel',
'prevUrl' => null,
'nextUrl' => null
])

<div class="btn-list">
    <ul>

        @if ($nextBtn)
        <li class="short-btn"><a href="{{ $nextUrl }}">前へ</a></li>
        @endif
        @if ($listBtn)
        <li class="default-btn"><a href="{{ $listUrl }}">{{ $listLabel }}</a></li>
        @endif
        @if ($prevBtn)
        <li class="short-btn"><a href="{{ $prevUrl }}">次へ</a></li>
        @endif


    </ul>
</div>

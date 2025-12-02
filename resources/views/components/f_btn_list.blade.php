<div class="btn-list">
    <ul>
        @if ($prevBtn)
            <li class="short-btn"><a href="{{}}">前へ</a></li>
        @endif

        @if ($listBtn)
            <li class="default-btn"><a href="{{ $listUrl }}">{{ $listLabel }}</a></li>
        @endif

        @if ($nextBtn)
            <li class="short-btn"><a href="">次へ</a></li>
        @endif

    </ul>
</div>

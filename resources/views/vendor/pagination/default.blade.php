@if ($paginator->hasPages())
    <a title="Total record">{{ $paginator->total() }}</a>
    @if ($paginator->onFirstPage())
        <a>上一页</a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}">上一页</a>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <b>{{ $element }}</b>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <b><i>{{ $page }}</i></b>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">下一页</a>
    @else
        <a>下一页</a>
    @endif
    <a href="{{ $paginator->url($paginator->lastPage()) }} ">尾页</a>
@endif
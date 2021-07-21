@if ($paginator->hasPages())
  <div>
    <div class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <a class="disabled btn btn-icon btn-sm btn-light-primary mr-2 my-1" aria-disabled="true"
            aria-label="@lang('pagination.previous')">
          <i class="ki ki-bold-arrow-back icon-xs"></i>
        </a>
      @else
        <a class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" href="{{ $paginator->previousPageUrl() }}" rel="prev"
           aria-label="@lang('pagination.previous')"><i class="ki ki-bold-arrow-back icon-xs"></i></a>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <a class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></a>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <a class="active btn btn-icon btn-sm border-0 btn-light mr-2 my-1 btn-hover-primary"
                 aria-current="page"><span>{{ $page }}</span></a>
            @else
              <a class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1 btn-hover-primary"
                 href="{{ $url }}">{{ $page }}</a>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
          <a class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i
              class="ki ki-bold-arrow-next icon-xs"></i></a>
      @else
        <a class="disabled btn btn-icon btn-sm btn-light-primary mr-2 my-1" aria-disabled="true"
            aria-label="@lang('pagination.next')">
          <i class="ki ki-bold-arrow-next icon-xs"></i>
        </a>
      @endif
    </div>
  </div>
@endif

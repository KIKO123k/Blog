@if ($paginator->hasPages())
    <nav class="pgn" role="navigation" aria-label="Pagination">
        <ul class="pgn-list">
            {{-- Précédent --}}
            @if ($paginator->onFirstPage())
                <li class="pgn-item pgn-disabled" aria-disabled="true"><span>‹</span></li>
            @else
                <li class="pgn-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Précédent">‹</a></li>
            @endif

            {{-- Numéros de page --}}
            @if (method_exists($paginator, 'elements'))
                @foreach ($elements ?? [] as $element)
                    @if (is_string($element))
                        <li class="pgn-item pgn-disabled"><span>{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="pgn-item pgn-active" aria-current="page"><span>{{ $page }}</span></li>
                            @else
                                <li class="pgn-item"><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif

            {{-- Suivant --}}
            @if ($paginator->hasMorePages())
                <li class="pgn-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Suivant">›</a></li>
            @else
                <li class="pgn-item pgn-disabled" aria-disabled="true"><span>›</span></li>
            @endif
        </ul>
    </nav>
@endif

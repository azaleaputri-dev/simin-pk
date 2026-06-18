<div class="surface-card h-100 {{ $class ?? '' }}">
    @isset($eyebrow)
        <div class="section-label mb-2">{{ $eyebrow }}</div>
    @endisset
    @isset($title)
        <h3 class="h5 mb-1">{{ $title }}</h3>
    @endisset
    @isset($description)
        <p class="text-muted mb-0">{{ $description }}</p>
    @endisset

    @if(trim($slot ?? '') !== '')
        <div class="{{ isset($title) || isset($description) || isset($eyebrow) ? 'mt-3' : '' }}">
            {!! $slot !!}
        </div>
    @endif
</div>

<div class="dashboard-hero @isset($banner) dashboard-hero-banner @endisset mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
        <div>
            @isset($eyebrow)
                <div class="section-label">{{ $eyebrow }}</div>
            @endisset
            <h1 class="dashboard-title mb-2">{{ $title }}</h1>
            @isset($description)
                <p class="dashboard-subtitle mb-0 text-muted">{{ $description }}</p>
            @endisset
        </div>
        @if(! empty($meta ?? []))
            <div class="dashboard-hero-meta text-lg-end">
                @foreach($meta as $item)
                    <div class="{{ $loop->first ? '' : 'mt-3' }}">
                        <div class="section-label">{{ $item['label'] }}</div>
                        <div class="{{ $item['muted'] ?? false ? 'fs-6 text-muted' : 'fs-5 fw-semibold' }}">
                            {{ $item['value'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

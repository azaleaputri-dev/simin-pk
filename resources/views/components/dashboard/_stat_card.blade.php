<div class="stat-card stat-card--dashboard reveal-on-load" @isset($countValue) data-count-value="{{ $countValue }}" @endisset @isset($countPrefix) data-count-prefix="{{ $countPrefix }}" @endisset @isset($countSuffix) data-count-suffix="{{ $countSuffix }}" @endisset>
    @isset($icon)
        <span class="stat-card-icon"><i class="bi {{ $icon }}"></i></span>
    @endisset
    <small>{{ $label }}</small>
    <strong class="stat-value">{{ $value }}</strong>
    @isset($hint)
        <div class="small text-muted mt-2">{{ $hint }}</div>
    @endisset
</div>

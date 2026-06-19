<div class="floating-chip-nav reveal-on-load">
    <a href="{{ route('parent.portal') }}" class="chip-link {{ request()->routeIs('parent.portal') ? 'is-active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
    </a>
    <a href="{{ route('parent.portal.ppdb.history') }}" class="chip-link {{ request()->routeIs('parent.portal.ppdb.history') ? 'is-active' : '' }}">
        <i class="bi bi-clock-history"></i><span>Riwayat PPDB</span>
    </a>
    <a href="{{ route('parent.portal.profile') }}" class="chip-link {{ request()->routeIs('parent.portal.profile') ? 'is-active' : '' }}">
        <i class="bi bi-person-vcard"></i><span>Profil</span>
    </a>
    <a href="{{ route('parent.portal.password') }}" class="chip-link {{ request()->routeIs('parent.portal.password') ? 'is-active' : '' }}">
        <i class="bi bi-shield-lock"></i><span>Ganti Password</span>
    </a>
</div>

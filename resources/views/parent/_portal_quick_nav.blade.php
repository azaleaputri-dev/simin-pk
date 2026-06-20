<div class="floating-chip-nav reveal-on-load">
    <a href="{{ route('parent.portal') }}" class="chip-link {{ request()->routeIs('parent.portal') ? 'is-active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
    </a>
    <a href="{{ route('parent.portal.invoices') }}" class="chip-link {{ request()->routeIs('parent.portal.invoices*') ? 'is-active' : '' }}">
        <i class="bi bi-receipt-cutoff"></i><span>Tagihan</span>
    </a>
    <a href="{{ route('parent.portal.payments') }}" class="chip-link {{ request()->routeIs('parent.portal.payments*') ? 'is-active' : '' }}">
        <i class="bi bi-cash-stack"></i><span>Pembayaran</span>
    </a>
    <a href="{{ route('parent.portal.children') }}" class="chip-link {{ request()->routeIs('parent.portal.children') ? 'is-active' : '' }}">
        <i class="bi bi-mortarboard-fill"></i><span>Data Anak</span>
    </a>
    <a href="{{ route('parent.portal.announcements') }}" class="chip-link {{ request()->routeIs('parent.portal.announcements') ? 'is-active' : '' }}">
        <i class="bi bi-megaphone-fill"></i><span>Pengumuman</span>
    </a>
    <a href="{{ route('parent.portal.contact') }}" class="chip-link {{ request()->routeIs('parent.portal.contact') ? 'is-active' : '' }}">
        <i class="bi bi-telephone-fill"></i><span>Kontak</span>
    </a>
    <a href="{{ route('parent.portal.profile') }}" class="chip-link {{ request()->routeIs('parent.portal.profile') ? 'is-active' : '' }}">
        <i class="bi bi-person-vcard"></i><span>Profil</span>
    </a>
    <a href="{{ route('parent.portal.password') }}" class="chip-link {{ request()->routeIs('parent.portal.password') ? 'is-active' : '' }}">
        <i class="bi bi-shield-lock"></i><span>Ganti Password</span>
    </a>
</div>

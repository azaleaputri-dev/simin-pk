<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIMIN-PK' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app-layout.css') }}" rel="stylesheet">
</head>
<body>
    @php($loggedInUser = auth()->user())
    @php($isGuardianUser = $loggedInUser?->isGuardianUser() ?? false)
    @php($sidebarHome = $isGuardianUser ? route('parent.portal') : route('admin.dashboard'))

    <div class="app-layout" id="appLayout">
        <div class="app-sidebar-backdrop" data-sidebar-close></div>

        <aside class="app-sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="{{ $sidebarHome }}">
                    <span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>
                    <span>
                        SIMIN-PK
                        <span class="sidebar-subtitle">Sistem sekolah terintegrasi</span>
                    </span>
                </a>
                <button type="button" class="btn btn-sm btn-outline-light sidebar-close" data-sidebar-close>Tutup</button>
            </div>

            <div class="sidebar-user">
                <span class="sidebar-avatar"><i class="bi {{ $isGuardianUser ? 'bi-person-circle' : 'bi-shield-lock-fill' }}"></i></span>
                <div>
                    <div class="fw-semibold">{{ $loggedInUser?->name ?? ($isGuardianUser ? 'User' : 'Admin') }}</div>
                    <div class="small text-white-50">{{ $isGuardianUser ? 'Portal Orang Tua / User' : 'Akses Admin Sekolah' }}</div>
                </div>
            </div>

            <div class="sidebar-nav">
                @if($isGuardianUser)
                    <div class="sidebar-group">
                        <div class="sidebar-label">Navigasi User</div>
                        <div class="sidebar-links">
                            <a href="{{ route('parent.portal') }}" class="sidebar-link {{ request()->routeIs('parent.portal*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                                <span>Portal Orang Tua</span>
                            </a>
                            <a href="{{ route('ppdb.register') }}" class="sidebar-link {{ request()->routeIs('ppdb.register') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-pencil-square"></i></span>
                                <span>Form PPDB</span>
                            </a>
                            <a href="{{ route('home') }}" class="sidebar-link">
                                <span class="sidebar-link-icon"><i class="bi bi-house-door-fill"></i></span>
                                <span>Beranda Publik</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="sidebar-group">
                        <div class="sidebar-label">Ringkasan</div>
                        <div class="sidebar-links">
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-speedometer2"></i></span>
                                <span>Dashboard Admin</span>
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-group">
                        <div class="sidebar-label">Master Sekolah</div>
                        <div class="sidebar-links">
                            <a href="{{ route('profil-sekolahs.index') }}" class="sidebar-link {{ request()->routeIs('profil-sekolahs.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-building"></i></span>
                                <span>Profil Sekolah</span>
                            </a>
                            <a href="{{ route('academic-years.index') }}" class="sidebar-link {{ request()->routeIs('academic-years.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-calendar-range"></i></span>
                                <span>Tahun Ajaran</span>
                            </a>
                            <a href="{{ route('kelas.index') }}" class="sidebar-link {{ request()->routeIs('kelas.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-diagram-3"></i></span>
                                <span>Kelas</span>
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-group">
                        <div class="sidebar-label">Akademik</div>
                        <div class="sidebar-links">
                            <a href="{{ route('ppdb.index') }}" class="sidebar-link {{ request()->routeIs('ppdb.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-people"></i></span>
                                <span>PPDB</span>
                            </a>
                            <a href="{{ route('parents.index') }}" class="sidebar-link {{ request()->routeIs('parents.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-person-hearts"></i></span>
                                <span>Orang Tua</span>
                            </a>
                            <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-person-badge"></i></span>
                                <span>Siswa</span>
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-group">
                        <div class="sidebar-label">Keuangan</div>
                        <div class="sidebar-links">
                            <a href="{{ route('fee-types.index') }}" class="sidebar-link {{ request()->routeIs('fee-types.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-tags"></i></span>
                                <span>Jenis Biaya</span>
                            </a>
                            <a href="{{ route('tariffs.index') }}" class="sidebar-link {{ request()->routeIs('tariffs.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-receipt"></i></span>
                                <span>Tarif</span>
                            </a>
                            <a href="{{ route('invoices.index') }}" class="sidebar-link {{ request()->routeIs('invoices.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-file-earmark-text"></i></span>
                                <span>Invoice</span>
                            </a>
                            <a href="{{ route('payments.index') }}" class="sidebar-link {{ request()->routeIs('payments.*') ? 'is-active' : '' }}">
                                <span class="sidebar-link-icon"><i class="bi bi-cash-coin"></i></span>
                                <span>Pembayaran</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light sidebar-logout">Logout</button>
                </form>
            </div>
        </aside>

        <div class="app-main">
            <div class="app-topbar">
                <button type="button" class="sidebar-toggle" data-sidebar-open><i class="bi bi-list"></i> Menu</button>
                <span class="topbar-user">
                    <span class="user-pill-badge text-dark bg-light"><i class="bi {{ $isGuardianUser ? 'bi-person-circle' : 'bi-shield-lock-fill' }}"></i></span>
                    <span class="small fw-semibold">{{ $loggedInUser?->name ?? ($isGuardianUser ? 'User' : 'Admin') }}</span>
                </span>
            </div>

            <main class="app-shell">
                <div class="container">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            function formatCount(value, prefix, suffix) {
                return (prefix || '') + new Intl.NumberFormat('id-ID').format(value) + (suffix || '');
            }

            document.querySelectorAll('[data-count-value]').forEach(function (card, index) {
                var target = Number(card.getAttribute('data-count-value') || 0);
                var prefix = card.getAttribute('data-count-prefix') || '';
                var suffix = card.getAttribute('data-count-suffix') || '';
                var valueNode = card.querySelector('.stat-value');

                if (!valueNode || !Number.isFinite(target)) {
                    return;
                }

                var duration = 900 + (index * 60);
                var start = 0;
                var startedAt = null;

                function tick(timestamp) {
                    if (startedAt === null) {
                        startedAt = timestamp;
                    }

                    var progress = Math.min((timestamp - startedAt) / duration, 1);
                    var current = Math.round(start + ((target - start) * progress));
                    valueNode.textContent = formatCount(current, prefix, suffix);

                    if (progress < 1) {
                        window.requestAnimationFrame(tick);
                    }
                }

                window.requestAnimationFrame(tick);
            });

            document.querySelectorAll('.reveal-on-load').forEach(function (node, index) {
                node.style.animationDelay = (index * 0.06) + 's';
            });

            document.querySelectorAll('[data-progress-width]').forEach(function (bar, index) {
                var width = Number(bar.getAttribute('data-progress-width') || 0);

                window.setTimeout(function () {
                    bar.style.width = Math.max(0, Math.min(width, 100)) + '%';
                }, 140 + (index * 60));
            });

            var tabButtons = document.querySelectorAll('[data-dashboard-tab]');
            var tabPanels = document.querySelectorAll('[data-dashboard-panel]');

            function activateDashboardTab(key) {
                tabButtons.forEach(function (button) {
                    button.classList.toggle('is-active', button.getAttribute('data-dashboard-tab') === key);
                });

                tabPanels.forEach(function (panel) {
                    var active = panel.getAttribute('data-dashboard-panel') === key;
                    panel.classList.toggle('d-none', !active);
                    panel.classList.toggle('is-active', active);
                });
            }

            tabButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    activateDashboardTab(button.getAttribute('data-dashboard-tab'));
                });
            });

            document.querySelectorAll('[data-filter-group]').forEach(function (group) {
                var key = group.getAttribute('data-filter-group');
                var container = document.querySelector('[data-filter-container="' + key + '"]');

                if (!container) {
                    return;
                }

                var items = container.querySelectorAll('[data-filter-item]');
                var buttons = group.querySelectorAll('[data-filter-value]');

                function applyFilter(value) {
                    buttons.forEach(function (button) {
                        button.classList.toggle('is-active', button.getAttribute('data-filter-value') === value);
                    });

                    items.forEach(function (item) {
                        var tag = item.getAttribute('data-filter-tag') || '';
                        var match = value === 'all' || tag === value;
                        item.classList.toggle('d-none', !match);
                    });
                }

                buttons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        applyFilter(button.getAttribute('data-filter-value'));
                    });
                });

                applyFilter('all');
            });

            var appLayout = document.getElementById('appLayout');
            var openSidebarButton = document.querySelector('[data-sidebar-open]');
            var closeSidebarButtons = document.querySelectorAll('[data-sidebar-close]');

            if (appLayout && openSidebarButton) {
                openSidebarButton.addEventListener('click', function () {
                    appLayout.classList.add('sidebar-open');
                });
            }

            closeSidebarButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    if (appLayout) {
                        appLayout.classList.remove('sidebar-open');
                    }
                });
            });

            document.querySelectorAll('[data-file-upload]').forEach(function (zone) {
                var input = zone.querySelector('[data-file-input]');
                var title = zone.querySelector('[data-file-title]');
                var preview = zone.querySelector('[data-file-preview]');

                if (!input || !title || !preview) {
                    return;
                }

                var defaultTitle = title.textContent;
                var defaultPreview = preview.innerHTML;
                var objectUrl = null;

                function displayFile(file) {
                    if (objectUrl) {
                        URL.revokeObjectURL(objectUrl);
                        objectUrl = null;
                    }

                    if (!file) {
                        title.textContent = defaultTitle;
                        preview.innerHTML = defaultPreview;
                        return;
                    }

                    title.textContent = file.name + ' • ' + (file.size / 1024 / 1024).toFixed(2) + ' MB';

                    if (file.type && file.type.startsWith('image/')) {
                        objectUrl = URL.createObjectURL(file);
                        preview.innerHTML = '';
                        var image = document.createElement('img');
                        image.src = objectUrl;
                        image.alt = 'Preview file';
                        preview.appendChild(image);
                        return;
                    }

                    preview.innerHTML = '<i class="bi bi-file-earmark-check file-upload-icon"></i>';
                }

                input.addEventListener('change', function () {
                    displayFile(input.files && input.files[0]);
                });

                ['dragenter', 'dragover'].forEach(function (eventName) {
                    zone.addEventListener(eventName, function (event) {
                        event.preventDefault();
                        zone.classList.add('is-dragging');
                    });
                });

                ['dragleave', 'drop'].forEach(function (eventName) {
                    zone.addEventListener(eventName, function (event) {
                        event.preventDefault();
                        zone.classList.remove('is-dragging');
                    });
                });

                zone.addEventListener('drop', function (event) {
                    if (!event.dataTransfer || !event.dataTransfer.files.length) {
                        return;
                    }

                    input.files = event.dataTransfer.files;
                    displayFile(input.files[0]);
                });
            });
        })();
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'InnovaCrown') — InnovaCrown</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 268px;
            --primary: #0f1729;
            --primary-light: #162038;
            --primary-lighter: #1c2a4a;
            --accent: #c9a96e;
            --accent-hover: #b8964f;
            --accent-light: rgba(201,169,110,.08);
            --surface: #ffffff;
            --surface-alt: #f4f6fa;
            --border: #e5e9f0;
            --border-light: #eef1f6;
            --text: #1a2332;
            --text-secondary: #5a6577;
            --text-muted: #8892a4;
            --success: #22c55e;
            --success-bg: #f0fdf4;
            --info: #3b82f6;
            --info-bg: #eff6ff;
            --warning: #f59e0b;
            --warning-bg: #fffbeb;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --purple: #7c3aed;
            --purple-bg: #f5f3ff;
            --shadow-xs: 0 1px 2px rgba(15,23,41,.04);
            --shadow-sm: 0 1px 3px rgba(15,23,41,.06), 0 1px 2px rgba(15,23,41,.04);
            --shadow-md: 0 4px 6px -1px rgba(15,23,41,.07), 0 2px 4px -2px rgba(15,23,41,.05);
            --shadow-lg: 0 10px 15px -3px rgba(15,23,41,.08), 0 4px 6px -4px rgba(15,23,41,.04);
            --shadow-xl: 0 20px 25px -5px rgba(15,23,41,.1), 0 8px 10px -6px rgba(15,23,41,.05);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--text);
            background: var(--surface-alt);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        a { text-decoration: none; color: inherit; }

        /* ─── Sidebar ─── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--primary);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent 0%, var(--accent) 30%, var(--accent) 70%, transparent 100%);
            opacity: .45;
        }

        .sidebar-brand {
            padding: 1.25rem 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--primary);
            flex-shrink: 0;
            letter-spacing: -0.5px;
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .sidebar-brand-text strong {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 600;
            color: #fff;
        }

        .sidebar-brand-text small {
            font-size: 10px;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 2.5px;
            font-weight: 500;
            margin-top: 1px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: .5rem 0;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-lighter) transparent;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--primary-lighter); border-radius: 4px; }

        .sidebar-section-label {
            padding: .85rem 1.25rem .35rem;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            opacity: .7;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .55rem 1.25rem;
            margin: 1px .65rem;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.6);
            font-size: 13px;
            font-weight: 500;
            transition: all .18s ease;
            cursor: pointer;
        }

        .sidebar-nav-item i {
            font-size: 17px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav-item:hover {
            color: #fff;
            background: rgba(255,255,255,.06);
        }

        .sidebar-nav-item.active {
            color: var(--primary);
            background: var(--accent);
            font-weight: 600;
        }

        .sidebar-nav-item.active i { color: var(--primary); }

        .sidebar-footer {
            padding: .75rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.06);
            font-size: 10px;
            color: var(--text-muted);
            opacity: .5;
        }

        /* ─── Main ─── */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Topbar ─── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            height: 64px;
            background: var(--surface);
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            transition: border-color .2s;
        }

        .topbar::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, var(--accent) 0%, transparent 100%);
            opacity: .25;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text);
            cursor: pointer;
            padding: .3rem;
            border-radius: 6px;
        }

        .topbar-toggle:hover { background: var(--surface-alt); }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .topbar-user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.25;
        }

        .topbar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-user-role {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: capitalize;
        }

        .topbar-logout {
            background: none;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: .35rem .6rem;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 15px;
            transition: all .18s ease;
            display: flex;
            align-items: center;
        }

        .topbar-logout:hover {
            color: var(--danger);
            border-color: var(--danger);
            background: var(--danger-bg);
        }

        /* ─── Content ─── */
        .content-area {
            flex: 1;
            padding: 2rem 2.5rem 2.5rem;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,41,.5);
            z-index: 1035;
            opacity: 0;
            transition: opacity .25s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* ─── Flash Messages ─── */
        .flash-message {
            padding: .85rem 1.1rem;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.25rem;
            animation: fadeInUp .35s ease both;
        }

        .flash-success {
            background: var(--success-bg);
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .flash-error {
            background: var(--danger-bg);
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .flash-info {
            background: var(--info-bg);
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .flash-warning {
            background: var(--warning-bg);
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* ─── Stat Card ─── */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            position: relative;
            overflow: hidden;
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent);
            opacity: 0;
            transition: opacity .22s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card:hover::after { opacity: 1; }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-blue .stat-card-icon { background: #eff6ff; color: #2563eb; }
        .stat-green .stat-card-icon { background: #f0fdf4; color: #16a34a; }
        .stat-amber .stat-card-icon { background: #fffbeb; color: #d97706; }
        .stat-red .stat-card-icon { background: #fef2f2; color: #dc2626; }
        .stat-purple .stat-card-icon { background: #f5f3ff; color: #7c3aed; }
        .stat-gold .stat-card-icon { background: var(--accent-light); color: var(--accent); }

        .stat-blue::after { background: #2563eb; }
        .stat-green::after { background: #16a34a; }
        .stat-amber::after { background: #d97706; }
        .stat-red::after { background: #dc2626; }
        .stat-purple::after { background: #7c3aed; }
        .stat-gold::after { background: var(--accent); }

        .stat-card-body { flex: 1; min-width: 0; }
        .stat-card-label { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-bottom: .25rem; }
        .stat-card-value { font-size: 24px; font-weight: 700; color: var(--text); font-family: 'Playfair Display', serif; }

        /* ─── Module Card ─── */
        .module-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform .22s ease, box-shadow .22s ease;
            cursor: pointer;
        }

        .module-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-hover));
            opacity: 0;
            transition: opacity .22s ease;
        }

        .module-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .module-card:hover::after { opacity: 1; }

        .module-icon {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }

        .module-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: .3rem;
        }

        .module-card-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.45;
        }

        /* ─── Table ─── */
        .table {
            font-size: 13px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .5px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border);
            padding: .7rem .85rem;
            background: var(--surface);
        }

        .table tbody td {
            padding: .7rem .85rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
        }

        .table tbody tr:hover { background: var(--surface-alt); }

        /* ─── Badge Status ─── */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: .3rem .7rem;
            border-radius: 50px;
            font-size: 11.5px;
            font-weight: 600;
            line-height: 1;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .badge-pendiente { background: #fffbeb; color: #b45309; }
        .badge-pendiente::before { background: #f59e0b; }

        .badge-confirmada { background: #eff6ff; color: #1d4ed8; }
        .badge-confirmada::before { background: #3b82f6; }

        .badge-completada { background: #f0fdf4; color: #15803d; }
        .badge-completada::before { background: #22c55e; }

        .badge-cancelada { background: #fef2f2; color: #b91c1c; }
        .badge-cancelada::before { background: #ef4444; }

        .badge-checkin { background: #f5f3ff; color: #6d28d9; }
        .badge-checkin::before { background: #7c3aed; }

        /* ─── Buttons ─── */
        .btn-primary {
            background: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: var(--radius-sm);
            padding: .5rem 1.15rem;
            font-size: 13px;
            font-weight: 600;
            transition: all .18s ease;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            color: #fff;
            box-shadow: 0 4px 12px rgba(201,169,110,.35);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: .5rem 1.15rem;
            font-size: 13px;
            font-weight: 500;
            transition: all .18s ease;
        }

        .btn-secondary:hover {
            background: var(--surface-alt);
            border-color: var(--text-muted);
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: .5rem 1.15rem;
            font-size: 13px;
            font-weight: 600;
            transition: all .18s ease;
        }

        .btn-danger:hover {
            background: #dc2626;
            box-shadow: 0 4px 12px rgba(239,68,68,.3);
        }

        /* ─── Forms ─── */
        .form-control, .form-select {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: .5rem .85rem;
            font-size: 13px;
            color: var(--text);
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(201,169,110,.12);
            outline: none;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: .3rem;
        }

        /* ─── Section Header ─── */
        .section-header {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.25rem;
        }

        .section-header-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--accent-light);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .section-header h4, .section-header h5 {
            margin: 0;
            font-size: 18px;
        }

        /* ─── Empty State ─── */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 48px;
            color: var(--text-muted);
            opacity: .4;
            margin-bottom: .75rem;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* ─── Card ─── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-xs);
        }

        .card-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border-light);
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 14px;
        }

        .card-body { padding: 1.25rem; }

        /* ─── Animations ─── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content-area > *:nth-child(1) { animation: fadeInUp .4s ease both; }
        .content-area > *:nth-child(2) { animation: fadeInUp .4s ease .05s both; }
        .content-area > *:nth-child(3) { animation: fadeInUp .4s ease .1s both; }
        .content-area > *:nth-child(4) { animation: fadeInUp .4s ease .15s both; }
        .content-area > *:nth-child(5) { animation: fadeInUp .4s ease .2s both; }
        .content-area > *:nth-child(6) { animation: fadeInUp .4s ease .25s both; }
        .content-area > *:nth-child(7) { animation: fadeInUp .4s ease .3s both; }
        .content-area > *:nth-child(8) { animation: fadeInUp .4s ease .35s both; }

        /* ─── Scrollbar Global ─── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 6px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        /* ─── Pagination ─── */
        .pagination .page-link {
            border: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 13px;
            border-radius: var(--radius-sm) !important;
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: var(--primary);
            font-weight: 600;
        }

        /* ─── Responsive ─── */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar-toggle { display: flex; }
            .content-area { padding: 1.25rem 1rem 1.5rem; }
            .topbar-user-info { display: none; }
        }

        @media (max-width: 575.98px) {
            .content-area { padding: 1rem .75rem 1.25rem; }
            .topbar { padding: 0 1rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    @php
        $userRole = auth()->user()->role ?? 'cliente';
        $dashboardRoute = match($userRole) {
            'admin' => 'admin.dashboard',
            'recepcionista' => 'recepcionista.dashboard',
            'cliente' => 'cliente.dashboard',
            default => 'admin.dashboard',
        };
        $userInitials = strtoupper(substr(explode(' ', auth()->user()->full_name ?? 'U')[0], 0, 1));
        if (str_word_count(auth()->user()->full_name ?? '') > 1) {
            $userInitials .= strtoupper(substr(explode(' ', auth()->user()->full_name)[1], 0, 1));
        }
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">IC</div>
            <div class="sidebar-brand-text">
                <strong>InnovaCrown</strong>
                <small>Hotel & Resort</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Principal</div>
            <a href="{{ route($dashboardRoute) }}" class="sidebar-nav-item {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            @if(in_array($userRole, ['admin', 'recepcionista']))
                <div class="sidebar-section-label">Gestión</div>
                <a href="{{ route('rooms.index') }}" class="sidebar-nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open-fill"></i>
                    <span>Habitaciones</span>
                </a>
                <a href="{{ route('room-types.index') }}" class="sidebar-nav-item {{ request()->routeIs('room-types.*') ? 'active' : '' }}">
                    <i class="bi bi-tag-fill"></i>
                    <span>Tipos de Habitación</span>
                </a>
                <a href="{{ route('clients.index') }}" class="sidebar-nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Clientes</span>
                </a>
                <a href="{{ route('reservations.index') }}" class="sidebar-nav-item {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Reservaciones</span>
                </a>

                <div class="sidebar-section-label">Operaciones</div>
                <a href="{{ route('checkins.index') }}" class="sidebar-nav-item {{ request()->routeIs('checkins.*') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Check-In / Check-Out</span>
                </a>
                <a href="{{ route('payments.index') }}" class="sidebar-nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card-fill"></i>
                    <span>Pagos</span>
                </a>
                <a href="{{ route('services.index') }}" class="sidebar-nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                    <i class="bi bi-concierge-bell-fill"></i>
                    <span>Servicios</span>
                </a>

                <div class="sidebar-section-label">Análisis</div>
                <a href="{{ route('reports.index') }}" class="sidebar-nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    <span>Reportes</span>
                </a>
                <a href="{{ route('historial.index') }}" class="sidebar-nav-item {{ request()->routeIs('historial.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Historial</span>
                </a>
            @endif

            @if($userRole === 'admin')
                <div class="sidebar-section-label">Administración</div>
                <a href="{{ route('panel.users.index') }}" class="sidebar-nav-item {{ request()->routeIs('panel.users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                    <span>Usuarios</span>
                </a>
                <a href="{{ route('panel.index') }}" class="sidebar-nav-item {{ request()->routeIs('panel.*') && !request()->routeIs('panel.users.*') && !request()->routeIs('panel.weather') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>Configuración</span>
                </a>
                <a href="{{ route('panel.weather') }}" class="sidebar-nav-item {{ request()->routeIs('panel.weather') ? 'active' : '' }}">
                    <i class="bi bi-cloud-sun-fill"></i>
                    <span>Clima</span>
                </a>
                <a href="{{ route('welcome') }}" class="sidebar-nav-item" target="_blank">
                    <i class="bi bi-globe2"></i>
                    <span>Ver Sitio Web</span>
                </a>
            @endif

            @if($userRole === 'cliente')
                <div class="sidebar-section-label">Mis Reservaciones</div>
                <a href="{{ route('my.reservations') }}" class="sidebar-nav-item {{ request()->routeIs('my.reservations') ? 'active' : '' }}">
                    <i class="bi bi-calendar-heart-fill"></i>
                    <span>Mis Reservas</span>
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">InnovaCrown v1.0</div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <button class="topbar-toggle" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="topbar-right">
                <div class="topbar-user">
                    <div class="topbar-avatar">{{ $userInitials }}</div>
                    <div class="topbar-user-info">
                        <span class="topbar-user-name">{{ auth()->user()->full_name ?? 'Usuario' }}</span>
                        <span class="topbar-user-role">{{ $userRole }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="topbar-logout" title="Cerrar sesión">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </header>

        <div class="content-area">
            @if(session('success'))
                <div class="flash-message flash-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flash-message flash-error">
                    <i class="bi bi-x-circle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="flash-message flash-info">
                    <i class="bi bi-info-circle-fill"></i>
                    {{ session('info') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="flash-message flash-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ session('warning') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var flashMessages = document.querySelectorAll('.flash-message');
            flashMessages.forEach(function(msg) {
                setTimeout(function() {
                    msg.style.transition = 'opacity .35s ease, transform .35s ease';
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-8px)';
                    setTimeout(function() { msg.remove(); }, 400);
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
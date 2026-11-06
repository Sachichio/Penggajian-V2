<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — gajiku.</title>

    <!-- Google Fonts: DM Sans & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;450;500;550;600;650;700&family=Manrope:wght@400;500;600;650;700;750;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"DM Sans"', 'sans-serif'],
                        display: ['"Manrope"', '"DM Sans"', 'sans-serif'],
                    },
                    colors: {
                        ocean: '#0F172A',
                        'ocean-lt': '#1E293B',
                        teal: '#14B8A6',
                        sand: '#F8FAFC',
                        canvas: '#f7f9f8',
                        ink: '#242d2a',
                        forest: '#326b4c',
                    }
                }
            }
        }
    </script>

    <!-- Exact Stylesheet from Desain Dashboard -->
    <style>
        body { font-family: 'DM Sans', sans-serif; color: #2b3330; background: #f7f9f8; font-size: 13px; -webkit-font-smoothing: antialiased; }
        button, a, input, select { -webkit-tap-highlight-color: transparent; }
        button, select { cursor: pointer; }
        button { transition: background .18s, color .18s, box-shadow .18s; }
        button:disabled { cursor: not-allowed; opacity: .55; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
        input, select { outline: none; }
        a { text-decoration: none; color: inherit; }

        .app-shell { min-height: 100vh; position: relative; }
        .sidebar { width: 244px; position: fixed; inset: 0 auto 0 0; background: #fff; border-right: 1px solid #e7ebe7; display: flex; flex-direction: column; padding: 24px 18px 24px; z-index: 40; overflow-y: auto; overflow-x: hidden; scrollbar-width: thin; scrollbar-color: #d8ded5 transparent; }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #d8ded5; border-radius: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .brand { display: flex; align-items: center; gap: 10px; font-family: 'Manrope', sans-serif; font-size: 29px; font-weight: 800; letter-spacing: -1.6px; padding: 0 8px; height: 39px; flex-shrink: 0; }
        .brand-dot { color: #4f8054; }
        .brand-symbol { display: flex; align-items: flex-end; gap: 3px; height: 26px; transform: rotate(-10deg); margin-right: 1px; }
        .brand-symbol span { width: 7px; height: 16px; background: #336b4b; border-radius: 3px; display: inline-block; }
        .brand-symbol span:nth-child(2) { height: 25px; background: #57835c; }
        .brand-symbol span:nth-child(3) { height: 20px; background: #a1b889; }
        .brand-tag { font: 600 7px 'DM Sans', sans-serif; letter-spacing: 1px; align-self: flex-end; margin: 0 0 8px -3px; color: #839087; }

        .workspace-switch { display: flex; align-items: center; gap: 9px; text-align: left; border: 1px solid #e7ebe7; border-radius: 8px; padding: 11px 9px; width: 100%; margin-top: 20px; background: #fcfdfb; flex-shrink: 0; }
        .company-icon { background: #edf0e8; color: #5e7450; height: 33px; width: 33px; display: grid; place-items: center; border-radius: 7px; flex-shrink: 0; }
        .workspace-switch strong { font-size: 10.5px; font-weight: 650; display: block; color: #232c25; }
        .workspace-switch small { color: #939b94; font-size: 9px; display: block; margin-top: 4px; }
        .workspace-switch > svg { margin-left: auto; color: #8f9891; }

        .nav-caption { font-size: 9px; font-weight: 600; letter-spacing: 1.35px; color: #949e97; padding: 20px 13px 10px; flex-shrink: 0; }
        .nav-item { display: flex; align-items: center; gap: 12px; height: 42px; padding: 0 13px; color: #6c756f; width: 100%; border-radius: 7px; margin-bottom: 4px; font-weight: 500; font-size: 12px; text-align: left; text-decoration: none; flex-shrink: 0; }
        .nav-item > svg { color: #879188; flex-shrink: 0; }
        .nav-item:hover { background: #f5f7f2; color: #242d2a; }
        .nav-item.active { background: #eaf1e5; color: #386245; font-weight: 650; }
        .nav-item.active > svg { color: #3e694d; }
        .nav-count { margin-left: auto; font-size: 10px; border: 1px solid #e7ebe7; color: #8a938c; border-radius: 4px; padding: 0 5px; line-height: 18px; }
        .active-dot { margin-left: auto; background: #42724b; width: 6px; height: 6px; border-radius: 50%; }
        .other-caption { padding-top: 18px; }

        .sidebar-bottom { margin-top: auto; padding-top: 18px; flex-shrink: 0; }

        .profile-card { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border: 1px solid #e7ebe7; border-radius: 9px; background: #fbfdfa; margin-bottom: 12px; transition: border-color .15s; }
        .profile-card:hover { border-color: #d8e2d4; }
        .profile-info { display: flex; align-items: center; gap: 10px; min-width: 0; }
        .profile-meta { min-width: 0; }
        .profile-meta strong { display: block; font-size: 11.5px; font-weight: 650; color: #253127; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.2; }
        .profile-meta small { color: #929a93; font-size: 9.5px; display: block; margin-top: 2px; line-height: 1.2; }
        .logout-icon-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 7px; border: 1px solid transparent; background: transparent; color: #879188; transition: all .18s; cursor: pointer; flex-shrink: 0; }
        .logout-icon-btn:hover { background: #fdf2f2; color: #dc2626; border-color: #fee2e2; }
        .avatar { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 650; flex-shrink: 0; }
        .admin-avatar { background: #e9eddc; color: #5d7450; position: relative; }
        .admin-avatar > span { width: 8px; height: 8px; background: #5a8a60; border: 2px solid white; border-radius: 50%; position: absolute; bottom: 0; right: 0; }
        .sidebar-copyright { font-size: 8px; color: #a0a79f; padding: 0 4px; }

        .main-shell { margin-left: 244px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { height: 77px; border-bottom: 1px solid #e7ebe7; background: #fff; display: flex; justify-content: space-between; align-items: center; padding: 0 34px; }
        .breadcrumb { display: flex; gap: 15px; align-items: center; font-size: 11px; color: #9aa19b; }
        .breadcrumb strong { font-weight: 500; color: #444e47; }
        .breadcrumb > svg { color: #aab1aa; }
        .topbar-actions { display: flex; align-items: center; gap: 19px; }
        .today { display: flex; align-items: center; gap: 8px; color: #818b82; font-size: 10px; }
        .today svg { color: #929d91; }
        .topbar-divider { height: 21px; border-left: 1px solid #e9ece6; }
        .icon-button { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; color: #879087; border-radius: 6px; background: transparent; border: none; }
        .icon-button:hover { background: #f0f3ec; }
        .notification-button { position: relative; }
        .notification-button i { position: absolute; background: #d5936d; width: 5px; height: 5px; border: 1px solid white; border-radius: 50%; top: 4px; right: 6px; }
        .top-avatar { width: 32px; height: 32px; background: #edf0e2; border: 3px solid #f5f6ed; border-radius: 50%; color: #71805b; font-size: 10px; font-weight: 650; display: inline-flex; align-items: center; justify-content: center; border: none; }
        .notification-wrap { position: relative; }
        .notification-panel { position: absolute; top: 43px; right: -40px; width: 310px; background: #fff; box-shadow: 0 12px 40px #23392918; border: 1px solid #e5e9e0; border-radius: 12px; z-index: 50; padding: 20px; }
        .notification-panel > strong { font-size: 15px; }
        .notification-panel p { margin-top: 19px; font-size: 12px; font-weight: 600; }
        .notification-panel small { display: block; color: #8a948c; margin: 5px 0 0 13px; font-size: 10px; }
        .notification-dot { display: inline-block; width: 6px; height: 6px; margin-right: 7px; border-radius: 50%; background: #477253; }
        .mobile-menu { display: none; }

        main { padding: 30px 34px 0; max-width: 1680px; width: 100%; margin: 0 auto; flex: 1; }
        .page-heading { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 27px; }
        .heading-eyebrow { color: #8a9989; font-size: 8px; font-weight: 600; letter-spacing: 1.5px; margin-bottom: 9px; text-transform: uppercase; }
        .page-heading h1 { font-weight: 750; font-size: clamp(20px, 1.65vw, 27px); letter-spacing: -.85px; line-height: 1.5; color: #222d26; }
        .page-heading p { font-size: 11px; color: #8a938c; margin-top: 5px; }
        .button { display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 7px; font-size: 11px; font-weight: 550; padding: 11px 15px; white-space: nowrap; text-decoration: none; }
        .primary { background: #326447; color: #fff; border: 1px solid #326447; box-shadow: 0 2px 3px #264d2910; }
        .primary:hover { background: #244f36; color: #fff; }
        .secondary { border: 1px solid #e2e7df; color: #687267; background: #fff; }
        .secondary:hover { background: #f5f7f1; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 17px; margin-bottom: 23px; }
        .stat-card { background: white; border: 1px solid #e5eae3; border-radius: 10px; padding: 17px 18px 14px; }
        .stat-top { display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #7f8981; }
        .stat-icon { height: 34px; width: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
        .green { background: #eaf1e6; color: #668258; }
        .blue { background: #eaf0f8; color: #6986ab; }
        .purple { background: #f0ebf8; color: #9581b7; }
        .peach { background: #f9eee6; color: #be9270; }
        .yellow { background: #f6f1dd; color: #b19b5c; }
        .stat-value { font-family: 'Manrope', sans-serif; font-weight: 750; font-size: 31px; letter-spacing: -1px; display: flex; align-items: baseline; margin-top: 3px; gap: 9px; color: #222d26; }
        .stat-value > span { font: 400 10px 'DM Sans', sans-serif; letter-spacing: 0; color: #9aa299; }
        .sparkline { margin-left: auto; align-self: center; color: #b8c6a8; width: 72px; height: 30px; }
        .spark-0 { color: #b8c6a8; }
        .spark-1 { color: #b3c8dc; }
        .spark-2 { color: #c2b3d9; }
        .spark-3 { color: #dbc4a9; }
        .stat-bottom { display: flex; align-items: center; gap: 5px; margin-top: 15px; white-space: nowrap; font-size: 8px; color: #a1a79f; }
        .trend-pill { color: #4d7950; background: #edf4e9; padding: 3px 5px; border-radius: 4px; display: inline-flex; align-items: center; gap: 3px; font-size: 8px; font-weight: 550; }
        .stat-indicator { display: inline-flex; align-items: center; gap: 4px; color: #7f8f7a; font-weight: 500; }
        .small-dot { height: 4px; width: 4px; border-radius: 50%; background: #93ae7a; }

        .panel { background: #fff; border: 1px solid #e5eae3; border-radius: 10px; overflow: hidden; }
        .table-heading { padding: 20px 21px 17px; display: flex; align-items: center; justify-content: space-between; }
        .table-heading h2 { display: flex; align-items: center; gap: 9px; font-size: 13px; font-weight: 750; letter-spacing: -.2px; color: #253127; }
        .table-heading p { font-size: 10px; color: #929b92; margin-top: 6px; }
        .count-badge { font: 500 8px 'DM Sans', sans-serif; background: #f0f3eb; border: 1px solid #e8eddf; color: #7f8d71; border-radius: 5px; padding: 3px 6px; }
        .export-button { font-size: 9px; padding: 8px 11px; gap: 6px; }
        .table-toolbar { border-top: 1px solid #eef0eb; padding: 13px 21px; display: flex; justify-content: space-between; gap: 15px; }
        .search-field { border: 1px solid #e6eae1; border-radius: 6px; display: flex; align-items: center; padding: 8px 10px; gap: 8px; width: 283px; color: #a2ab9b; }
        .search-field input { font-size: 10px; min-width: 0; flex: 1; background: transparent; color: #4d5b45; border: none; }
        .search-field input::placeholder { color: #a1a99b; }
        .search-field > span { color: #a7afa1; font-size: 8px; border: 1px solid #ebeee7; border-radius: 3px; padding: 1px 3px; white-space: nowrap; }
        .table-filters select { font-size: 9px; color: #89947f; padding: 8px 9px; border: 1px solid #e6eae1; border-radius: 5px; background: #fff; }

        .table-scroll { overflow-x: auto; }
        .table-panel table { width: 100%; text-align: left; border-collapse: collapse; white-space: nowrap; }
        .table-panel thead { background: #f8faf6; border-top: 1px solid #eef1e9; border-bottom: 1px solid #eef1e9; }
        .table-panel th { color: #85917b; font-size: 8px; font-weight: 500; padding: 12px 12px; }
        .table-panel td { padding: 12px; border-bottom: 1px solid #edf1e8; font-size: 10px; color: #7b8774; }
        .table-panel tr:last-child td { border-bottom: 0; }
        .table-panel tbody tr:hover { background: #fcfdf9; }
        .checkbox-cell { width: 43px; padding-left: 21px; padding-right: 6px; }
        .checkbox-cell input { appearance: none; width: 12px; height: 12px; border: 1px solid #dce3d4; border-radius: 3px; display: block; background: #fff; cursor: pointer; }
        .checkbox-cell input:checked { background: #4a7650; border-color: #4a7650; box-shadow: inset 0 0 0 2px white; }
        .employee-cell { display: flex; align-items: center; gap: 10px; text-align: left; }
        .employee-cell .avatar { width: 32px; height: 32px; font-size: 9px; }
        .employee-cell strong { color: #44533c; font-size: 10px; font-weight: 550; display: block; }
        .employee-cell small { display: block; margin-top: 4px; color: #a0a991; font-size: 8px; }
        .salary { color: #536548; font-weight: 600; font-size: 10px; }
        .status-badge { display: inline-flex; align-items: center; gap: 5px; color: #6f8c58; background: #f0f5e9; border: 1px solid #e7efde; border-radius: 4px; padding: 3px 6px; font-size: 8px; font-weight: 500; }
        .status-badge-rose { display: inline-flex; align-items: center; gap: 5px; color: #b94a48; background: #fdf2f2; border: 1px solid #f8d7da; border-radius: 4px; padding: 3px 6px; font-size: 8px; font-weight: 500; }
        .status-badge-amber { display: inline-flex; align-items: center; gap: 5px; color: #976d00; background: #fef9e7; border: 1px solid #fceec5; border-radius: 4px; padding: 3px 6px; font-size: 8px; font-weight: 500; }
        .status-check { background: #8ca66f; color: white; width: 10px; height: 10px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 8px; }
        .row-more { width: 23px; height: 23px; display: inline-flex; align-items: center; justify-content: center; background: none; border: none; color: #879188; }
        .form-card { background: #fff; border: 1px solid #e5eae3; border-radius: 10px; padding: 24px; }
        .action-icon-btn { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; border: 1px solid #e8ede4; background: #fbfdf9; color: #68756a; transition: all .15s; }
        .action-icon-btn:hover { background: #eaf1e5; color: #326447; border-color: #d2e0cb; }
        .action-icon-btn.danger:hover { background: #fdf2f2; color: #b94a48; border-color: #f8d7da; }
        .table-footer { padding: 15px 21px; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #edf1e8; color: #a1aa96; font-size: 8px; }
        .table-footer strong { color: #819074; font-weight: 500; }
        .table-footer a, .table-footer button { color: #658151; display: flex; align-items: center; gap: 7px; font-weight: 500; font-size: 9px; text-decoration: none; }

        .main-footer { padding: 21px 0 22px; display: flex; justify-content: space-between; align-items: center; color: #a3ad9b; font-size: 8px; margin-top: auto; }
        .main-footer > span:last-child { display: flex; align-items: center; gap: 5px; }
        .main-footer i { width: 4px; height: 4px; background: #93aa78; border-radius: 50%; display: inline-block; margin-right: 1px; }

        /* Responsive Media Queries from Desain Dashboard */
        @media (max-width: 1200px) {
            .sidebar { width: 220px; padding-left: 13px; padding-right: 13px; }
            .main-shell { margin-left: 220px; }
            .topbar { padding: 0 25px; }
            main { padding: 26px 25px 0; }
            .stats-grid { gap: 12px; }
            .stat-card { padding: 14px 13px; }
            .stat-value { font-size: 28px; }
            .sparkline { width: 53px; }
        }
        @media (max-width: 1000px) {
            .sidebar { width: 198px; padding-left: 10px; padding-right: 10px; }
            .main-shell { margin-left: 198px; }
            .brand { font-size: 27px; gap: 8px; }
            .brand-tag { display: none; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .table-panel table { min-width: 660px; }
        }
        @media (max-width: 760px) {
            .sidebar { transform: translateX(-100%); transition: transform .2s; width: 244px; padding-left: 18px; padding-right: 18px; }
            .sidebar.is-open { transform: translateX(0); }
            .sidebar-backdrop { position: fixed; inset: 0; z-index: 35; background: #20352660; backdrop-filter: blur(2px); }
            .main-shell { margin-left: 0; }
            .mobile-menu { display: inline-flex; }
            .topbar { height: 65px; padding: 0 20px; }
            main { padding: 25px 20px 0; }
        }
    </style>
</head>
<body>

<div class="app-shell">

    {{-- Mobile Backdrop --}}
    <div id="sidebar-backdrop" class="sidebar-backdrop hidden" onclick="toggleSidebar()"></div>

    {{-- ========================================================= --}}
    {{-- SIDEBAR UTAMA (PERSIS GAMBAR 1 & DESAIN DASHBOARD)       --}}
    {{-- ========================================================= --}}
    <aside id="app-sidebar" class="sidebar">
        {{-- Brand --}}
        <a href="{{ route('dashboard') }}" class="brand">
            <span class="brand-symbol">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span>
                gajiku<span class="brand-dot">.</span>
            </span>
            <span class="brand-tag">WORKSPACE</span>
        </a>

        {{-- Workspace Switcher Button --}}
        <div class="workspace-switch">
            <span class="company-icon">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="7" width="18" height="14" rx="2" />
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12a22 22 0 0 0 18 0M12 11v4" />
                </svg>
            </span>
            <span>
                <strong>PT. Sejahtera Bersama</strong>
                <small>Workspace perusahaan</small>
            </span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 5 7 7-7 7" />
            </svg>
        </div>

        {{-- Menu Utama --}}
        <div class="nav-caption">MENU UTAMA</div>
        <nav aria-label="Navigasi utama">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" />
                    <rect x="14" y="3" width="7" height="7" rx="1.5" />
                    <rect x="3" y="14" width="7" height="7" rx="1.5" />
                    <rect x="14" y="14" width="7" height="7" rx="1.5" />
                </svg>
                <span>Dashboard</span>
                @if(request()->routeIs('dashboard'))
                <span class="active-dot"></span>
                @endif
            </a>

            {{-- Data Karyawan --}}
            <a href="{{ route('karyawan.index') }}" class="nav-item {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m20 0v-2a4 4 0 0 0-3-3.87M16 3a4 4 0 0 1 0 8" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
                <span>Data Karyawan</span>
                <span class="nav-count">{{ \App\Models\Karyawan::where('status', 'Aktif')->count() }}</span>
                @if(request()->routeIs('karyawan.*'))
                <span class="active-dot"></span>
                @endif
            </a>

            {{-- Data Jabatan --}}
            <a href="{{ route('jabatan.index') }}" class="nav-item {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="7" width="18" height="14" rx="2" />
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12a22 22 0 0 0 18 0M12 11v4" />
                </svg>
                <span>Data Jabatan</span>
                @if(request()->routeIs('jabatan.*'))
                <span class="active-dot"></span>
                @endif
            </a>

            {{-- Presensi & Cuti --}}
            <a href="{{ route('presensi.index') }}" class="nav-item {{ request()->routeIs('presensi.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                </svg>
                <span>Presensi & Cuti</span>
                @if(request()->routeIs('presensi.*'))
                <span class="active-dot"></span>
                @endif
            </a>

            {{-- Penggajian --}}
            <a href="{{ route('penggajian.index') }}" class="nav-item {{ request()->routeIs('penggajian.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 8V5a2 2 0 0 0-2-2L5 6a3 3 0 0 0 0 6h16v8H5a3 3 0 0 1-3-3V9m19 3V8H6" />
                    <path d="M17 15h4v3h-4z" />
                </svg>
                <span>Penggajian</span>
                @if(request()->routeIs('penggajian.*'))
                <span class="active-dot"></span>
                @endif
            </a>

            {{-- Slip Gaji --}}
            <a href="{{ route('slip-gaji.index') }}" class="nav-item {{ request()->routeIs('slip-gaji.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M8 13h8M8 17h5" />
                </svg>
                <span>Slip Gaji</span>
                @if(request()->routeIs('slip-gaji.*'))
                <span class="active-dot"></span>
                @endif
            </a>

            {{-- Laporan --}}
            <a href="{{ route('laporan.index') }}" class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 3v17h17M8 15v-4m5 4V7m5 8V4" />
                </svg>
                <span>Laporan</span>
                @if(request()->routeIs('laporan.*'))
                <span class="active-dot"></span>
                @endif
            </a>

            {{-- Profil Perusahaan (White-Label Dynamic Company) --}}
            <a href="{{ route('company.edit') }}" class="nav-item {{ request()->routeIs('company.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21h18M9 8h1m4 0h1m-5 4h1m4 0h1m-5 4h1m4 0h1M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16" />
                </svg>
                <span>Profil Perusahaan</span>
                @if(request()->routeIs('company.*'))
                <span class="active-dot"></span>
                @endif
            </a>
        </nav>

        {{-- Bottom Sidebar: Unified Profile Card with Logout --}}
        <div class="sidebar-bottom">
            <div class="profile-card">
                <div class="profile-info">
                    <span class="avatar admin-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                        <span></span>
                    </span>
                    <div class="profile-meta">
                        <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                        <small>{{ ucfirst(auth()->user()->role ?? 'Administrator') }}</small>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-icon-btn" title="Keluar dari akun">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4m6 5 5 4-5 4m-7-4h12" />
                        </svg>
                    </button>
                </form>
            </div>

            <p class="sidebar-copyright">© 2026 Gajiku. All rights reserved.</p>
        </div>
    </aside>

    {{-- ========================================================= --}}
    {{-- SHELL KONTEN UTAMA (TOPBAR + CONTENT)                     --}}
    {{-- ========================================================= --}}
    <div class="main-shell">
        {{-- Topbar Header (Persis Gambar 1) --}}
        <header class="topbar">
            <div class="breadcrumb">
                <button class="mobile-menu icon-button" aria-label="Buka menu" onclick="toggleSidebar()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18M3 12h18M3 18h18" />
                    </svg>
                </button>
                <span>Workspace</span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 5 7 7-7 7" />
                </svg>
                <strong>@yield('title', 'Dashboard')</strong>
            </div>

            <div class="topbar-actions">
                <span class="today">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 11h18m-13 4h2m4 0h2" />
                    </svg>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
                <span class="topbar-divider"></span>
                <div class="notification-wrap">
                    <button class="icon-button notification-button" aria-label="Notifikasi" onclick="toggleNotifications()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4" />
                        </svg>
                        <i></i>
                    </button>
                    <div id="notification-panel" class="notification-panel hidden">
                        <strong>Notifikasi</strong>
                        <p><span class="notification-dot"></span> Penggajian Juli siap diproses</p>
                        <small>Pastikan data karyawan sudah sesuai.</small>
                        <p><span class="notification-dot"></span> Selamat datang di Gajiku</p>
                        <small>Kelola penggajian tim dengan lebih mudah.</small>
                    </div>
                </div>

                {{-- Profile Wrap & Dropdown --}}
                <div class="relative">
                    <button class="top-avatar" aria-label="Profil administrator" onclick="toggleProfileDropdown()">
                        {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                    </button>
                    <div id="profile-dropdown" class="hidden absolute right-0 top-11 w-52 bg-white rounded-xl shadow-[0_10px_35px_rgba(35,70,49,0.12)] border border-[#e5eae3] py-2 z-50">
                        <div class="px-4 py-2 border-b border-[#edf1e8]">
                            <p class="text-[12px] font-bold text-ink leading-tight">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-[10px] text-[#8a948c] mt-0.5 truncate">{{ auth()->user()->email ?? 'admin@gmail.com' }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="pt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-[11px] font-semibold text-red-600 hover:bg-red-50 text-left transition-colors">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4m6 5 5 4-5 4m-7-4h12" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Dynamic Content --}}
        <main>
            @yield('content')
        </main>
    </div>

</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('app-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        sidebar.classList.toggle('is-open');
        backdrop.classList.toggle('hidden');
    }

    function toggleNotifications() {
        const panel = document.getElementById('notification-panel');
        panel.classList.toggle('hidden');
        // Tutup profile dropdown jika sedang terbuka
        const profileDropdown = document.getElementById('profile-dropdown');
        if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
            profileDropdown.classList.add('hidden');
        }
    }

    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.classList.toggle('hidden');
        // Tutup notification panel jika sedang terbuka
        const notifPanel = document.getElementById('notification-panel');
        if (notifPanel && !notifPanel.classList.contains('hidden')) {
            notifPanel.classList.add('hidden');
        }
    }

    // Klik di luar dropdown untuk menutup
    document.addEventListener('click', function(event) {
        const profileDropdown = document.getElementById('profile-dropdown');
        const notifPanel = document.getElementById('notification-panel');
        const isClickInsideProfile = event.target.closest('.relative') && (event.target.closest('.top-avatar') || event.target.closest('#profile-dropdown'));
        const isClickInsideNotif = event.target.closest('.notification-wrap');

        if (!isClickInsideProfile && profileDropdown && !profileDropdown.classList.contains('hidden')) {
            profileDropdown.classList.add('hidden');
        }
        if (!isClickInsideNotif && notifPanel && !notifPanel.classList.contains('hidden')) {
            notifPanel.classList.add('hidden');
        }
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin panel') — Turon odob-ilm maktabi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: system-ui, -apple-system, sans-serif;
            background: #fefce8;
        }

        .app { display: flex; min-height: 100vh; }

        .overlay { display: none; }

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            transition: transform 0.25s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid #e5e7eb;
            background: #fefce8;
        }
        .sidebar-brand .logo {
            display: inline-flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            border-radius: 10px;
            background: #166534;
            color: #fff;
            font-size: 16px; font-weight: 800;
            margin-bottom: 8px;
        }
        .sidebar-brand h1 { font-size: 0.9rem; color: #166534; font-weight: 700; line-height: 1.3; }
        .sidebar-brand small { font-size: 0.75rem; color: #a16207; font-weight: 600; }

        .sidebar-nav { flex: 1; padding: 8px; overflow-y: auto; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #374151;
            text-decoration: none;
            font-size: 0.85rem; font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }
        .sidebar-nav a:hover { background: #fefce8; color: #854d0e; }
        .sidebar-nav a.active { background: #fefce8; color: #a16207; font-weight: 700; }

        .sidebar-nav .nav-label {
            font-size: 0.7rem; font-weight: 600; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 0.05em;
            padding: 16px 14px 6px;
        }

        .main {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 24px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            gap: 12px;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar h2 { font-size: 1rem; color: #854d0e; font-weight: 700; }
        .topbar .breadcrumb { font-size: 0.8rem; color: #9ca3af; }
        .topbar .breadcrumb span { color: #6b7280; }

        .hamburger {
            display: none; background: none; border: none; cursor: pointer;
            padding: 4px; color: #854d0e;
        }
        .hamburger svg { width: 24px; height: 24px; }

        .topbar-right { display: flex; align-items: center; gap: 16px; position: relative; }
        .topbar-date { font-size: 0.8rem; color: #9ca3af; white-space: nowrap; }

        .user-dropdown { position: relative; }
        .user-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 12px 6px 6px;
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            cursor: pointer;
            font-family: inherit;
            transition: border-color 0.15s;
        }
        .user-btn:hover { border-color: #a16207; }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 8px;
            background: #a16207; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
        }
        .user-btn .user-name-text { font-size: 0.85rem; font-weight: 600; color: #111827; }
        .user-btn .user-arrow { font-size: 0.6rem; color: #9ca3af; transition: transform 0.2s; }
        .user-btn.open .user-arrow { transform: rotate(180deg); }

        .user-menu {
            display: none;
            position: absolute; top: calc(100% + 6px); right: 0;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            min-width: 180px;
            z-index: 100;
            padding: 6px;
        }
        .user-menu.show { display: block; }
        .user-menu a, .user-menu button {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 10px 14px;
            border: none; border-radius: 8px;
            background: none;
            font-size: 0.85rem; font-weight: 500; color: #374151;
            text-decoration: none; cursor: pointer;
            font-family: inherit;
            transition: background 0.15s;
        }
        .user-menu a:hover, .user-menu button:hover { background: #fefce8; color: #854d0e; }
        .user-menu .menu-divider { height: 1px; background: #e5e7eb; margin: 4px 8px; }
        .user-menu .menu-logout { color: #dc2626; }
        .user-menu .menu-logout:hover { background: #fef2f2; color: #b91c1c; }
        .user-menu .menu-role {
            padding: 8px 14px 4px;
            font-size: 0.7rem; color: #a16207; font-weight: 600;
        }

        .content {
            padding: 24px 32px;
            flex: 1;
            animation: fadeUp 0.3s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .success {
            padding: 12px 16px;
            border-radius: 10px;
            background: #fefce8;
            color: #854d0e;
            border: 1px solid #fde68a;
            font-size: 0.85rem;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
        }
        .error {
            padding: 12px 16px;
            border-radius: 10px;
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            font-size: 0.85rem;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .hamburger { display: block; }
            .overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(0,0,0,0.3); z-index: 98;
            }
            .overlay.show { display: block; }
            .sidebar {
                position: fixed; top: 0; left: 0; z-index: 99;
                transform: translateX(-100%);
            }
            .sidebar.open { transform: translateX(0); }
            .topbar { padding: 10px 16px; }
            .content { padding: 16px; }
            .topbar-date { display: none; }
            .user-btn .user-name-text { display: none; }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar { width: 64px; }
            .sidebar-brand h1,
            .sidebar-brand small,
            .sidebar-nav a span { display: none; }
            .sidebar-nav a { justify-content: center; padding: 10px; }
            .sidebar-brand { padding: 16px 0; text-align: center; }
            .sidebar-brand .logo { margin-bottom: 0; }
            .topbar { padding: 12px 20px; }
            .content { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="app">
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="logo">T</div>
            <h1>Turon odob-ilm maktabi</h1>
            <small>Admin panel</small>
        </div>

        <div class="sidebar-nav">
            <div class="nav-label">Asosiy</div>
            <a href="/" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="/students" class="{{ request()->is('students*') && !request()->is('students/*/edit') && !request()->is('students/create') && !request()->is('students/import') && !request()->is('students/*/profile') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>O'quvchilar</span>
            </a>
            <a href="/attendance" class="{{ request()->is('attendance*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                <span>Davomat</span>
            </a>
            <a href="/classrooms" class="{{ request()->is('classrooms*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                <span>Guruhlar</span>
            </a>
            <a href="/enrollments" class="{{ request()->is('enrollments*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Biriktirish</span>
            </a>
            <a href="/teachers" class="{{ request()->is('teachers*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <span>O'qituvchilar</span>
            </a>
            <a href="/schedules" class="{{ request()->is('schedules*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>Dars jadvali</span>
            </a>

            @if(auth()->user()->isSuperAdmin())
                <div class="nav-label">Boshqaruv</div>
                <a href="/admin/users" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span>Adminlar</span>
                </a>
            @endif

            <div class="nav-label">Hisob</div>
            <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>Profil</span>
            </a>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <button class="hamburger" onclick="toggleSidebar()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div>
                    <h2>@yield('heading', 'Admin panel')</h2>
                    <div class="breadcrumb">Turon odob-ilm maktabi / <span>@yield('heading', 'Panel')</span></div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-date">{{ now()->format('d.m.Y') }}</div>
                <div class="user-dropdown">
                    <button class="user-btn" onclick="toggleUserMenu()">
                        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <span class="user-name-text">{{ auth()->user()->name }}</span>
                        <span class="user-arrow">▼</span>
                    </button>
                    <div class="user-menu" id="userMenu">
                        <div class="menu-role">{{ auth()->user()->role === 'super_admin' ? 'Super admin' : 'Admin' }}</div>
                        <a href="/profile">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profil
                        </a>
                        <div class="menu-divider"></div>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="menu-logout">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Chiqish
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }

    function toggleUserMenu() {
        document.getElementById('userMenu').classList.toggle('show');
        document.querySelector('.user-btn').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-dropdown')) {
            document.getElementById('userMenu').classList.remove('show');
            document.querySelector('.user-btn')?.classList.remove('open');
        }
    });
</script>

</body>
</html>

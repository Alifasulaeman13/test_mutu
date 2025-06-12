<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIMMUTU RS AZRA</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary-color: #007774;
            --primary-dark: #006663;
            --primary-light: #008885;
            --secondary-color: #e2e8f0;
            --text-color: #1b1b18;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Instrument Sans', sans-serif; 
            background: #f8fafc; 
            color: var(--text-color);
            min-height: 100vh;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            padding: 0;
            position: fixed;
            height: 100vh;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            padding: 1rem;
            border-bottom: 1px solid var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-weight: 600;
            color: var(--text-color);
        }

        .profile-status {
            font-size: 0.875rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
        }

        .menu-container {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .menu-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.75rem;
        }

        .menu-list {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 0.25rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            text-decoration: none;
            color: var(--text-color);
            border-radius: 6px;
            transition: all 0.2s;
            font-size: 0.875rem;
            position: relative;
        }

        .menu-link:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        .menu-link.active {
            background: var(--primary-color);
            color: white;
        }

        .menu-icon {
            margin-right: 0.75rem;
            font-size: 1.25rem;
            width: 1.25rem;
            text-align: center;
            opacity: 0.8;
        }

        .menu-link:hover .menu-icon {
            opacity: 1;
        }

        .menu-badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 0.75rem;
            padding: 0.125rem 0.375rem;
            border-radius: 9999px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
        }

        .content-header {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--secondary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-weight: 600;
            color: var(--text-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        .logout-btn { 
            background: var(--primary-dark);
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: var(--primary-color);
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }

        /* Additional styles from child pages */
        @yield('styles')

        /* Menu Arrow Styles */
        .menu-arrow {
            margin-left: auto;
            font-size: 1.25rem;
            opacity: 0.5;
            transition: transform 0.2s;
        }

        .menu-link:hover .menu-arrow {
            opacity: 1;
        }

        .menu-link.active .menu-arrow {
            transform: rotate(90deg);
            opacity: 1;
        }

        /* Menu Link with Arrow */
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            text-decoration: none;
            color: var(--text-color);
            border-radius: 6px;
            transition: all 0.2s;
            font-size: 0.875rem;
            position: relative;
        }

        .menu-link:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        .menu-link.active {
            background: var(--primary-color);
            color: white;
        }

        .menu-icon {
            margin-right: 0.75rem;
            font-size: 1.25rem;
            width: 1.25rem;
            text-align: center;
            opacity: 0.8;
        }

        .menu-link:hover .menu-icon {
            opacity: 1;
        }

        /* Menu Item Spacing */
        .menu-item {
            margin-bottom: 0.25rem;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .menu-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.75rem;
        }

        /* Submenu Styles */
        .submenu {
            display: none;
            padding-left: 2.5rem;
            margin-top: 0.25rem;
        }

        .submenu.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        .submenu.nested {
            padding-left: 1.5rem;
        }

        .submenu-item {
            margin-bottom: 0.25rem;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            color: #64748b;
            border-radius: 6px;
            transition: all 0.2s;
            font-size: 0.8125rem;
        }

        .submenu-link:hover {
            color: var(--primary-color);
            background: #f1f5f9;
        }

        .submenu-icon {
            margin-right: 0.75rem;
            font-size: 1.125rem;
            width: 1.125rem;
            text-align: center;
            opacity: 0.8;
        }

        .submenu-arrow {
            margin-left: auto;
            font-size: 1.125rem;
            opacity: 0.5;
            transition: transform 0.2s;
        }

        .menu-link.has-submenu.active + .submenu {
            display: block;
        }

        .menu-link.has-submenu.active .menu-arrow,
        .submenu-link.has-submenu.active .submenu-arrow {
            transform: rotate(90deg);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <i class="ri-heart-pulse-fill text-2xl"></i>
                <h1 class="text-lg font-semibold">SIMMUTU RS AZRA</h1>
            </div>

            <div class="user-profile">
                <div class="profile-image">
                    <i class="ri-user-line"></i>
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ session('user_name') }}</div>
                    <div class="profile-status">
                        <span class="status-indicator"></span>
                        @if(session('user_role'))
                            {{ ucfirst(session('user_role')) }}
                        @else
                            Online
                        @endif
                    </div>
                </div>
            </div>

            <div class="menu-container">
                <div class="menu-section">
                    <div class="menu-section-title">Menu Utama</div>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="/dashboard" class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="ri-dashboard-line menu-icon"></i>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="menu-section">
                    <div class="menu-section-title">Menu</div>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="#" class="menu-link has-submenu" onclick="toggleSubmenu(event, 'manajemenMutuSubmenu')">
                                <i class="ri-database-2-line menu-icon"></i>
                                Manajemen Data Mutu
                                <i class="ri-arrow-right-s-line menu-arrow"></i>
                            </a>
                            <ul class="submenu" id="manajemenMutuSubmenu">
                                <li class="submenu-item">
                                    <a href="#" class="submenu-link has-submenu" onclick="toggleSubmenu(event, 'masterIndikatorSubmenu')">
                                        <i class="ri-star-line submenu-icon"></i>
                                        Master Indikator Mutu
                                        <i class="ri-arrow-right-s-line submenu-arrow"></i>
                                    </a>
                                    <ul class="submenu nested" id="masterIndikatorSubmenu">
                                        <li>
                                            <a href="{{ route('master-indikator.index') }}" class="submenu-link {{ request()->routeIs('master-indikator.index') ? 'active' : '' }}">
                                                <i class="ri-list-check-2 submenu-icon"></i>
                                                Master Indikator
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('master-indikator.formula.index') }}" class="submenu-link {{ request()->routeIs('master-indikator.formula.*') ? 'active' : '' }}">
                                                <i class="ri-functions submenu-icon"></i>
                                                Formula
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu-item">
                                    <a href="{{ route('laporan-analisis.index') }}" class="submenu-link {{ request()->routeIs('laporan-analisis.*') ? 'active' : '' }}">
                                        <i class="ri-file-chart-line submenu-icon"></i>
                                        Laporan dan Analisis
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="menu-section">
                    <div class="menu-section-title">Pengaturan</div>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <i class="ri-database-2-line menu-icon"></i>
                                Database
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <i class="ri-building-2-line menu-icon"></i>
                                Unit
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('master-users.index') }}" class="menu-link {{ request()->routeIs('master-users.*') ? 'active' : '' }}">
                                <i class="ri-user-settings-line menu-icon"></i>
                                Manajemen User
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('manage-role.index') }}" class="menu-link {{ request()->routeIs('manage-role.*') ? 'active' : '' }}">
                                <i class="ri-shield-user-line menu-icon"></i>
                                Manage Role
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('master.units.index') }}" class="menu-link {{ request()->routeIs('master.units.*') ? 'active' : '' }}">
                                <i class="ri-building-2-line menu-icon"></i>
                                Manajemen Unit
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <button class="menu-toggle" id="menuToggle">
                    <i class="ri-menu-line"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="ri-logout-box-r-line"></i>
                        Logout
                    </button>
                </form>
            </div>

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle mobile menu
            document.getElementById('menuToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
            });

            // Get active menu from localStorage or URL
            const currentPath = window.location.pathname;
            const savedMenuState = JSON.parse(localStorage.getItem('menuState') || '{}');
            
            // Function to open parent menus
            function openParentMenus(element) {
                const parentSubmenu = element.closest('.submenu');
                if (parentSubmenu) {
                    parentSubmenu.classList.add('show');
                    const parentMenuLink = parentSubmenu.previousElementSibling;
                    if (parentMenuLink && parentMenuLink.classList.contains('has-submenu')) {
                        parentMenuLink.classList.add('active');
                        openParentMenus(parentMenuLink);
                    }
                }
            }

            // Set initial active state
            document.querySelectorAll('.menu-link, .submenu-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && currentPath === href) {
                    link.classList.add('active');
                    openParentMenus(link);
                }
            });

            function toggleSubmenu(event, submenuId) {
                event.preventDefault();
                const submenu = document.getElementById(submenuId);
                const menuLink = event.currentTarget;
                
                // Toggle active class on menu link
                menuLink.classList.toggle('active');
                
                // Toggle submenu visibility
                if (submenu.classList.contains('show')) {
                    submenu.classList.remove('show');
                    // Save state
                    savedMenuState[submenuId] = false;
                } else {
                    // If it's a nested submenu, don't close other submenus
                    if (!submenu.classList.contains('nested')) {
                        // Close all other submenus at the same level
                        const allSubmenus = document.querySelectorAll('.submenu:not(.nested)');
                        allSubmenus.forEach(menu => {
                            if (menu.id !== submenuId) {
                                menu.classList.remove('show');
                                const otherMenuLinks = menu.previousElementSibling;
                                if (otherMenuLinks) {
                                    otherMenuLinks.classList.remove('active');
                                }
                                savedMenuState[menu.id] = false;
                            }
                        });
                    }
                    submenu.classList.add('show');
                    // Save state
                    savedMenuState[submenuId] = true;
                }

                // Save menu state to localStorage
                localStorage.setItem('menuState', JSON.stringify(savedMenuState));
            }

            // Restore saved menu state
            Object.entries(savedMenuState).forEach(([submenuId, isOpen]) => {
                const submenu = document.getElementById(submenuId);
                const menuLink = submenu?.previousElementSibling;
                if (submenu && isOpen) {
                    submenu.classList.add('show');
                    if (menuLink) {
                        menuLink.classList.add('active');
                    }
                }
            });

            // Only close submenus when clicking outside AND not clicking any menu items
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.menu-link') && 
                    !event.target.closest('.submenu') && 
                    !event.target.closest('.menu-item')) {
                    const allSubmenus = document.querySelectorAll('.submenu');
                    const allMenuLinks = document.querySelectorAll('.menu-link.has-submenu');
                    
                    allSubmenus.forEach(submenu => submenu.classList.remove('show'));
                    allMenuLinks.forEach(link => link.classList.remove('active'));
                    
                    // Clear saved state
                    localStorage.removeItem('menuState');
                }
            });

            // Make toggleSubmenu available globally
            window.toggleSubmenu = toggleSubmenu;
        });
    </script>
    @stack('scripts')
</body>
</html> 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RS Sehat Sejahtera</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #16a34a;
            --primary-dark: #15803d;
            --secondary-color: #e2e8f0;
            --text-color: #1b1b18;
            --sidebar-width: 250px;
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
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--secondary-color);
            margin-bottom: 1.5rem;
        }

        .hospital-logo {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 0.75rem;
        }

        .hospital-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .menu-list {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 0.5rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: var(--text-color);
            border-radius: 6px;
            transition: all 0.2s;
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
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .welcome-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .logout-btn { 
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: var(--primary-dark);
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
    </style>
</head>
<body>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="hospital-logo">
                    <i class="ri-heart-pulse-fill"></i>
                </div>
                <div class="hospital-name">RS Sehat Sejahtera</div>
            </div>
            
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="/dashboard" class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="ri-dashboard-line menu-icon"></i>
                        Dashboard
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link {{ request()->is('pasien*') ? 'active' : '' }}">
                        <i class="ri-user-heart-line menu-icon"></i>
                        Pasien
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link {{ request()->is('dokter*') ? 'active' : '' }}">
                        <i class="ri-nurse-line menu-icon"></i>
                        Dokter
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link {{ request()->is('jadwal*') ? 'active' : '' }}">
                        <i class="ri-calendar-check-line menu-icon"></i>
                        Jadwal
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link {{ request()->is('farmasi*') ? 'active' : '' }}">
                        <i class="ri-medicine-bottle-line menu-icon"></i>
                        Farmasi
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link {{ request()->is('pengaturan*') ? 'active' : '' }}">
                        <i class="ri-settings-4-line menu-icon"></i>
                        Pengaturan
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <button class="menu-toggle" id="menuToggle">
                    <i class="ri-menu-line"></i>
                </button>
                <h1 class="welcome-text">@yield('page-title', 'Dashboard')</h1>
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
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @yield('scripts')
</body>
</html> 
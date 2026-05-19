<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Brunett')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Design System CSS -->
    <link rel="stylesheet" href="{{ asset('css/design_system.css') }}">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js (Lightweight Reactivity) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <div class="layout-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-icon"></div>
                Brunett
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="layout-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                    <a href="{{ route('pos.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="shopping-cart"></i> POS / Ventas
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="package"></i> Inventario
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('inventory.kardex') ? 'active' : '' }}" style="margin-left: 1.5rem; font-size: 0.9rem;">
                    <a href="{{ route('inventory.kardex') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="list" style="width: 16px;"></i> Kardex (Movimientos)
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('inventory.transfers') ? 'active' : '' }}" style="margin-left: 1.5rem; font-size: 0.9rem;">
                    <a href="{{ route('inventory.transfers') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="arrow-left-right" style="width: 16px;"></i> Transferencias
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}" style="margin-left: 1.5rem; font-size: 0.9rem;">
                    <a href="{{ route('categories.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="layers" style="width: 16px;"></i> Categorías
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('brands.*') ? 'active' : '' }}" style="margin-left: 1.5rem; font-size: 0.9rem;">
                    <a href="{{ route('brands.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="tag" style="width: 16px;"></i> Marcas
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="users"></i> Clientes
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="truck"></i> Proveedores
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                    <a href="{{ route('purchases.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="shopping-cart"></i> Compras / Ingresos
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('boxes.*') ? 'active' : '' }}">
                    <a href="{{ route('boxes.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="wallet"></i> Caja y Bancos
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <a href="{{ route('reports.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="pie-chart"></i> Reportes
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('sync.*') ? 'active' : '' }}">
                    <a href="{{ route('sync.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="globe"></i> Tienda Online
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <a href="{{ route('orders.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="message-circle"></i> Pedidos WhatsApp
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    <a href="{{ route('expenses.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="minus-circle"></i> Gastos
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('audit.*') ? 'active' : '' }}">
                    <a href="{{ route('audit.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="shield-check"></i> Seguridad y Auditoría
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}" style="margin-left: 1.5rem; font-size: 0.9rem;">
                    <a href="{{ route('users.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="user-cog" style="width: 16px;"></i> Usuarios
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}" style="margin-left: 1.5rem; font-size: 0.9rem;">
                    <a href="{{ route('roles.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="shield" style="width: 16px;"></i> Roles y Permisos
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('cities.*') ? 'active' : '' }}">
                    <a href="{{ route('cities.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="map-pin"></i> Ciudades
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('warehouses.*') ? 'active' : '' }}">
                    <a href="{{ route('warehouses.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="home"></i> Bodegas
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('authorizations.*') ? 'active' : '' }}">
                    <a href="{{ route('authorizations.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="key"></i> Autorizaciones
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <a href="{{ route('settings.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="settings"></i> Configuración
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--brand-danger); text-decoration: none; display: flex; align-items: center; gap: 0.8rem; width: 100%;">
                        <i data-lucide="log-out"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <div>
                    <h1 class="page-title">@yield('page_title')</h1>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">@yield('page_subtitle', date('d de M Y'))</p>
                </div>
                
                <div class="topbar-actions">
                    <button class="btn-icon"><i data-lucide="bell"></i></button>
                    <div class="user-profile">
                        <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <div>
                            <p style="font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                            <p style="font-size: 0.8rem; color: var(--text-secondary);">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
            
        </main>
    </div>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
    
    @stack('scripts')
</body>
</html>

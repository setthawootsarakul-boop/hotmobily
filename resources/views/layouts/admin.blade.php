<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotmobily Admin | Control Center</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* ปรับแต่งเพิ่มเติมเล็กน้อยเพื่อให้ดูทันสมัยขึ้น */
        .nav-link.active {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .brand-text {
            letter-spacing: 1px;
        }
        .app-main {
            background-color: #f4f6f9;
            min-height: calc(100vh - 60px);
        }
    </style>
    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        
        <nav class="app-header navbar navbar-expand bg-body shadow-sm">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ route('home') }}" class="nav-link" target="_blank">
                            <i class="bi bi-globe me-1"></i> ดูหน้าเว็บไซต์จริง
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    {{-- 🔴 ปุ่ม Logout เพิ่มตรงนี้ --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 me-2 text-primary"></i>
                            <span class="fw-bold small d-none d-sm-inline">{{ Auth::guard('admin')->user()->username ?? 'Administrator' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 mt-2">
                            <li>
                                <div class="dropdown-header small text-uppercase fw-bold opacity-50">Manage Account</div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center py-2" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?')">
                                        <i class="bi bi-box-arrow-right me-2"></i> ออกจากระบบ
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}" class="brand-link">
                    <span class="brand-text fw-bold text-uppercase">Hotmobily Admin</span>
                </a>
            </div>
            
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'dashboard']) }}" 
                               class="nav-link {{ request('view', 'dashboard') == 'dashboard' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase small opacity-50">Product Control</li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'products']) }}" 
                               class="nav-link {{ request('view') == 'products' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>สินค้า & ราคา </p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'gallery']) }}" 
                               class="nav-link {{ request('view') == 'gallery' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-images"></i>
                                <p>คลังภาพผลงาน</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'addons']) }}" 
                               class="nav-link {{ request('view') == 'addons' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>อุปกรณ์เสริม</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase small opacity-50">Customer & Sales</li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'quotations']) }}" 
                               class="nav-link {{ request('view') == 'quotations' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-pdf-fill"></i>
                                <p>รายการใบเสนอราคา</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'contacts']) }}" 
                               class="nav-link {{ request('view') == 'contacts' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-chat-dots-fill"></i>
                                <p>ข้อความติดต่อใหม่</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'payments']) }}" 
                               class="nav-link {{ request('view') == 'payments' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-check-circle-fill"></i>
                                <p>ตรวจสอบยอดโอน</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase small opacity-50">System Content</li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard', ['view' => 'faq']) }}" 
                               class="nav-link {{ request('view') == 'faq' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-patch-question-fill"></i>
                                <p>จัดการ FAQ</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main p-3 p-md-4">
            @yield('content')
        </main>

        <footer class="app-footer text-end p-3 small text-muted border-top bg-white">
            <strong>Hotmobily Admin Control</strong> &copy; {{ date('Y') }} - All Rights Reserved.
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
    
    {{-- เช็คสถานะการทำงานของเมนู Sidebar --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ป้องกันการโหลดซ้ำของ Sidebar สั่งให้เปิดค้างไว้ตามสถานะจอ
            if (window.innerWidth < 992) {
                document.body.classList.remove('sidebar-open');
                document.body.classList.add('sidebar-collapse');
            }
        });
    </script>
    @stack('scripts')
    <style>
    .pagination .page-link {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
        transition: all 0.2s;
    }
    .pagination .page-item.active .page-link {
        background-color: #000 !important; /* สีดำตามธีมที่คุณชอบ */
        color: #fff !important;
    }
    .pagination .page-link:hover:not(.active) {
        background-color: #e9ecef !important;
        transform: translateY(-2px);
    }
    </style>
</body>
</html>
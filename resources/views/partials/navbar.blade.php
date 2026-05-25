{{-- MOBILE TOP BAR (Only visible on small screens) --}}
<div class="d-lg-none bg-dark text-white p-3 d-flex justify-content-between align-items-center shadow-sm">
    <a class="text-white text-decoration-none fw-bold fs-5" href="{{ route('dashboard') }}">
        <i class="bi bi-cash-stack text-primary me-2"></i>Payroll System
    </a>
    <button class="btn btn-outline-light border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
        <i class="bi bi-list fs-2"></i>
    </button>
</div>

{{-- SIDEBAR / OFFCANVAS --}}
<div class="offcanvas-lg offcanvas-start bg-dark text-white shadow-lg" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="width: 280px; position: fixed; top: 0; bottom: 0; left: 0; z-index: 1045;">
    
    {{-- Mobile Sidebar Header --}}
    <div class="offcanvas-header border-bottom border-secondary d-lg-none">
        <h5 class="offcanvas-title fw-bold" id="sidebarMenuLabel">
            <i class="bi bi-cash-stack text-primary me-2"></i>Menu
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>

    {{-- Sidebar Content --}}
    <div class="offcanvas-body d-flex flex-column p-3 h-100 overflow-y-auto">
        
        {{-- Desktop Branding --}}
        <a href="{{ route('dashboard') }}" class="d-none d-lg-flex align-items-center mb-4 text-white text-decoration-none fw-bold fs-4 px-2 mt-2">
            <i class="bi bi-cash-stack text-primary me-2"></i>
            <span class="fs-5">Payroll System</span>
        </a>

        {{-- Nav Links --}}
        <ul class="nav nav-pills flex-column mb-auto gap-1">
            
            {{-- DASHBOARD --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            {{-- ================= ADMIN ================= --}}
            @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item mt-3 mb-1 px-2 text-uppercase text-secondary small fw-bold">Admin Controls</li>
                
                <li class="nav-item">
                    <a href="{{ route('employees.index') }}" class="nav-link text-white {{ request()->routeIs('employees.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-people me-2"></i> Employees
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('departments.index') }}" class="nav-link text-white {{ request()->routeIs('departments.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-building me-2"></i> Departments
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('payrolls.index') }}" class="nav-link text-white {{ request()->routeIs('payrolls.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-wallet2 me-2"></i> Payroll
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('deductions.index') }}" class="nav-link text-white {{ request()->routeIs('deductions.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-graph-down-arrow me-2"></i> Deductions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('attendances.index') }}" class="nav-link text-white {{ request()->routeIs('attendances.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-calendar-check me-2"></i> Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('leaves.index') }}" class="nav-link text-white {{ request()->routeIs('leaves.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-calendar2-x me-2"></i> Leaves
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link text-white {{ request()->routeIs('users.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-person-badge me-2"></i> Users
                    </a>
                </li>
            @endif

            {{-- ========== PAYROLL OFFICER ========== --}}
            @if(Auth::check() && Auth::user()->role === 'payroll_officer')
                <li class="nav-item mt-3 mb-1 px-2 text-uppercase text-secondary small fw-bold">Officer Controls</li>

                <li class="nav-item">
                    <a href="{{ route('employees.view') }}" class="nav-link text-white {{ request()->routeIs('employees.view') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-people me-2"></i> Employees View
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('payrolls.index') }}" class="nav-link text-white {{ request()->routeIs('payrolls.*') || request()->routeIs('payroll.*') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-wallet2 me-2"></i> Payrolls
                    </a>
                </li>
            @endif

            {{-- ================= EMPLOYEE ================= --}}
            @if(Auth::check() && Auth::user()->role === 'employee')
                <li class="nav-item mt-3 mb-1 px-2 text-uppercase text-secondary small fw-bold">My Portal</li>

                <li class="nav-item">
                    <a href="{{ route('employees.my') }}" class="nav-link text-white {{ request()->routeIs('employees.my') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-person-vcard me-2"></i> My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('payrolls.my') }}" class="nav-link text-white {{ request()->routeIs('payrolls.my') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-receipt me-2"></i> My Payslips
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('attendances.my') }}" class="nav-link text-white {{ request()->routeIs('attendances.my') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-clock-history me-2"></i> My Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('leaves.my') }}" class="nav-link text-white {{ request()->routeIs('leaves.my') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-calendar2-minus me-2"></i> My Leaves
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('leaves.create') }}" class="nav-link text-white {{ request()->routeIs('leaves.create') ? 'active bg-primary' : '' }}">
                        <i class="bi bi-pencil-square me-2"></i> Apply Leave
                    </a>
                </li>
            @endif
        </ul>

        {{-- USER PROFILE / LOGOUT (Anchored at the bottom) --}}
        @if(Auth::check())
            <hr class="border-secondary mt-4">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-2 rounded hover-bg-dark" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2 shadow-sm" style="width: 32px; height: 32px;">
                        <span class="fw-bold small">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <strong>{{ Auth::user()->name }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2 text-muted"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger fw-semibold" type="submit">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif

    </div>
</div>
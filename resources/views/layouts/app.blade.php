{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta cha$et="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Materials Management')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f4f7fb;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.85);
            border-radius: 8px;
            margin-bottom: 4px;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.12);
        }

        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,.2);
        }

        .main-content {
            padding: 20px;
        }

        .stats-card {
            border-radius: 12px;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .stats-card.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stats-card.success { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }
        .stats-card.info { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }
        .stats-card.warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                min-height: auto;
            }

            .main-content {
                padding: 14px;
            }

            .sidebar .nav-link {
                padding: 0.7rem 0.8rem;
            }

            .card, .table-container {
                overflow-x: auto;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 p-0 sidebar">
                <div class="p-3">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-boxes me-2"></i>Materials
                    </h4>
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-pie me-2"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('factory.incoming.*') ? 'active' : '' }}"
                           href="{{ route('factory.incoming.index') }}">
                            <i class="fas fa-truck-loading me-2"></i> Incoming
                        </a>
                        <a class="nav-link {{ request()->routeIs('factory.outgoing.*') ? 'active' : '' }}"
                           href="{{ route('factory.outgoing.index') }}">
                            <i class="fas fa-truck me-2"></i> Outgoing
                        </a>
                        <a class="nav-link {{ request()->routeIs('factory.expenses.*') ? 'active' : '' }}"
                           href="{{ route('factory.expenses.index') }}">
                            <i class="fas fa-wallet me-2"></i> Expenses
                        </a>
                        <a class="nav-link {{ request()->routeIs('materials.*') ? 'active' : '' }}"
                           href="{{ route('materials.index') }}">
                            <i class="fas fa-box me-2"></i> Materials
                        </a>
                        <hr class="bg-light">
                        <small class="text-muted px-3">Sales</small>
                        <a class="nav-link {{ request('category') == 'gress' ? 'active' : '' }}"
                           href="{{ route('sales.index', ['category' => 'gress']) }}">
                            <i class="fas fa-tractor me-2"></i> Gress
                        </a>
                        <a class="nav-link {{ request('category') == 'jalee' ? 'active' : '' }}"
                           href="{{ route('sales.index', ['category' => 'jalee']) }}">
                            <i class="fas fa-grid me-2"></i> Jalee
                        </a>
                        <a class="nav-link {{ request('category') == 'bailt' ? 'active' : '' }}"
                           href="{{ route('sales.index', ['category' => 'bailt']) }}">
                            <i class="fas fa-brick me-2"></i> Bailt
                        </a>
                        <a class="nav-link {{ request('category') == 'gonde' ? 'active' : '' }}"
                           href="{{ route('sales.index', ['category' => 'gonde']) }}">
                            <i class="fas fa-cube me-2"></i> Gonde
                        </a>
                        <a class="nav-link {{ request('category') == 'panjaee' ? 'active' : '' }}"
                           href="{{ route('sales.index', ['category' => 'panjaee']) }}">
                            <i class="fas fa-hand-paper me-2"></i> Panjaee
                        </a>
                        <a class="nav-link {{ request('category') == 'tagharee' ? 'active' : '' }}"
                           href="{{ route('sales.index', ['category' => 'tagharee']) }}">
                            <i class="fas fa-tag me-2"></i> Tagharee
                        </a>
                        <a class="nav-link {{ request('category') == 'max_katha' ? 'active' : '' }}"
                           href="{{ route('sales.index', ['category' => 'max_katha']) }}">
                            <i class="fas fa-medal me-2"></i> Max Katha
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    @yield('scripts')
</body>
</html>

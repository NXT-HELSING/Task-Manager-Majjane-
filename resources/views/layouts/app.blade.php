<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Task Manager Majjane Test') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            --danger-gradient: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            --warning-gradient: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            --light-bg: #f7fafc;
            --card-bg: #ffffff;
            --sidebar-bg: #ffffff;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light-bg);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* Modern Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(118, 75, 162, 0.05) 0%, transparent 50%);
            z-index: -1;
            animation: bgFloat 20s ease-in-out infinite;
        }

        @keyframes bgFloat {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -30px); }
        }

        /* Modern Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
        }

        .nav-link:hover {
            color: var(--text-primary) !important;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        /* Mobile Navbar Adjustments */
        @media (max-width: 991.98px) {
            .navbar-custom {
                padding: 0.75rem 0;
            }
            
            .navbar-brand {
                font-size: 1.25rem;
            }
            
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                border-radius: 12px;
                margin-top: 1rem;
                padding: 1rem;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            }
            
            .nav-link {
                padding: 0.75rem 1rem !important;
                margin: 0.25rem 0;
                border-radius: 8px;
            }
            
            .nav-link:hover {
                background: rgba(102, 126, 234, 0.1);
                transform: none;
            }
            
            .nav-link::after {
                display: none;
            }
        }

        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Mobile Button Adjustments */
        @media (max-width: 768px) {
            .btn-gradient {
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .btn-gradient:hover {
                transform: none;
            }
        }

        .dropdown-menu {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            margin-top: 0.5rem;
        }

        .dropdown-item {
            color: var(--text-secondary);
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: var(--text-primary);
            padding-left: 1.5rem;
        }

        /* Modern Alert Styles */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            animation: slideInDown 0.5s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%);
            color: #38a169;
            border-left: 4px solid #38a169;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(229, 62, 62, 0.1) 0%, rgba(197, 48, 48, 0.1) 100%);
            color: #e53e3e;
            border-left: 4px solid #e53e3e;
        }

        /* Container */
        .main-container {
            min-height: calc(100vh - 76px);
            padding: 2rem 0;
        }

        /* Mobile Container Adjustments */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem 0;
            }
            
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Modern Footer */
        .footer-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--border-color);
            padding: 2rem 0;
            margin-top: 4rem;
        }

        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
        }
    </style>

    @livewireStyles
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('projects.index') }}">
                <i class="bi bi-kanban"></i> Task Manager Majjane Test
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projects.index') }}">
                                <i class="bi bi-grid-3x3-gap"></i> Projets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projects.create') }}">
                                <i class="bi bi-plus-circle"></i> Nouveau Projet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('assigned-tasks') }}">
                                <i class="bi bi-person-check"></i> Mes Tâches
                            </a>
                        </li>
                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="avatar-circle me-2">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle"></i> Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="border-color: var(--border-color);"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('register') }}" class="btn btn-gradient">
                                Commencer
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-container">
        <div class="container-fluid px-4">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-custom text-center">
        <div class="container">
            <p class="mb-0" style="color: var(--text-secondary);">
                &copy; {{ date('Y') }} Task Manager Majjane Test. Crafted with <i class="bi bi-heart-fill text-danger"></i>
            </p>
        </div>
    </footer>

    <!-- Avatar Circle Style -->
    <style>
        .avatar-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Mobile Avatar Adjustments */
        @media (max-width: 768px) {
            .avatar-circle {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }

        /* Touch-friendly improvements */
        @media (max-width: 768px) {
            .btn-gradient:hover,
            .btn-secondary-custom:hover,
            .nav-link:hover {
                transform: none;
            }
            
            .form-control-modern:focus {
                transform: none;
            }
            
            .dropdown-item:hover {
                padding-left: 1.25rem;
            }
            
            /* Ensure buttons are touch-friendly */
            .btn-gradient,
            .btn-secondary-custom,
            .nav-link {
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Improve dropdown touch targets */
            .dropdown-toggle {
                min-width: 44px;
                min-height: 44px;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @livewireScripts
    
    <!-- Custom JS for notifications -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (event) => {
                const message = event.message || event[0]?.message || 'Success!';
                showNotification(message);
            });
        });

        function showNotification(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-custom alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                <i class="bi bi-check-circle-fill me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    </script>
</body>
</html>
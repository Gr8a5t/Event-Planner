<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EventFlow - Manage Your Events Seamlessly')</title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    
    @yield('styles')
</head>
<body>
    <nav class="navbar {{ request()->is('/') ? '' : 'navbar-inner' }}" style="{{ request()->routeIs('events.show') ? 'background: transparent; border: none; position: absolute; top: 0; left: 0; right: 0; padding: 2rem 0;' : '' }}">
        <div class="container navbar-content" style="{{ request()->routeIs('events.show') ? 'display: block;' : '' }}">
            <div class="nav-left">
                <a href="/" class="logo" style="{{ request()->routeIs('events.show') ? 'color: #fff;' : '' }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="{{ request()->routeIs('events.show') ? '#fff' : 'black' }}"/>
                        <path d="M2 17L12 22L22 17" stroke="{{ request()->routeIs('events.show') ? '#fff' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="{{ request()->routeIs('events.show') ? '#fff' : 'black' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    EventFlow
                </a>
            </div>
            
            @if(!request()->routeIs('events.show'))
                <ul class="nav-links-center">
                    <li><a href="/">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="{{ route('events.index') }}">Explore</a></li>
                </ul>

                <div class="nav-right">
                    <ul class="nav-links">
                        @auth
                            <li><a href="{{ route('dashboard') }}" style="margin-right: 1.5rem;">Dashboard</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1.25rem;">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" style="margin-right: 1.5rem;">Sign In</a></li>
                            <li><a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a></li>
                        @endauth
                    </ul>
                </div>
            @endif
        </div>
    </nav>

    <div class="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999; width: 100%; max-width: 400px; pointer-events: none;">
        @if(session('success'))
            <div style="background: #ecfdf5; color: #065f46; padding: 1rem 1.25rem; border-radius: 12px; border: 1px solid #10b981; font-weight: 600; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1); margin-bottom: 1rem; pointer-events: auto; display: flex; align-items: flex-start; gap: 0.75rem;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fef2f2; color: #991b1b; padding: 1rem 1.25rem; border-radius: 12px; border: 1px solid #ef4444; font-weight: 600; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.1); margin-bottom: 1rem; pointer-events: auto; display: flex; align-items: flex-start; gap: 0.75rem;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    @if(!request()->routeIs('events.show'))
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="/" class="logo" style="margin-bottom: 1.5rem; display: block;">EventFlow</a>
                    <p style="color: #6b7280; line-height: 1.6;">Simplifying the way the world gathers. From small meetups to global summits.</p>
                </div>
                <div class="footer-col">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="{{ route('events.index') }}">Explore Events</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Connect</h4>
                    <ul>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">LinkedIn</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} EventFlow. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @endif

    @yield('scripts')
    <script>
        // Auto-dismiss toasts
        document.querySelectorAll('.toast-container > div').forEach(toast => {
            setTimeout(() => {
                toast.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 500);
            }, 5000);
        });
    </script>
</body>
</html>

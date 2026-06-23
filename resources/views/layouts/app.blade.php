<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TOEFLin - Aplikasi Simulasi Computer-Based Test (CBT) TOEFL Terintegrasi dengan fitur Auto-Scoring dan Sertifikat PDF.">
    <meta name="keywords" content="TOEFL, CBT, Simulasi TOEFL, Belajar TOEFL, Ujian Bahasa Inggris">
    <meta name="author" content="Celcious Cyber">
    <meta name="theme-color" content="#4f46e5">
    <meta property="og:title" content="TOEFLin - CBT Simulation">
    <meta property="og:description" content="Persiapkan diri Anda untuk menghadapi ujian TOEFL ITP yang sebenarnya dengan TOEFLin.">
    <meta property="og:type" content="website">
    
    <title>@yield('title', 'TOEFLin - CBT Simulation')</title>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/favicon.svg?v={{ time() }}">
    <link rel="icon" href="/favicon.svg?v={{ time() }}" type="image/svg+xml">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
    
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
</head>
<body class="text-slate-800 antialiased flex flex-col min-h-screen">
    <nav class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo (Left) -->
                <div class="flex items-center w-1/4 md:w-1/3">
                    <a href="/" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                        <img src="/toeflin.svg?v={{ time() }}" alt="TOEFLin Logo" class="h-8">
                    </a>
                </div>

                <!-- Center Navigation -->
                @auth
                    @if(auth()->user()->role === 'student')
                        <div class="hidden md:flex flex-1 justify-center items-center gap-8">
                            <a href="{{ route('student.dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Dashboard</a>
                            <a href="{{ route('student.packages') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Paket Tes</a>
                            <a href="{{ route('student.history') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Riwayat</a>
                        </div>
                    @endif
                @endauth

                <!-- Right Menu (Avatar/Login) -->
                <div class="flex items-center justify-end w-1/4 md:w-1/3 gap-4">
                    @auth

                        <!-- Avatar Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="flex text-sm bg-slate-100 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 border border-slate-200 transition-colors hover:border-blue-300" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Buka menu pengguna</span>
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center font-bold shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 overflow-hidden" 
                                 role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                                
                                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors" role="menuitem" tabindex="-1">
                                            <svg class="mr-3 h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('admin.login') }}" class="text-sm text-slate-500 hover:text-slate-700 font-medium transition-colors">Admin</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8 min-h-[calc(100vh-140px)]">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} TOEFLin - Universitas Cordova Indonesia. All rights reserved.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

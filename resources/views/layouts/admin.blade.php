<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Portal - TOEFLin')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="text-slate-800 antialiased bg-slate-50 overflow-hidden h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-100 flex flex-col shrink-0 h-full">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 shrink-0">
                <img src="{{ asset('favicon.svg') }}" alt="TOEFLin" class="w-full h-full object-cover rounded-xl shadow-sm border border-slate-200">
            </div>
            <div>
                <p class="text-sm font-black text-slate-800 leading-none">Admin Portal</p>
                <p class="text-[10px] font-bold text-slate-400 mt-0.5 uppercase tracking-wider">TOEFLin Cordova</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 flex flex-col gap-1.5 overflow-y-auto">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-2 mb-3">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center justify-between px-3 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Overview
                </span>
            </a>

            <a href="{{ route('admin.bank-soal') }}" class="group flex items-center justify-between px-3 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.bank-soal') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.bank-soal') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21-3.582 4-8 4s-8-1.79-8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    Bank Soal
                </span>
            </a>

            <a href="{{ route('admin.paket-tes') }}" class="group flex items-center justify-between px-3 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.paket-tes') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.paket-tes') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Paket Tes
                </span>
            </a>

            <a href="{{ route('admin.requests') }}" class="group flex items-center justify-between px-3 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.requests') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.requests') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Permohonan Ujian
                </span>
            </a>

            <a href="{{ route('admin.mahasiswa') }}" class="group flex items-center justify-between px-3 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.mahasiswa') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.mahasiswa') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Mahasiswa
                </span>
            </a>

            @if(Auth::user()->role === 'superadmin')
            <div class="pt-4 mt-2 border-t border-slate-100">
                <a href="{{ route('admin.pengaturan') }}" class="group flex items-center justify-between px-3 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.pengaturan') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.pengaturan') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </span>
                </a>
            </div>
            @endif
        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Topbar -->
        <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800 font-[Outfit]">@yield('header', 'Dashboard Admin')</h2>
                <p class="text-xs font-semibold text-slate-400 mt-0.5">Panel Administrasi TOEFLin</p>
            </div>
            <div class="flex items-center gap-3 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-black shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Administrator</p>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-8 relative">
            @yield('content')
        </main>
    </div>

</body>
</html>

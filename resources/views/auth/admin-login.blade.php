<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TOEFLin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .bg-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #334155 80%, #475569 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.5);
        }
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.625rem;
            font-size: 0.9375rem;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }
        .btn-primary {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #4338ca, #6366f1);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 0.625rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(99,102,241,0.4);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.5);
        }
        .btn-primary:active { transform: translateY(0); }
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .show-pass-btn {
            position: absolute;
            inset-y: 0;
            right: 0;
            padding: 0 0.875rem;
            display: flex;
            align-items: center;
            color: #94a3b8;
            cursor: pointer;
            background: none;
            border: none;
        }
        .show-pass-btn:hover { color: #64748b; }
    </style>
</head>
<body class="min-h-screen bg-hero grid-pattern flex items-center justify-center p-4 relative">

    <!-- Decorative Corner -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600 opacity-5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-600 opacity-5 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-sm relative z-10">

        <!-- Badge Admin -->
        <div class="flex justify-center mb-6">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5">
                <div class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse"></div>
                <span class="text-white/80 text-xs font-medium tracking-widest uppercase">Portal Admin</span>
            </div>
        </div>

        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block mb-4">
                <img src="/toeflin.svg" alt="TOEFLin" class="h-10 mx-auto brightness-0 invert opacity-90">
            </a>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Masuk sebagai Admin</h1>
            <p class="text-slate-400 mt-1.5 text-sm">Akses panel manajemen TOEFLin</p>
        </div>

        <!-- Card -->
        <div class="glass-card rounded-2xl shadow-2xl p-7">

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex gap-2 items-start">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <ul class="list-none space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            class="input-field" placeholder="admin@toeflin.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                            class="input-field" placeholder="••••••••">
                        <button type="button" class="show-pass-btn" onclick="togglePassword()" tabindex="-1">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-slate-600">Ingat saya</label>
                </div>

                <button type="submit" id="btn-admin-login" class="btn-primary">
                    Masuk ke Panel Admin
                </button>
            </form>
        </div>

        <p class="text-center text-slate-500 text-xs mt-6">
            Bukan admin? <a href="{{ route('student.login') }}" class="text-slate-400 underline hover:text-white transition-colors">Portal Siswa</a>
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>

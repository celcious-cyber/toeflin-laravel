<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Siswa - TOEFLin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .bg-hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 40%, #3b82f6 70%, #0ea5e9 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.6);
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
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }
        .btn-primary {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 0.625rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(59,130,246,0.4);
            letter-spacing: 0.01em;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59,130,246,0.5);
        }
        .btn-primary:active { transform: translateY(0); }
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="min-h-screen bg-hero flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Floating Decorations -->
    <div class="floating-shape w-72 h-72 -top-20 -left-20" style="animation-delay: 0s;"></div>
    <div class="floating-shape w-48 h-48 top-1/3 -right-12" style="animation-delay: 2s;"></div>
    <div class="floating-shape w-32 h-32 bottom-20 left-1/4" style="animation-delay: 4s;"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Logo & Heading -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block mb-4">
                <img src="/toeflin.svg" alt="TOEFLin" class="h-12 mx-auto drop-shadow-lg brightness-0 invert">
            </a>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Masuk ke TOEFLin</h1>
            <p class="text-blue-200 mt-2 text-sm">Masukkan nama & NIM untuk melanjutkan ujian</p>
        </div>

        <!-- Card -->
        <div class="glass-card rounded-2xl shadow-2xl p-8">

            <!-- Error -->
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

            @if (session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('student.login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="input-field" placeholder="Contoh: Budi Santoso">
                    </div>
                </div>

                <!-- NIM -->
                <div>
                    <label for="nim" class="block text-sm font-semibold text-slate-700 mb-1.5">NIM / ID Pendaftaran</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                            </svg>
                        </div>
                        <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required
                            class="input-field" placeholder="Contoh: 12345678">
                    </div>
                </div>

                <button type="submit" id="btn-login" class="btn-primary">
                    Masuk Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center gap-3">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-xs text-slate-400 font-medium">Belum punya akun?</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <a href="{{ route('student.register') }}"
               class="block w-full text-center py-3 px-4 border-2 border-blue-600 text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors text-sm">
                Daftar Akun Baru
            </a>
        </div>

        <!-- Footer note -->
        <p class="text-center text-blue-200 text-xs mt-6">
            Admin? <a href="{{ route('admin.login') }}" class="underline hover:text-white transition-colors">Masuk di sini</a>
        </p>
    </div>

    @stack('scripts')
</body>
</html>

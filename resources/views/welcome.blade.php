@extends('layouts.app')

@section('title', 'Welcome - TOEFLin CBT Simulation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
    <h1 class="text-5xl font-extrabold text-slate-900 tracking-tight mb-6">
        Simulasi <span class="text-blue-600">TOEFL ITP</span> Resmi
    </h1>
    <p class="mt-4 text-xl text-slate-500 max-w-3xl mx-auto mb-10">
        Persiapkan diri Anda untuk menghadapi ujian TOEFL ITP yang sebenarnya. Dapatkan pengalaman ujian yang realistis lengkap dengan sistem penilaian otomatis dan sertifikat PDF!
    </p>
    
    <div class="flex justify-center mt-10">
        @auth
            <a href="{{ route(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin' ? 'admin.dashboard' : 'student.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition-colors text-lg w-full max-w-sm">
                Masuk ke Dashboard
            </a>
        @else
            <form action="{{ route('quick.join') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 max-w-md w-full space-y-6">
                @csrf
                <div class="text-left mb-2">
                    <h2 class="text-2xl font-bold text-slate-800">Mulai Ujian</h2>
                    <p class="text-sm text-slate-500 mt-1">Masukkan data diri Anda untuk memulai</p>
                </div>
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm border border-red-100 text-left">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="text-left">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: Budi Santoso">
                </div>
                
                <div class="text-left">
                    <label for="nim" class="block text-sm font-semibold text-slate-700 mb-2">NIM / ID Pendaftaran</label>
                    <input type="text" id="nim" name="nim" required class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: 12345678">
                </div>
                
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition-all transform hover:-translate-y-0.5">
                    Mulai Ujian Sekarang
                </button>
            </form>
        @endauth
    </div>

    <!-- Features -->
    <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Simulasi Realistis</h3>
            <p class="text-slate-600">Durasi dan format ujian (Listening, Structure, Reading) disesuaikan persis dengan standar resmi TOEFL ITP.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Auto-Scoring</h3>
            <p class="text-slate-600">Ketahui nilai Anda segera setelah selesai! Skor Anda dikonversi langsung menggunakan skala resmi (310-677).</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Sertifikat PDF</h3>
            <p class="text-slate-600">Unduh sertifikat bukti kelulusan simulasi Anda dengan desain premium dalam format PDF seketika.</p>
        </div>
    </div>
</div>
@endsection

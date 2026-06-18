@extends('layouts.admin')

@section('title', 'Overview - Admin Portal')
@section('header', 'Overview')

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-8" x-data="{ time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }), 1000)">

    <!-- Welcome banner -->
    <div class="rounded-3xl p-8 flex items-center justify-between shadow-xl relative overflow-hidden" style="background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%)">
        <div class="absolute top-[-50%] right-[-10%] w-[60%] h-[200%] bg-white/5 rotate-12 blur-3xl rounded-full pointer-events-none"></div>
        <div class="relative z-10">
            <p class="text-indigo-200 text-sm font-bold mb-2 uppercase tracking-widest">Selamat datang kembali 👋</p>
            <h1 class="text-white text-3xl font-black font-[Outfit] mb-1">Panel Admin TOEFLin</h1>
            <p class="text-indigo-200 text-sm font-medium">Universitas Cordova · {{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="text-right hidden md:block relative z-10">
            <p class="text-5xl font-black text-white font-[Outfit] tracking-tight drop-shadow-md" x-text="time"></p>
            <p class="text-indigo-300 text-xs font-bold uppercase tracking-widest mt-2">Waktu Sekarang</p>
        </div>
    </div>

    <!-- Stats -->
    <div>
        <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg> Ringkasan Data
        </h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="bg-white border border-blue-100 rounded-2xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <p class="text-4xl font-black text-slate-800 font-[Outfit]">{{ number_format($totalStudents) }}</p>
                <p class="text-sm font-bold text-slate-600 mt-1">Total Mahasiswa</p>
                <p class="text-xs font-medium text-slate-400 mt-1">Terdaftar di sistem</p>
            </div>

            <div class="bg-white border border-violet-100 rounded-2xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 rounded-xl bg-violet-50 text-violet-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <p class="text-4xl font-black text-slate-800 font-[Outfit]">{{ number_format($totalQuestions) }}</p>
                <p class="text-sm font-bold text-slate-600 mt-1">Soal di Bank</p>
                <p class="text-xs font-medium text-slate-400 mt-1">Total pertanyaan</p>
            </div>

            <div class="bg-white border border-emerald-100 rounded-2xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <p class="text-4xl font-black text-slate-800 font-[Outfit]">{{ number_format($totalActiveAttempts) }}</p>
                <p class="text-sm font-bold text-slate-600 mt-1">Sesi Ujian Aktif</p>
                <p class="text-xs font-medium text-slate-400 mt-1">Belum disubmit</p>
            </div>

            <div class="bg-white border border-orange-100 rounded-2xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 rounded-xl bg-orange-50 text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                </div>
                <p class="text-4xl font-black text-slate-800 font-[Outfit]">{{ number_format($totalPendingRequests) }}</p>
                <p class="text-sm font-bold text-slate-600 mt-1">Permohonan Pending</p>
                <p class="text-xs font-medium text-slate-400 mt-1">Menunggu approval</p>
            </div>

        </div>
    </div>

    <!-- Quick links -->
    <div>
        <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Akses Cepat
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <a href="{{ route('admin.bank-soal') }}" class="group bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg hover:border-indigo-300 hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">Kelola Bank Soal</p>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-slate-500 font-medium">Tambah, edit, atau hapus soal ujian (Listening, Structure, Reading).</p>
            </a>

            <a href="{{ route('admin.paket-tes') }}" class="group bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg hover:border-indigo-300 hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">Kelola Paket Tes</p>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-slate-500 font-medium">Atur paket tes yang tersedia untuk simulasi mahasiswa.</p>
            </a>

            <a href="{{ route('admin.requests') }}" class="group bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg hover:border-indigo-300 hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <p class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">Permohonan Ujian</p>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-slate-500 font-medium">Tinjau dan setujui permohonan mahasiswa yang ingin mengulang tes atau menambah limit.</p>
            </a>

        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard - TOEFLin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    @php
        $lastAttempt = $attempts->first();
        $totalThisMonth = $attempts->filter(fn($a) => $a->date->format('Y-m') === date('Y-m'))->count();
        $takenThisWeek = $attempts->filter(fn($a) => $a->date->diffInDays(now()) < 7)->count() > 0;
        $lastScaledScores = $lastAttempt && $lastAttempt->scaledScores ? json_decode($lastAttempt->scaledScores, true) : null;
    @endphp

    <!-- Hero Section -->
    <div class="relative rounded-3xl p-8 md:p-10 overflow-hidden bg-white shadow-xl shadow-blue-500/5 border border-slate-100 flex flex-col md:flex-row justify-between items-center md:items-start gap-6">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full blur-3xl opacity-60 -z-10 translate-x-20 -translate-y-20"></div>
        <div class="z-10 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3 text-slate-800">
                Halo, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-slate-500 text-lg">Siap untuk berlatih TOEFL ITP hari ini?</p>
        </div>
        <a href="{{ route('student.packages') }}"
           class="z-10 px-8 py-4 bg-blue-600 text-white rounded-full font-bold flex items-center gap-3 shadow-xl shadow-blue-600/30 transition-all hover:scale-105 hover:shadow-blue-600/40">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Mulai Tes Baru
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Skor Terakhir -->
        <div class="relative rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 p-8 text-white shadow-xl shadow-indigo-600/20 overflow-hidden flex flex-col justify-between min-h-[300px]">
            <div class="absolute -right-6 -bottom-6 opacity-10 rotate-12">
                <svg class="w-48 h-48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            
            @if($lastAttempt)
                <div class="z-10">
                    <p class="text-sm font-medium text-blue-100 mb-2 uppercase tracking-wider">Skor Simulasi Terakhir</p>
                    <div class="flex items-baseline gap-2 mb-8">
                        <h2 class="text-6xl font-black tracking-tight">
                            {{ $lastAttempt->totalScore ?? 0 }}
                        </h2>
                        <p class="text-blue-200 font-medium">/ 677</p>
                    </div>
                </div>
                <div class="z-10 grid grid-cols-3 gap-4 border-t border-white/20 pt-6 mt-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-blue-200 uppercase tracking-wider mb-1">Listening</span>
                        <span class="font-bold text-xl">{{ $lastScaledScores['listening'] ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-blue-200 uppercase tracking-wider mb-1">Structure</span>
                        <span class="font-bold text-xl">{{ $lastScaledScores['structure'] ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-blue-200 uppercase tracking-wider mb-1">Reading</span>
                        <span class="font-bold text-xl">{{ $lastScaledScores['reading'] ?? '-' }}</span>
                    </div>
                </div>
            @else
                <div class="flex-1 flex flex-col justify-center items-center gap-4 text-center z-10">
                    <svg class="w-12 h-12 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <div>
                        <p class="font-bold text-xl text-white">Belum Ada Riwayat Tes</p>
                        <p class="text-sm text-blue-200 mt-1">Nilai TOEFL simulasi pertama Anda akan muncul di sini.</p>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Progress Belajar -->
        <div class="rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-200/50 p-8 flex flex-col justify-between relative overflow-hidden min-h-[300px]">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full blur-2xl opacity-80 -z-10"></div>
            
            <div class="z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-50 text-green-700 mb-6">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-wider">Progress Belajar</span>
                </div>
                <h2 class="text-3xl font-bold text-slate-800 mb-2">
                    {{ $totalThisMonth > 0 ? 'Hebat! 🔥' : 'Mulai Berlatih! 🚀' }}
                </h2>
                <p class="text-slate-500">
                    Anda sudah mengerjakan <b>{{ $totalThisMonth }}</b> Full Test bulan ini.
                </p>
            </div>
            <div class="z-10 mt-8 p-5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                 <span class="text-slate-600 font-medium text-sm">Kesempatan Ujian Minggu Ini</span>
                 <span class="px-4 py-1.5 rounded-full font-bold text-sm shadow-sm {{ $takenThisWeek ? 'bg-red-50 border border-red-200 text-red-600' : 'bg-green-50 border border-green-200 text-green-600' }}">
                     {{ $takenThisWeek ? 'Sudah Terpakai' : 'Tersedia' }}
                 </span>
            </div>
        </div>
    </div>

</div>
@endsection

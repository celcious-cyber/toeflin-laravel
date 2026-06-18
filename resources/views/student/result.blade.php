@extends('layouts.app')

@section('title', 'Hasil Simulasi - TOEFLin')

@section('content')
<main class="min-h-[80vh] flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-green-500/10 blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-blue-500/10 blur-[120px]"></div>

    <div class="bg-white/90 backdrop-blur-xl max-w-lg w-full rounded-3xl p-10 text-center flex flex-col items-center gap-6 shadow-2xl border border-white">
        
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center animate-bounce-slow">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <div>
            <h1 class="text-3xl font-black font-[Outfit] text-slate-800">Simulasi Selesai!</h1>
            <p class="text-slate-500 mt-2">Anda telah menyelesaikan <b>{{ $attempt->package->name }}</b>.</p>
        </div>

        <div class="w-full p-8 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 shadow-lg text-white">
            <p class="text-sm font-semibold opacity-80 uppercase tracking-wider mb-2">Total Skor TOEFL ITP</p>
            <h2 class="text-7xl font-black font-[Outfit] drop-shadow-md">{{ $attempt->totalScore ?? 0 }}</h2>
            <p class="text-xs opacity-70 mt-3 bg-white/20 inline-block px-3 py-1 rounded-full">Estimasi Skala 310 - 677</p>
        </div>

        @php
            $scaledScores = is_string($attempt->scaledScores) ? json_decode($attempt->scaledScores, true) : $attempt->scaledScores;
        @endphp

        <div class="grid grid-cols-3 gap-4 w-full">
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 flex flex-col items-center justify-center">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Listening</p>
                <p class="text-2xl font-black text-blue-700">{{ $scaledScores['listening'] ?? '-' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-green-50 border border-green-100 flex flex-col items-center justify-center">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Structure</p>
                <p class="text-2xl font-black text-green-700">{{ $scaledScores['structure'] ?? '-' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-purple-50 border border-purple-100 flex flex-col items-center justify-center">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Reading</p>
                <p class="text-2xl font-black text-purple-700">{{ $scaledScores['reading'] ?? '-' }}</p>
            </div>
        </div>

        <div class="w-full flex gap-3 mt-4">
            <a href="{{ route('student.dashboard') }}" class="w-full py-4 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 transition-colors">
                Ke Dashboard
            </a>
            <!-- Fitur Sertifikat bisa ditambahkan di sini dengan library jspdf & html2canvas -->
            <button class="w-full py-4 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-md transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Sertifikat
            </button>
        </div>
    </div>
</main>
@endsection

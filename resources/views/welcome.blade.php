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
    
    <div class="flex justify-center gap-4">
        @auth
            <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'student.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition-colors text-lg">
                Masuk ke Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition-colors text-lg">
                Mulai Simulasi (Login)
            </a>
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

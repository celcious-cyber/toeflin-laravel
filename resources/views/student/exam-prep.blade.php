@extends('layouts.app')

@section('title', 'Persiapan Ujian - TOEFLin')

@section('content')
<main className="min-h-screen flex items-center justify-center p-6 relative bg-slate-50">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-blue-500/10 blur-[120px]"></div>
    
    <div class="bg-white max-w-2xl mx-auto w-full rounded-3xl p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center z-10 relative mt-10 mb-20">
        
        <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        </div>
        
        <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Persiapan Ujian 📝</h1>
        <p class="text-slate-500 text-center mb-8">Harap baca dengan cermat aturan dan informasi berikut sebelum memulai tes <b>{{ $package->name }}</b>.</p>
        
        <div class="w-full bg-slate-50 rounded-2xl p-6 border border-slate-100 mb-8 space-y-4">
            <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Durasi Ujian</p>
                    <p class="font-bold text-lg text-slate-700">120 Menit</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah Soal</p>
                    <p class="font-bold text-lg text-slate-700">{{ is_array($package->questions) ? count($package->questions) : 0 }} Soal</p>
                </div>
            </div>

            <!-- AUDIO TEST BOX -->
            <div class="flex items-center justify-between bg-blue-50/50 p-4 rounded-xl border border-blue-100" x-data="{ testAudio: null }">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengecekan Audio</p>
                        <p class="font-medium text-sm text-slate-700">Pastikan suara terdengar dengan jelas.</p>
                    </div>
                </div>
                <button 
                    @click="
                        if (!testAudio) { testAudio = new Audio('{{ asset('audio-test.mp3') }}'); }
                        testAudio.pause();
                        testAudio.currentTime = 0;
                        testAudio.play().catch(e => alert('Audio belum siap.'));
                    "
                    class="px-4 py-2 bg-white text-blue-600 font-bold text-sm rounded-lg border border-blue-200 shadow-sm hover:bg-blue-50 hover:shadow transition-all"
                >
                    Tes Suara
                </button>
            </div>
        </div>
        
        <ul class="w-full space-y-3 mb-10 text-sm text-slate-600">
            <li class="flex gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Waktu akan mulai berjalan secara otomatis ketika Anda menekan tombol <b>Mulai Ujian Sekarang</b>.</span>
            </li>
            <li class="flex gap-3">
                <svg class="w-5 h-5 text-orange-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Sistem keamanan akan mengunci layar menjadi <b>Mode Penuh (Full Screen)</b>. Pelanggaran dapat membatalkan ujian Anda.</span>
            </li>
            <li class="flex gap-3">
                <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                <span>Untuk soal Listening, pastikan volume perangkat Anda sudah sesuai. Audio hanya dapat diputar SATU KALI.</span>
            </li>
        </ul>

        <div x-data="{ showConfirm: false }" class="w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 text-center font-bold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 text-center font-bold">
                    {{ session('error') }}
                </div>
            @endif

            @if($hasQuota || $approvedRequest)
                <button 
                    @click="showConfirm = true" 
                    class="w-full py-4 rounded-2xl bg-blue-600 text-white font-bold text-lg flex items-center justify-center gap-2 hover:bg-blue-700 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-600/30 transition-all duration-300"
                >
                    {{ $approvedRequest ? 'Gunakan Kuota & Mulai Ujian' : 'Mulai Ujian Sekarang' }} <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            @elseif($pendingRequest)
                <div class="w-full py-4 rounded-2xl bg-slate-100 text-slate-500 font-bold text-lg flex items-center justify-center gap-2 border border-slate-200 cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Permohonan Kuota Sedang Diproses Admin
                </div>
            @else
                <div class="text-center">
                    <p class="text-red-500 font-bold mb-4">Anda telah mencapai batas ujian minggu ini (1 kali/minggu).</p>
                    <form action="{{ route('student.exam.request', $package->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 rounded-2xl bg-orange-500 text-white font-bold text-lg flex items-center justify-center gap-2 hover:bg-orange-600 transition-all duration-300 shadow-md">
                            Ajukan Permohonan Tambahan Kuota
                        </button>
                    </form>
                </div>
            @endif

            <!-- Modal Konfirmasi -->
            <div x-show="showConfirm" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4" style="display: none;">
                <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative" @click.away="showConfirm = false">
                    <button 
                        @click="showConfirm = false"
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                    
                    <div class="text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 mb-3">Mulai Ujian?</h3>
                        <p class="text-slate-600 mb-8 leading-relaxed">
                            Apakah Anda yakin sudah siap dan ingin memulai tes <b>{{ $package->name }}</b> sekarang?
                        </p>
                        
                        <div class="flex gap-4">
                            <button
                                @click="showConfirm = false"
                                class="w-full py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-colors"
                            >
                                Batal
                            </button>
                            <form action="{{ route('student.exam.start', $package->id) }}" method="POST" class="w-full">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition-all shadow-md"
                                >
                                    Ya, Mulai Tes!
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

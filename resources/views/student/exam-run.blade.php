<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ujian Berlangsung - TOEFLin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        /* Prevent selection */
        .no-select { user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; }
    </style>
</head>
<body class="text-slate-800 antialiased flex flex-col min-h-screen no-select" x-data="examEngine()">
    <!-- Start Exam Overlay (Requires user click for Fullscreen API to work) -->
    <div x-show="!examStarted" class="fixed inset-0 bg-slate-900 z-[100] flex flex-col items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-lg text-center shadow-2xl">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 font-[Outfit] mb-4">Siap Memulai?</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">Ujian ini menggunakan standar keamanan CBT. <strong>Layar akan diubah ke mode penuh (Fullscreen).</strong> Semua pintasan keyboard, blok teks, dan klik kanan telah dinonaktifkan.</p>
            <button @click="startExamMode()" class="w-full justify-center flex items-center gap-2 px-8 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 shadow-md shadow-blue-500/30 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Mulai Ujian
            </button>
        </div>
    </div>

    <div class="w-full max-w-7xl mx-auto flex flex-col flex-1 h-screen overflow-hidden p-3" x-show="examStarted" style="display: none;">
        <!-- Top Bar -->
        <header class="h-16 glass rounded-2xl flex items-center justify-between px-6 z-20 shrink-0 mb-3 shadow-sm border border-slate-200">
            <div class="flex items-center gap-4">
                <button @click="showNav = !showNav" class="p-2 -ml-2 rounded-xl hover:bg-slate-100 transition-colors text-slate-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="font-bold text-lg hidden sm:block font-[Outfit] text-blue-800">
                    {{ $attempt->package->name }}
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div :class="{'text-red-600 animate-pulse font-extrabold': timeLeft < 300, 'text-slate-700': timeLeft >= 300}" class="flex items-center gap-2 font-mono font-bold text-xl bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                    <span x-text="formatTime(timeLeft)"></span>
                </div>
            </div>
        </header>

        <!-- Question Area -->
        <div class="flex-1 flex flex-col md:flex-row gap-3 min-h-0">
            <!-- Question Navigator -->
            <aside x-show="showNav" class="glass w-full md:w-64 shrink-0 rounded-2xl p-4 overflow-y-auto flex flex-col shadow-sm border border-slate-200" x-transition>
                <p class="text-xs font-bold text-slate-400 mb-3 uppercase tracking-wider text-center">Navigasi Soal</p>
                <div class="grid grid-cols-5 gap-2">
                    <template x-for="(q, i) in questions" :key="q.id">
                        <button @click="currentIdx = i"
                            :title="q.isInstruction ? 'Instruksi ' + q.section : 'Soal ' + q.displayStr"
                            :class="{
                                'bg-amber-100 text-amber-700 border-dashed border-amber-300': q.isInstruction && i !== currentIdx,
                                'bg-amber-500 text-white shadow-md border-amber-600 scale-105': q.isInstruction && i === currentIdx,
                                'bg-blue-600 text-white shadow-md border-blue-600 scale-105': !q.isInstruction && i === currentIdx && !answers[q.id] && !doubtful[q.id],
                                'bg-green-500 text-white shadow-md border-green-600 scale-105': !q.isInstruction && i === currentIdx && answers[q.id] && !doubtful[q.id],
                                'bg-orange-500 text-white shadow-md border-orange-600 scale-105': !q.isInstruction && i === currentIdx && doubtful[q.id],
                                'bg-green-50 text-green-600 border-green-200 hover:bg-green-100': !q.isInstruction && i !== currentIdx && answers[q.id] && !doubtful[q.id],
                                'bg-orange-50 text-orange-600 border-orange-200 hover:bg-orange-100': !q.isInstruction && i !== currentIdx && doubtful[q.id],
                                'bg-slate-50 text-slate-500 border-slate-200 hover:bg-slate-100': !q.isInstruction && i !== currentIdx && !answers[q.id] && !doubtful[q.id]
                            }"
                            class="relative w-full aspect-square rounded-xl flex items-center justify-center transition-all border font-bold text-sm">
                            
                            <template x-if="q.isInstruction">
                                <span class="font-serif italic font-black text-lg">i</span>
                            </template>

                            <template x-if="!q.isInstruction">
                                <div class="w-full h-full flex items-center justify-center relative">
                                    <!-- Terjawab Indikator -->
                                    <template x-if="answers[q.id]">
                                        <div>
                                            <div :class="(i === currentIdx || doubtful[q.id]) ? 'border-white text-white' : 'border-green-600 text-green-600'" class="absolute top-0.5 right-0.5 w-3 h-3 rounded-full border-2 flex items-center justify-center text-[8px] font-bold">
                                                <span x-text="answers[q.id].toUpperCase()"></span>
                                            </div>
                                            <span :class="(i === currentIdx || doubtful[q.id]) ? 'text-white' : 'text-slate-800'" class="absolute bottom-0.5 left-1.5" x-text="q.displayStr"></span>
                                        </div>
                                    </template>

                                    <!-- Belum Terjawab Indikator -->
                                    <template x-if="!answers[q.id]">
                                        <span x-text="q.displayStr"></span>
                                    </template>
                                </div>
                            </template>
                        </button>
                    </template>
                </div>
                <div class="mt-auto pt-4 border-t border-slate-200 text-xs font-semibold text-slate-500 text-center flex flex-col gap-2">
                    <p>Terjawab: <span class="text-green-600" x-text="Object.keys(answers).length"></span> / <span x-text="totalRealQuestions"></span></p>
                    <p>Ragu-ragu: <span class="text-orange-500" x-text="Object.keys(doubtful).filter(k => doubtful[k]).length"></span></p>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col lg:flex-row gap-3 overflow-hidden min-h-0">
                
                <!-- Passage (Reading) -->
                <template x-if="currentQ?.passage && !currentQ?.isInstruction">
                    <div class="flex-1 lg:max-w-[50%] glass rounded-2xl p-8 overflow-y-auto shadow-sm border border-slate-200">
                        <h3 class="font-bold text-xl mb-4 font-[Outfit] text-slate-800" x-text="currentQ.passage.title"></h3>
                        <div class="prose prose-slate max-w-none whitespace-pre-wrap leading-relaxed text-slate-700" x-text="currentQ.passage.content"></div>
                    </div>
                </template>
                
                <!-- Question & Choices -->
                <div :class="(currentQ?.passage && !currentQ?.isInstruction) ? 'flex-1 lg:max-w-[50%]' : 'flex-1'" class="glass rounded-2xl p-6 md:p-10 flex flex-col overflow-y-auto shadow-sm border border-slate-200">
                    <template x-if="currentQ">
                        <div class="flex flex-col h-full">
                            <div class="flex items-center justify-between mb-6">
                                <template x-if="!currentQ.isInstruction">
                                    <span class="text-sm font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">Soal <span x-text="currentQ.displayStr"></span> / <span x-text="totalRealQuestions"></span></span>
                                </template>
                                <template x-if="currentQ.isInstruction">
                                    <span class="text-sm font-bold text-amber-800 uppercase tracking-widest bg-amber-100 px-3 py-1 rounded-full border border-amber-200">Petunjuk Pengerjaan</span>
                                </template>
                                <span :class="currentQ.section === 'Listening' ? 'bg-blue-100 text-blue-700' : currentQ.section === 'Structure' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700'" class="text-xs px-3 py-1 rounded-full font-bold border border-transparent" x-text="currentQ.section"></span>
                            </div>

                            <!-- Audio Player for Listening -->
                            <template x-if="currentQ.section === 'Listening' && currentQ.audio && !currentQ.isInstruction">
                                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-100 flex items-center gap-4 shadow-sm">
                                    <div class="bg-white p-2 rounded-full shadow-sm text-blue-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-800">Audio Soal</p>
                                        <p class="text-xs text-slate-500">Audio hanya dapat diputar 1 kali</p>
                                    </div>
                                    <button
                                        :disabled="audioPlayed[currentQ.id]"
                                        @click="playAudio()"
                                        :class="audioPlayed[currentQ.id] ? 'bg-slate-200 text-slate-400 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm'"
                                        class="px-5 py-2.5 rounded-xl text-sm font-bold transition-colors">
                                        <span x-text="audioPlayed[currentQ.id] ? 'Sudah Diputar' : 'Putar Audio'"></span>
                                    </button>
                                </div>
                            </template>

                            <!-- Question Text -->
                            <div class="text-lg md:text-xl font-medium leading-relaxed mb-8 text-slate-800" :class="{'whitespace-pre-wrap': currentQ.isInstruction}" x-html="currentQ.content"></div>

                            <!-- Choices -->
                            <template x-if="!currentQ.isInstruction">
                                <div class="flex flex-col gap-3 flex-1 mb-8">
                                    <template x-for="(entry, idx) in currentQ.shuffledEntries" :key="entry[0]">
                                        <button @click="selectAnswer(entry[0])"
                                            :class="answers[currentQ.id] === entry[0] ? 'bg-blue-50 border-blue-300 ring-2 ring-blue-500/20' : 'bg-white border-slate-200 hover:bg-slate-50 hover:border-blue-300'"
                                            class="text-left p-4 rounded-xl border transition-all flex items-start group shadow-sm">
                                            <span :class="answers[currentQ.id] === entry[0] ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600'" class="inline-flex items-center justify-center min-w-[32px] h-8 rounded-full text-sm font-bold mr-4 mt-0.5 transition-colors" x-text="String.fromCharCode(65 + idx)"></span>
                                            <span class="text-slate-700 leading-relaxed pt-1" x-text="entry[1]"></span>
                                        </button>
                                    </template>
                                </div>
                            </template>

                            <template x-if="currentQ.isInstruction">
                                <div class="flex-1 flex items-center justify-center mb-8">
                                    <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100 text-center max-w-md">
                                        <svg class="w-12 h-12 text-amber-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <h4 class="font-bold text-amber-800 mb-2">Instruksi</h4>
                                        <p class="text-sm text-amber-700">Bacalah petunjuk pengerjaan di atas dengan saksama sebelum memulai bagian ini.</p>
                                    </div>
                                </div>
                            </template>

                            <!-- Bottom Actions -->
                            <div class="flex flex-col sm:flex-row justify-between items-center mt-auto pt-6 border-t border-slate-200 gap-3">
                                <button @click="if(currentIdx > 0) currentIdx--" :disabled="currentIdx === 0"
                                    class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 shadow-sm rounded-xl font-bold text-sm disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto justify-center hover:bg-slate-50 transition-colors text-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Sebelumnya
                                </button>

                                <template x-if="!currentQ.isInstruction">
                                    <button @click="toggleDoubtful()" 
                                        :class="doubtful[currentQ?.id] ? 'bg-orange-500 text-white shadow-md border-orange-600' : 'bg-white border border-slate-200 shadow-sm text-slate-600 hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200'"
                                        class="flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm transition-all w-full sm:w-auto justify-center">
                                        Ragu-ragu
                                    </button>
                                </template>

                                <template x-if="currentIdx === questions.length - 1">
                                    <button @click="showConfirm = true" class="w-full sm:w-auto justify-center px-8 py-3 bg-green-600 text-white rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-green-700 shadow-md transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Selesai & Kirim
                                    </button>
                                </template>
                                <template x-if="currentIdx < questions.length - 1">
                                    <button @click="currentIdx++" class="w-full sm:w-auto justify-center flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 shadow-md transition-colors">
                                        <span x-text="currentQ.isInstruction ? 'Mulai Bagian Ini' : 'Selanjutnya'"></span> <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                    
                    <template x-if="!currentQ">
                        <div class="flex-1 flex flex-col items-center justify-center opacity-50 gap-3">
                            <svg class="w-16 h-16 opacity-30 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <p class="font-bold text-slate-600 text-lg">Tidak ada soal.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Submit Modal -->
    <div x-show="showConfirm" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" style="display: none;" x-transition>
        <div class="bg-white w-full max-w-sm rounded-3xl p-8 text-center flex flex-col gap-4 shadow-2xl" @click.away="showConfirm = false">
            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 font-[Outfit]">Kirim Jawaban?</h2>
            <p class="text-sm text-slate-500 leading-relaxed">Pastikan Anda sudah menjawab semua soal. Jawaban tidak bisa diubah setelah dikirim.</p>
            <div class="bg-slate-50 py-3 rounded-xl border border-slate-100 mt-2">
                <p class="text-sm font-semibold text-slate-700">Terjawab: <span class="text-green-600 text-lg" x-text="Object.keys(answers).length"></span> / <span x-text="totalRealQuestions"></span> soal</p>
            </div>
            <div class="flex gap-3 mt-4">
                <button @click="showConfirm = false" class="flex-1 px-5 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">Cek Lagi</button>
                <button @click="submitTest" class="flex-1 px-5 py-3 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700 shadow-md transition-colors flex items-center justify-center gap-2">
                    <span x-text="isSubmitting ? 'Mengirim...' : 'Ya, Kirim!'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- AUDIO ELEMENT UNTUK LISTENING -->
    <audio id="examAudioPlayer" style="display:none;"></audio>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('examEngine', () => ({
                attemptId: '{{ $attempt->id }}',
                rawQuestions: @json($attempt->package->questions ?? []),
                packageInst: {
                    Listening: {!! json_encode($attempt->package->instruction_listening ?: "In this section, you will be evaluated on your ability to understand spoken English.") !!},
                    Structure: {!! json_encode($attempt->package->instruction_structure ?: "In this section, you will read sentences with missing words or phrases. Choose the one that best completes the sentence.") !!},
                    Reading: {!! json_encode($attempt->package->instruction_reading ?: "In this section, you will read several passages. Each one is followed by a number of questions about it.") !!}
                },
                questions: [], // Akan diisi di init()
                answers: @json($attempt->answers ?: new \stdClass()),
                doubtful: {},
                currentIdx: 0,
                // Hitung total durasi dari paket (dalam menit -> detik)
                @php
                    $d = is_array($attempt->package->durations) ? $attempt->package->durations : json_decode($attempt->package->durations, true);
                    $totalMinutes = ($d['Listening'] ?? 0) + ($d['Structure'] ?? 0) + ($d['Reading'] ?? 0);
                    $totalSeconds = $totalMinutes * 60;
                @endphp
                totalDurationSeconds: {{ $totalSeconds > 0 ? $totalSeconds : 7200 }},
                timeLeft: {{ $totalSeconds > 0 ? $totalSeconds : 7200 }},
                showNav: true,
                showConfirm: false,
                isSubmitting: false,
                examStarted: false,
                audioPlayed: {},

                get currentQ() {
                    return this.questions[this.currentIdx] || null;
                },

                // Menghitung jumlah soal asli (bukan instruksi)
                get totalRealQuestions() {
                    return this.questions.filter(q => !q.isInstruction).length;
                },

                init() {
                    // Inject Virtual Instruction Slides
                    let finalQ = [];
                    let currentSec = null;
                    let realCount = 1;
                    
                    for(let q of this.rawQuestions) {
                        if (q.section !== currentSec) {
                            finalQ.push({
                                id: 'inst-' + q.section,
                                isInstruction: true,
                                section: q.section,
                                content: this.packageInst[q.section],
                                displayStr: 'i'
                            });
                            currentSec = q.section;
                        }
                        q.displayStr = realCount.toString();
                        realCount++;
                        finalQ.push(q);
                    }
                    this.questions = finalQ;

                    // Security measures
                    this.setupSecurity();
                },

                startExamMode() {
                    this.examStarted = true;
                    this.requestFullscreen();

                    // Start Timer
                    setInterval(() => {
                        if(this.timeLeft > 0 && !this.isSubmitting) {
                            this.timeLeft--;
                            if(this.timeLeft === 0) {
                                this.submitTest();
                            }
                        }
                    }, 1000);

                    // Auto-save every 30 seconds
                    setInterval(() => {
                        this.saveProgress();
                    }, 30000);
                },

                formatTime(s) {
                    const h = Math.floor(s / 3600);
                    const m = Math.floor((s % 3600) / 60);
                    const sc = s % 60;
                    return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${sc.toString().padStart(2, '0')}`;
                },

                selectAnswer(key) {
                    if(!this.currentQ) return;
                    this.answers[this.currentQ.id] = key;
                },

                toggleDoubtful() {
                    if(!this.currentQ) return;
                    this.doubtful[this.currentQ.id] = !this.doubtful[this.currentQ.id];
                },

                playAudio() {
                    if(!this.currentQ || !this.currentQ.audio || this.audioPlayed[this.currentQ.id]) return;
                    
                    const player = document.getElementById('examAudioPlayer');
                    player.src = this.currentQ.audio.fileUrl;
                    player.play().then(() => {
                        this.audioPlayed[this.currentQ.id] = true;
                    }).catch(e => {
                        alert("Gagal memutar audio. " + e.message);
                    });
                },

                async saveProgress() {
                    if(this.isSubmitting) return;
                    try {
                        await fetch(`/exam/attempt/${this.attemptId}/save`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                answers: this.answers,
                                durationSeconds: this.totalDurationSeconds - this.timeLeft
                            })
                        });
                    } catch(e) {
                        console.error('Auto-save failed', e);
                    }
                },

                async submitTest() {
                    if(this.isSubmitting) return;
                    this.isSubmitting = true;

                    // Exits fullscreen
                    if (document.fullscreenElement) {
                        document.exitFullscreen().catch(e => console.error(e));
                    }

                    try {
                        const res = await fetch(`/exam/attempt/${this.attemptId}/submit`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                answers: this.answers,
                                durationSeconds: this.totalDurationSeconds - this.timeLeft
                            })
                        });

                        const data = await res.json();
                        if(data.success && data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            alert("Gagal mengirim jawaban.");
                            this.isSubmitting = false;
                        }
                    } catch(e) {
                        alert("Terjadi kesalahan jaringan.");
                        this.isSubmitting = false;
                    }
                },

                setupSecurity() {
                    document.addEventListener('contextmenu', e => { e.preventDefault(); });
                    document.addEventListener('copy', e => { e.preventDefault(); });
                    document.addEventListener('cut', e => { e.preventDefault(); });
                    document.addEventListener('paste', e => { e.preventDefault(); });
                    document.addEventListener('keydown', e => {
                        // Prevent common shortcuts: F12, Ctrl+Shift+I/J/C, Ctrl+U/C/V/X, PrintScreen, Alt+Tab (limited)
                        if (
                            e.key === 'F12' || 
                            e.key === 'PrintScreen' ||
                            (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key.toUpperCase())) || 
                            (e.ctrlKey && ['U', 'C', 'V', 'X', 'S', 'P'].includes(e.key.toUpperCase()))
                        ) {
                            e.preventDefault();
                        }
                    });
                },

                requestFullscreen() {
                    const docEl = document.documentElement;
                    if (docEl.requestFullscreen) { docEl.requestFullscreen().catch(e => console.log(e)); }
                }
            }));
        });
    </script>
</body>
</html>

@extends('layouts.admin')

@section('title', 'Bank Soal - Admin Portal')
@section('header', 'Kelola Bank Soal')

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-6" x-data="{ 
    showAddModal: false, 
    showViewModal: false,
    showEditModal: false,
    section: 'Listening',
    activeItem: null,
    allQuestions: @js($questions),
    packages: @js($packages),
    passages: @js($passages),
    selectedPassage: 'new',
    editSelectedPassage: 'new',
    questionsList: [1],
    filterPackage: '',
    filterSection: '',
    filterAnswer: '',
    get filteredQuestions() {
        return this.allQuestions.filter(q => {
            if (this.filterPackage && q.packageId !== this.filterPackage) return false;
            if (this.filterSection && q.section !== this.filterSection) return false;
            if (this.filterAnswer && q.answerKey !== this.filterAnswer) return false;
            return true;
        });
    }
}">

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-semibold flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="flex items-center justify-between bg-white p-6 rounded-t-2xl shadow-sm border border-slate-200 border-b-0">
        <div>
            <h3 class="font-bold text-lg text-slate-800">Daftar Soal</h3>
            <p class="text-sm text-slate-500 mt-1">Total: <span x-text="allQuestions.length"></span> soal di dalam bank.</p>
        </div>
        <button @click="showAddModal = true" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 transition-colors flex items-center gap-2 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Tambah Soal
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white px-6 pb-6 rounded-b-2xl shadow-sm border border-slate-200 border-t-0 flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-bold text-slate-500 mb-1">Filter Paket</label>
            <select x-model="filterPackage" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none text-sm">
                <option value="">Semua Paket</option>
                <template x-for="pkg in packages" :key="pkg.id">
                    <option :value="pkg.id" x-text="pkg.name"></option>
                </template>
            </select>
        </div>
        <div class="w-48">
            <label class="block text-xs font-bold text-slate-500 mb-1">Filter Section</label>
            <select x-model="filterSection" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none text-sm">
                <option value="">Semua Section</option>
                <option value="Listening">Listening</option>
                <option value="Structure">Structure</option>
                <option value="Reading">Reading</option>
            </select>
        </div>
        <div class="w-40">
            <label class="block text-xs font-bold text-slate-500 mb-1">Filter Jawaban</label>
            <select x-model="filterAnswer" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none text-sm">
                <option value="">Semua</option>
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
                <option value="d">D</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div x-show="filteredQuestions.length > 0" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" style="display: none;">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider">Bagian (Section)</th>
                    <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider w-1/2">Konten Soal</th>
                    <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider">Kunci</th>
                    <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <template x-for="q in filteredQuestions" :key="q.id">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold" 
                                :class="q.section === 'Listening' ? 'bg-blue-100 text-blue-700' : (q.section === 'Structure' ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700')"
                                x-text="q.section">
                            </span>
                            <div class="mt-2 text-[10px] font-bold text-slate-400" x-show="q.package" x-text="'📦 ' + (q.package?.name || '')"></div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm font-semibold text-slate-800 line-clamp-2" x-html="q.content.replace(/(<([^>]+)>)/gi, '')"></p>
                            
                            <template x-if="q.audio">
                                <span class="text-xs text-blue-500 font-bold mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg> Audio Tersedia</span>
                            </template>
                            <template x-if="q.passage">
                                <span class="text-xs text-emerald-500 font-bold mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> Teks Reading: <span x-text="q.passage.title"></span></span>
                            </template>
                        </td>
                        <td class="py-4 px-6">
                            <span class="w-6 h-6 flex items-center justify-center bg-slate-800 text-white rounded-md text-xs font-black uppercase" x-text="q.answerKey"></span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" @click="activeItem = q; showViewModal = true" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors border border-transparent hover:border-indigo-200" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button type="button" @click="activeItem = Object.assign({}, q); editSelectedPassage = q.passageId || 'new'; showEditModal = true" class="p-2 text-orange-500 hover:bg-orange-50 rounded-lg transition-colors border border-transparent hover:border-orange-200" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form :action="'{{ url('/admin/dashboard/bank-soal') }}/' + q.id" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus soal ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-200" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div x-show="filteredQuestions.length === 0" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 flex flex-col items-center justify-center text-center" style="display: none;">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-700">Bank Soal Masih Kosong</h4>
            <p class="text-slate-500 mt-2 max-w-md">Belum ada soal yang ditambahkan. Klik tombol "Tambah Soal" untuk mulai.</p>
        </div>

    <!-- Add Modal -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="showAddModal = false" class="bg-white rounded-3xl w-full max-w-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-black text-lg text-slate-800">Tambah Soal Baru</h3>
                <button @click="showAddModal = false" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.bank-soal.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Paket (Opsional)</label>
                        <select name="packageId" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                            <option value="">-- Tanpa Paket (Master Bank) --</option>
                            <template x-for="pkg in packages" :key="pkg.id">
                                <option :value="pkg.id" x-text="pkg.name"></option>
                            </template>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Hanya untuk pengelompokan di tabel.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Bagian (Section)</label>
                        <select name="section" x-model="section" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                            <option value="Listening">Listening Comprehension</option>
                            <option value="Structure">Structure & Written Expression</option>
                            <option value="Reading">Reading Comprehension</option>
                        </select>
                    </div>
                </div>

                <!-- Listening Audio Upload -->
                <div x-show="section === 'Listening'" class="p-5 bg-blue-50 border border-blue-200 rounded-2xl">
                    <label class="block text-sm font-bold text-blue-900 mb-2 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg> Unggah Audio (MP3/WAV)</label>
                    <input type="file" name="audioFile" accept="audio/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                    <p class="text-xs text-blue-600 mt-2">Dibutuhkan untuk soal Listening.</p>
                </div>

                <!-- Reading Passage -->
                <div x-show="section === 'Reading'" class="p-5 bg-emerald-50 border border-emerald-200 rounded-2xl space-y-4">
                    <label class="block text-sm font-bold text-emerald-900 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> Teks Bacaan (Passage)</label>
                    <select name="passage_id" x-model="selectedPassage" class="w-full px-4 py-2 rounded-lg border border-emerald-300 focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="new">-- Buat Teks Baru --</option>
                        <template x-for="p in passages" :key="p.id">
                            <option :value="p.id" x-text="p.title"></option>
                        </template>
                    </select>
                    <div x-show="selectedPassage === 'new'" class="space-y-4 pt-4 border-t border-emerald-200">
                        <input type="text" name="passageTitle" placeholder="Judul Teks..." class="w-full px-4 py-2 rounded-lg border border-emerald-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <textarea name="passageContent" rows="4" placeholder="Isi teks panjang di sini..." class="w-full px-4 py-3 rounded-lg border border-emerald-300 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                    </div>
                </div>

                <template x-for="(q, idx) in questionsList" :key="idx">
                    <div class="p-6 border border-slate-200 rounded-2xl mb-6 bg-slate-50 relative">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-slate-700" x-text="'Soal #' + (idx + 1)"></h4>
                            <button type="button" x-show="questionsList.length > 1" @click="questionsList.splice(idx, 1)" class="text-sm font-bold text-red-500 hover:text-red-700 transition-colors">
                                Hapus Soal
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pertanyaan / Kalimat Soal</label>
                                <textarea name="content[]" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all" placeholder="Tuliskan pertanyaan di sini..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan A</label>
                                    <input type="text" name="choice_a[]" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan B</label>
                                    <input type="text" name="choice_b[]" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan C</label>
                                    <input type="text" name="choice_c[]" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan D</label>
                                    <input type="text" name="choice_d[]" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kunci Jawaban Benar</label>
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-xl hover:bg-slate-50 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700 font-bold transition-all">
                                        <input type="radio" :name="'answerKey['+idx+']'" value="a" required class="w-4 h-4 text-indigo-600"> A
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-xl hover:bg-slate-50 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700 font-bold transition-all">
                                        <input type="radio" :name="'answerKey['+idx+']'" value="b" required class="w-4 h-4 text-indigo-600"> B
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-xl hover:bg-slate-50 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700 font-bold transition-all">
                                        <input type="radio" :name="'answerKey['+idx+']'" value="c" required class="w-4 h-4 text-indigo-600"> C
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-xl hover:bg-slate-50 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700 font-bold transition-all">
                                        <input type="radio" :name="'answerKey['+idx+']'" value="d" required class="w-4 h-4 text-indigo-600"> D
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex justify-center mt-2 mb-6">
                    <button type="button" @click="questionsList.push(1)" class="flex items-center justify-center w-12 h-12 bg-slate-100 text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 rounded-full shadow-sm border border-slate-200 hover:border-indigo-200 transition-all focus:outline-none focus:ring-4 focus:ring-indigo-100" title="Tambah Soal Baru">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="showAddModal = false; questionsList = [1]" class="px-5 py-2.5 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 transition-colors">Simpan Semua Soal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Modal -->
    <div x-show="showViewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="showViewModal = false" class="bg-white rounded-3xl w-full max-w-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-black text-lg text-slate-800">Detail Soal</h3>
                <button @click="showViewModal = false; activeItem = null" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-8 space-y-6" x-show="activeItem">
                <template x-if="activeItem">
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider" 
                                :class="activeItem.section === 'Listening' ? 'bg-blue-100 text-blue-700' : (activeItem.section === 'Structure' ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700')">
                                <span x-text="activeItem.section"></span>
                            </span>
                        </div>

                        <!-- Audio -->
                        <template x-if="activeItem.audio">
                            <div class="p-5 bg-slate-50 border border-slate-200 rounded-2xl">
                                <p class="text-sm font-bold text-slate-700 mb-2">File Audio</p>
                                <audio controls class="w-full h-10">
                                    <source :src="activeItem.audio.fileUrl" type="audio/mpeg">
                                </audio>
                            </div>
                        </template>

                        <!-- Passage -->
                        <template x-if="activeItem.passage">
                            <div class="p-5 bg-slate-50 border border-slate-200 rounded-2xl space-y-2">
                                <p class="font-bold text-slate-800 text-lg" x-text="activeItem.passage.title"></p>
                                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-wrap" x-text="activeItem.passage.content"></div>
                            </div>
                        </template>

                        <!-- Content -->
                        <div>
                            <p class="text-sm font-bold text-slate-700 mb-2">Pertanyaan</p>
                            <div class="p-5 border border-slate-200 rounded-2xl text-slate-800 font-medium" x-html="activeItem.content"></div>
                        </div>

                        <!-- Choices -->
                        <template x-if="activeItem.choices">
                            <div class="space-y-3">
                                <p class="text-sm font-bold text-slate-700 mb-2">Pilihan Ganda</p>
                                <template x-for="(val, key) in JSON.parse(activeItem.choices)" :key="key">
                                    <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-200" :class="activeItem.answerKey === key ? 'bg-indigo-50 border-indigo-200' : ''">
                                        <span class="w-6 h-6 flex items-center justify-center rounded-md text-xs font-black uppercase" :class="activeItem.answerKey === key ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500'" x-text="key"></span>
                                        <span class="text-sm text-slate-700 font-medium" x-text="val"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="showEditModal = false" class="bg-white rounded-3xl w-full max-w-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-black text-lg text-slate-800">Edit Soal</h3>
                <button @click="showEditModal = false; activeItem = null" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <template x-if="activeItem">
                <form :action="'{{ url('/admin/dashboard/bank-soal') }}/' + activeItem.id" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-8 space-y-6">
                    @csrf @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Paket (Opsional)</label>
                            <select name="packageId" x-model="activeItem.packageId" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                                <option value="">-- Tanpa Paket (Master Bank) --</option>
                                <template x-for="pkg in packages" :key="pkg.id">
                                    <option :value="pkg.id" x-text="pkg.name" :selected="activeItem.packageId === pkg.id"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Bagian (Section)</label>
                            <select name="section" x-model="activeItem.section" class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                                <option value="Listening">Listening Comprehension</option>
                                <option value="Structure">Structure & Written Expression</option>
                                <option value="Reading">Reading Comprehension</option>
                            </select>
                        </div>
                    </div>

                    <div x-show="activeItem.section === 'Listening'" class="p-5 bg-blue-50 border border-blue-200 rounded-2xl">
                        <label class="block text-sm font-bold text-blue-900 mb-2 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg> Unggah Audio Baru (Opsional)</label>
                        <input type="file" name="audioFile" accept="audio/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                        <template x-if="activeItem.audio">
                            <p class="text-xs text-blue-600 mt-2">Biarkan kosong jika tidak ingin mengubah audio yang sudah ada.</p>
                        </template>
                    </div>

                    <div x-show="activeItem.section === 'Reading'" class="p-5 bg-emerald-50 border border-emerald-200 rounded-2xl space-y-4">
                        <label class="block text-sm font-bold text-emerald-900 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> Teks Bacaan (Passage)</label>
                        <select name="passage_id" x-model="editSelectedPassage" class="w-full px-4 py-2 rounded-lg border border-emerald-300 focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                            <option value="new">-- Buat Teks Baru --</option>
                            <template x-for="p in passages" :key="p.id">
                                <option :value="p.id" x-text="p.title"></option>
                            </template>
                        </select>
                        <div x-show="editSelectedPassage === 'new'" class="space-y-4 pt-4 border-t border-emerald-200">
                            <input type="text" name="passageTitle" :value="activeItem.passage?.title" placeholder="Judul Teks..." class="w-full px-4 py-2 rounded-lg border border-emerald-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <textarea name="passageContent" :value="activeItem.passage?.content" rows="4" placeholder="Isi teks panjang di sini..." class="w-full px-4 py-3 rounded-lg border border-emerald-300 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pertanyaan / Kalimat Soal</label>
                        <textarea name="content" x-model="activeItem.content" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all" placeholder="Tuliskan pertanyaan di sini..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan A</label>
                            <input type="text" name="choice_a" :value="JSON.parse(activeItem.choices || '{}').a" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan B</label>
                            <input type="text" name="choice_b" :value="JSON.parse(activeItem.choices || '{}').b" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan C</label>
                            <input type="text" name="choice_c" :value="JSON.parse(activeItem.choices || '{}').c" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Pilihan D</label>
                            <input type="text" name="choice_d" :value="JSON.parse(activeItem.choices || '{}').d" required class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:border-indigo-600 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kunci Jawaban Benar</label>
                        <div class="flex items-center gap-4">
                            <template x-for="k in ['a','b','c','d']">
                                <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-xl hover:bg-slate-50 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-700 font-bold transition-all">
                                    <input type="radio" name="answerKey" :value="k" x-model="activeItem.answerKey" required class="w-4 h-4 text-indigo-600"> <span class="uppercase" x-text="k"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="showEditModal = false; activeItem = null" class="px-5 py-2.5 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 transition-colors">Simpan Perubahan</button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection

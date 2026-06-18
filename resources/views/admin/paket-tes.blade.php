@extends('layouts.admin')

@section('title', 'Paket Tes - Admin Portal')
@section('header', 'Kelola Paket Tes')

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-6" x-data="{ 
    showAddModal: {{ $errors->any() ? 'true' : 'false' }},
    showEditModal: false,
    editPkg: null,
    openEdit(pkg) {
        this.editPkg = pkg;
        this.showEditModal = true;
    }
}">

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-semibold flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-semibold flex flex-col gap-1">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            Ada kesalahan saat menyimpan:
        </div>
        <ul class="list-disc ml-8 text-sm mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div>
            <h3 class="font-bold text-lg text-slate-800">Daftar Paket Tes</h3>
            <p class="text-sm text-slate-500 mt-1">Total: {{ $packages->count() }} paket simulasi tersedia.</p>
        </div>
        <button @click="showAddModal = true" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 transition-colors flex items-center gap-2 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Buat Paket Baru
        </button>
    </div>

    <!-- Table -->
    @if($packages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $pkg)
                @php 
                    $durations = is_array($pkg->durations) ? $pkg->durations : json_decode($pkg->durations, true);
                    $pkgQuestions = is_array($pkg->questions) ? $pkg->questions : json_decode($pkg->questions, true);
                    $totalQuestions = is_array($pkgQuestions) ? count($pkgQuestions) : 0;
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 uppercase tracking-wider">
                            {{ $pkg->type }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 uppercase tracking-wider">
                            {{ $pkg->status }}
                        </span>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 mb-2 leading-tight">{{ $pkg->name }}</h4>
                    
                    <div class="flex-1 mt-2 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 font-semibold">Total Soal</span>
                            <span class="text-slate-800 font-bold">{{ $totalQuestions }} Soal</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 font-semibold">Listening</span>
                            <span class="text-slate-800 font-bold">{{ ($durations['Listening'] ?? 0) / 60 }} menit</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 font-semibold">Structure</span>
                            <span class="text-slate-800 font-bold">{{ ($durations['Structure'] ?? 0) / 60 }} menit</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500 font-semibold">Reading</span>
                            <span class="text-slate-800 font-bold">{{ ($durations['Reading'] ?? 0) / 60 }} menit</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        @php
                            $editData = [
                                "id" => $pkg->id,
                                "name" => $pkg->name,
                                "type" => $pkg->type,
                                "durations" => is_string($pkg->durations) ? json_decode($pkg->durations, true) : $pkg->durations,
                                "questions" => is_string($pkg->questions) ? json_decode($pkg->questions, true) : $pkg->questions,
                                "instruction_listening" => $pkg->instruction_listening,
                                "instruction_structure" => $pkg->instruction_structure,
                                "instruction_reading" => $pkg->instruction_reading,
                            ];
                        @endphp
                        <button @click='openEdit(@json($editData))' class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Edit Paket</button>
                        <form action="{{ route('admin.paket-tes.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 flex flex-col items-center justify-center text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-700">Belum Ada Paket Tes</h4>
            <p class="text-slate-500 mt-2 max-w-md">Data paket tes belum dapat ditampilkan. Silakan gunakan tombol "Buat Paket Baru".</p>
        </div>
    @endif

    <!-- Add Modal -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="showAddModal = false" class="bg-white rounded-3xl w-full max-w-4xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-black text-lg text-slate-800">Buat Paket Tes Baru</h3>
                <button @click="showAddModal = false" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.paket-tes.store') }}" method="POST" class="flex-1 overflow-y-auto flex flex-col md:flex-row" x-data="{ 
                testType: 'Full Test', 
                miniSection: 'Listening', 
                dList: 35, dStruct: 25, dRead: 60,
                selectedQuestions: [],
                allQ: @js($questions),
                get filteredQ() {
                    if(this.testType === 'Full Test') return this.allQ;
                    return this.allQ.filter(q => q.section === this.miniSection);
                }
            }" @change="if(testType === 'Full Test') { dList = 35; dStruct = 25; dRead = 60; } else { if(miniSection === 'Listening') { dStruct = 0; dRead = 0; if(dList === 0) dList = 20; } else if(miniSection === 'Structure') { dList = 0; dRead = 0; if(dStruct === 0) dStruct = 20; } else if(miniSection === 'Reading') { dList = 0; dStruct = 0; if(dRead === 0) dRead = 20; } }">
                @csrf
                
                <!-- Left Sidebar (Details) -->
                <div class="w-full md:w-1/3 bg-slate-50 p-6 border-r border-slate-100 space-y-5 flex-shrink-0">
                    
                    <!-- Hidden inputs for form submission -->
                    <template x-for="sqId in selectedQuestions">
                        <input type="hidden" name="question_ids[]" :value="sqId">
                    </template>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Paket</label>
                        <input type="text" name="name" required placeholder="Contoh: Try Out Akbar 1" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Ujian</label>
                        <select name="type" x-model="testType" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                            <option value="Full Test">Full Test</option>
                            <option value="Mini Test">Mini Test</option>
                        </select>
                    </div>

                    <div x-show="testType === 'Mini Test'">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Section</label>
                        <select x-model="miniSection" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                            <option value="Listening">Listening Comprehension</option>
                            <option value="Structure">Structure & Written Expression</option>
                            <option value="Reading">Reading Comprehension</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-200">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Durasi (Menit)</p>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between" x-show="testType === 'Full Test' || miniSection === 'Listening'">
                                <label class="text-sm font-semibold text-slate-600">Listening</label>
                                <input type="number" name="duration_listening" x-model="dList" :readonly="testType === 'Full Test'" :class="testType === 'Full Test' ? 'bg-slate-100 text-slate-500 border-slate-200 cursor-not-allowed' : 'bg-white border-slate-300 focus:border-indigo-600'" class="w-20 px-3 py-1 text-center rounded border outline-none transition-all">
                            </div>
                            <div class="flex items-center justify-between" x-show="testType === 'Full Test' || miniSection === 'Structure'">
                                <label class="text-sm font-semibold text-slate-600">Structure</label>
                                <input type="number" name="duration_structure" x-model="dStruct" :readonly="testType === 'Full Test'" :class="testType === 'Full Test' ? 'bg-slate-100 text-slate-500 border-slate-200 cursor-not-allowed' : 'bg-white border-slate-300 focus:border-indigo-600'" class="w-20 px-3 py-1 text-center rounded border outline-none transition-all">
                            </div>
                            <div class="flex items-center justify-between" x-show="testType === 'Full Test' || miniSection === 'Reading'">
                                <label class="text-sm font-semibold text-slate-600">Reading</label>
                                <input type="number" name="duration_reading" x-model="dRead" :readonly="testType === 'Full Test'" :class="testType === 'Full Test' ? 'bg-slate-100 text-slate-500 border-slate-200 cursor-not-allowed' : 'bg-white border-slate-300 focus:border-indigo-600'" class="w-20 px-3 py-1 text-center rounded border outline-none transition-all">
                            </div>
                        </div>
                        <p x-show="testType === 'Full Test'" class="text-[10px] text-blue-600 mt-3 font-bold bg-blue-50 p-2 rounded border border-blue-100">Total durasi dikunci pada 2 Jam (120 Menit) untuk Full Test.</p>
                        <p x-show="testType === 'Mini Test'" class="text-[10px] text-orange-600 mt-3 font-bold bg-orange-50 p-2 rounded border border-orange-100">Silakan sesuaikan durasi untuk section <span x-text="miniSection"></span>.</p>
                    </div>

                    <div class="pt-4 border-t border-slate-200 space-y-4">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Instruksi Spesifik Paket (Opsional)</p>
                        <div x-show="testType === 'Full Test' || miniSection === 'Listening'">
                            <label class="block text-xs font-bold text-slate-600 mb-1">Instruksi Listening</label>
                            <textarea name="instruction_listening" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all text-sm" placeholder="Kosongkan untuk instruksi bawaan sistem..."></textarea>
                        </div>
                        <div x-show="testType === 'Full Test' || miniSection === 'Structure'">
                            <label class="block text-xs font-bold text-slate-600 mb-1">Instruksi Structure</label>
                            <textarea name="instruction_structure" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all text-sm" placeholder="Kosongkan untuk instruksi bawaan sistem..."></textarea>
                        </div>
                        <div x-show="testType === 'Full Test' || miniSection === 'Reading'">
                            <label class="block text-xs font-bold text-slate-600 mb-1">Instruksi Reading</label>
                            <textarea name="instruction_reading" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all text-sm" placeholder="Kosongkan untuk instruksi bawaan sistem..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Main Content (Question Builder) -->
                <div class="flex-1 p-6 flex flex-col min-h-0 relative">
                    <h4 class="text-sm font-bold text-slate-800 mb-4">Pilih Soal dari Bank Soal</h4>
                    
                    <div class="flex-1 overflow-y-auto border border-slate-200 rounded-xl bg-white p-2">
                        <template x-if="filteredQ.length > 0">
                            <div class="space-y-2">
                                <template x-for="q in filteredQ" :key="q.id">
                                    <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-colors cursor-pointer group">
                                        <input type="checkbox" x-model="selectedQuestions" :value="q.id" class="mt-1 w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-600">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider" 
                                                    :class="q.section === 'Listening' ? 'bg-blue-100 text-blue-700' : (q.section === 'Structure' ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700')"
                                                    x-text="q.section">
                                                </span>
                                                <template x-if="q.audio">
                                                    <span class="text-[10px] text-blue-500 font-bold bg-blue-50 px-1 rounded">Audio</span>
                                                </template>
                                                <template x-if="q.passage">
                                                    <span class="text-[10px] text-emerald-500 font-bold bg-emerald-50 px-1 rounded">Reading</span>
                                                </template>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-700 leading-snug line-clamp-2" x-text="q.content.replace(/(<([^>]+)>)/gi, '')"></p>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </template>
                        <template x-if="filteredQ.length === 0">
                            <div class="p-8 text-center">
                                <p class="text-sm text-slate-500 font-semibold mb-2">Tidak ada soal ditemukan</p>
                                <p class="text-xs text-slate-400" x-text="'Belum ada soal untuk kategori ' + (testType === 'Full Test' ? 'Bank Soal' : miniSection) + '.'"></p>
                            </div>
                        </template>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="showAddModal = false" class="px-5 py-2.5 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 transition-colors">Buat Paket</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="showEditModal = false" class="bg-white rounded-3xl w-full max-w-4xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h3 class="font-black text-lg text-slate-800">Edit Paket Tes</h3>
                <button @click="showEditModal = false" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <template x-if="editPkg">
                <form :action="'{{ url('/admin/dashboard/paket-tes') }}/' + editPkg.id" method="POST" class="flex-1 overflow-y-auto flex flex-col md:flex-row" x-data="{ 
                    testType: 'Full Test', 
                    miniSection: 'Listening', 
                    dList: 0, 
                    dStruct: 0, 
                    dRead: 0,
                    selectedQuestions: [],
                    allQ: @js($questions),
                    get filteredQ() {
                        if(this.testType === 'Full Test') return this.allQ;
                        return this.allQ.filter(q => q.section === this.miniSection);
                    },
                    init() {
                        this.syncData();
                        this.$watch('editPkg', () => {
                            this.syncData();
                        });
                    },
                    syncData() {
                        if (editPkg) {
                            this.testType = editPkg.type;
                            this.dList = ((editPkg.durations || {}).Listening || 0) / 60;
                            this.dStruct = ((editPkg.durations || {}).Structure || 0) / 60;
                            this.dRead = ((editPkg.durations || {}).Reading || 0) / 60;
                            this.selectedQuestions = (editPkg.questions || []).map(q => q.id);
                        }
                    }
                }" @change="if(testType === 'Full Test') { dList = 35; dStruct = 25; dRead = 60; } else { if(miniSection === 'Listening') { dStruct = 0; dRead = 0; if(dList === 0) dList = 20; } else if(miniSection === 'Structure') { dList = 0; dRead = 0; if(dStruct === 0) dStruct = 20; } else if(miniSection === 'Reading') { dList = 0; dStruct = 0; if(dRead === 0) dRead = 20; } }">
                    @csrf
                    @method('PUT')
                    
                    <!-- Left Sidebar (Details) -->
                    <div class="w-full md:w-1/3 bg-slate-50 p-6 border-r border-slate-100 space-y-5 flex-shrink-0">
                        
                        <!-- Hidden inputs for form submission -->
                        <template x-for="sqId in selectedQuestions">
                            <input type="hidden" name="question_ids[]" :value="sqId">
                        </template>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Paket</label>
                            <input type="text" name="name" :value="editPkg.name" required placeholder="Contoh: Try Out Akbar 1" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Ujian</label>
                            <select name="type" x-model="testType" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all">
                                <option value="Full Test">Full Test</option>
                                <option value="Mini Test">Mini Test</option>
                            </select>
                        </div>

                        <!-- Durations -->
                        <div class="pt-4 border-t border-slate-200">
                            <p class="text-xs font-bold text-slate-400 mb-3 uppercase tracking-widest">Durasi (Menit)</p>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between" x-show="testType === 'Full Test' || miniSection === 'Listening'">
                                    <label class="text-sm font-semibold text-slate-600">Listening</label>
                                    <input type="number" name="duration_listening" x-model="dList" :readonly="testType === 'Full Test'" :class="testType === 'Full Test' ? 'bg-slate-100 text-slate-500 border-slate-200 cursor-not-allowed' : 'bg-white border-slate-300 focus:border-indigo-600'" class="w-20 px-3 py-1 text-center rounded border outline-none transition-all">
                                </div>
                                <div class="flex items-center justify-between" x-show="testType === 'Full Test' || miniSection === 'Structure'">
                                    <label class="text-sm font-semibold text-slate-600">Structure</label>
                                    <input type="number" name="duration_structure" x-model="dStruct" :readonly="testType === 'Full Test'" :class="testType === 'Full Test' ? 'bg-slate-100 text-slate-500 border-slate-200 cursor-not-allowed' : 'bg-white border-slate-300 focus:border-indigo-600'" class="w-20 px-3 py-1 text-center rounded border outline-none transition-all">
                                </div>
                                <div class="flex items-center justify-between" x-show="testType === 'Full Test' || miniSection === 'Reading'">
                                    <label class="text-sm font-semibold text-slate-600">Reading</label>
                                    <input type="number" name="duration_reading" x-model="dRead" :readonly="testType === 'Full Test'" :class="testType === 'Full Test' ? 'bg-slate-100 text-slate-500 border-slate-200 cursor-not-allowed' : 'bg-white border-slate-300 focus:border-indigo-600'" class="w-20 px-3 py-1 text-center rounded border outline-none transition-all">
                                </div>
                            </div>
                            <p x-show="testType === 'Full Test'" class="text-[10px] text-blue-600 mt-3 font-bold bg-blue-50 p-2 rounded border border-blue-100">Total durasi dikunci pada 2 Jam (120 Menit) untuk Full Test.</p>
                        </div>

                        <!-- Mini Test Section Selector -->
                        <div x-show="testType === 'Mini Test'" class="pt-4 border-t border-slate-200">
                            <label class="block text-xs font-bold text-slate-600 mb-2">Pilih Bagian Soal</label>
                            <div class="flex items-center gap-2">
                                <template x-for="sec in ['Listening', 'Structure', 'Reading']" :key="sec">
                                    <button type="button" @click="miniSection = sec" :class="miniSection === sec ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 border border-slate-300 hover:bg-slate-50'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all" x-text="sec"></button>
                                </template>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200 space-y-4">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Instruksi Spesifik Paket (Opsional)</p>
                            <div x-show="testType === 'Full Test' || miniSection === 'Listening'">
                                <label class="block text-xs font-bold text-slate-600 mb-1">Instruksi Listening</label>
                                <textarea name="instruction_listening" :value="editPkg.instruction_listening" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all text-sm" placeholder="Kosongkan untuk instruksi bawaan sistem..."></textarea>
                            </div>
                            <div x-show="testType === 'Full Test' || miniSection === 'Structure'">
                                <label class="block text-xs font-bold text-slate-600 mb-1">Instruksi Structure</label>
                                <textarea name="instruction_structure" :value="editPkg.instruction_structure" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all text-sm" placeholder="Kosongkan untuk instruksi bawaan sistem..."></textarea>
                            </div>
                            <div x-show="testType === 'Full Test' || miniSection === 'Reading'">
                                <label class="block text-xs font-bold text-slate-600 mb-1">Instruksi Reading</label>
                                <textarea name="instruction_reading" :value="editPkg.instruction_reading" rows="2" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 outline-none transition-all text-sm" placeholder="Kosongkan untuk instruksi bawaan sistem..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Main Content (Question Builder) -->
                    <div class="flex-1 p-6 flex flex-col min-h-0 relative">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-bold text-slate-800">Pilih Soal dari Bank Soal</h4>
                            <span class="text-xs font-bold bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full"><span x-text="selectedQuestions.length"></span> Terpilih</span>
                        </div>
                        
                        <div class="flex-1 overflow-y-auto border border-slate-200 rounded-xl bg-white p-2">
                            <template x-if="filteredQ.length > 0">
                                <div class="space-y-2">
                                    <template x-for="q in filteredQ" :key="q.id">
                                        <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-colors cursor-pointer group">
                                            <input type="checkbox" :value="q.id" :checked="selectedQuestions.includes(q.id)" @change="$event.target.checked ? selectedQuestions.push(q.id) : selectedQuestions = selectedQuestions.filter(id => id !== q.id)" class="mt-1 w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-600">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider" 
                                                        :class="q.section === 'Listening' ? 'bg-blue-100 text-blue-700' : (q.section === 'Structure' ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700')"
                                                        x-text="q.section">
                                                    </span>
                                                    <template x-if="q.audio">
                                                        <span class="text-[10px] text-blue-500 font-bold bg-blue-50 px-1 rounded">Audio</span>
                                                    </template>
                                                    <template x-if="q.passage">
                                                        <span class="text-[10px] text-emerald-500 font-bold bg-emerald-50 px-1 rounded">Reading</span>
                                                    </template>
                                                </div>
                                                <p class="text-sm font-semibold text-slate-700 leading-snug line-clamp-2" x-text="q.content.replace(/(<([^>]+)>)/gi, '')"></p>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </template>
                            <template x-if="filteredQ.length === 0">
                                <div class="p-8 text-center">
                                    <p class="text-sm text-slate-500 font-semibold mb-2">Tidak ada soal ditemukan</p>
                                    <p class="text-xs text-slate-400" x-text="'Belum ada soal untuk kategori ' + (testType === 'Full Test' ? 'Bank Soal' : miniSection) + '.'"></p>
                                </div>
                            </template>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end gap-3">
                            <button type="button" @click="showEditModal = false" class="px-5 py-2.5 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 transition-colors">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>
@endsection

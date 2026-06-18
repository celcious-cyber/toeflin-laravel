@extends('layouts.admin')

@section('title', 'Data Mahasiswa - Admin Portal')
@section('header', 'Kelola Data Mahasiswa')

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-6" x-data="{
    students: @js($students),
    activeStudent: null,
    showHistoryModal: false,
    formatDate(dateStr) {
        if (!dateStr) return '-';
        return new Date(dateStr).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit' });
    }
}">

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
            <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500">Total Mahasiswa</p>
                <h3 class="text-2xl font-black text-slate-800" x-text="students.length"></h3>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Biodata & Kontak</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Fakultas / Prodi</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Total Ujian</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="s in students" :key="s.id">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6">
                                <p class="text-sm font-bold text-slate-800" x-text="s.name"></p>
                                <p class="text-xs text-slate-500" x-text="'NIM: ' + (s.nim || '-')"></p>
                                <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span x-text="s.email"></span>
                                </p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-bold text-slate-700" x-text="s.fakultas || '-'"></p>
                                <p class="text-xs text-slate-500" x-text="s.prodi || '-'"></p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold" x-text="(s.attempts?.length || 0) + ' Kali Ujian'"></span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button type="button" @click="activeStudent = s; showHistoryModal = true" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
                                    Lihat Riwayat
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="students.length === 0">
                        <td colspan="4" class="py-8 text-center text-slate-500 font-medium">Belum ada data mahasiswa.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- History Modal -->
    <div x-show="showHistoryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div @click.away="showHistoryModal = false" class="bg-white rounded-3xl w-full max-w-4xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div>
                    <h3 class="text-xl font-black text-slate-800 font-[Outfit]">Riwayat Ujian Mahasiswa</h3>
                    <p class="text-sm text-slate-500 mt-1" x-text="activeStudent?.name + ' (' + (activeStudent?.nim || '-') + ')'"></p>
                </div>
                <button @click="showHistoryModal = false" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-8 overflow-y-auto bg-slate-50 flex-1">
                <template x-if="activeStudent && (!activeStudent.attempts || activeStudent.attempts.length === 0)">
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium">Mahasiswa ini belum pernah mengikuti ujian.</p>
                    </div>
                </template>

                <div class="space-y-4">
                    <template x-for="attempt in (activeStudent?.attempts || [])" :key="attempt.id">
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-slate-800 text-lg" x-text="attempt.package?.name || 'Paket Dihapus'"></h4>
                                <p class="text-sm text-slate-500 mt-1" x-text="formatDate(attempt.createdAt)"></p>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="text-center">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status</p>
                                    <span :class="attempt.status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'" 
                                          class="px-3 py-1 rounded-full text-xs font-bold capitalize" 
                                          x-text="attempt.status"></span>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Skor</p>
                                    <p class="text-2xl font-black text-indigo-600" x-text="attempt.score || '-'"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="px-8 py-5 border-t border-slate-100 bg-white flex justify-end">
                <button @click="showHistoryModal = false" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

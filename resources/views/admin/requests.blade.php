@extends('layouts.admin')

@section('title', 'Permohonan Ujian - Admin Portal')
@section('header', 'Permohonan Ujian')

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-6">

    <div class="flex items-center justify-between bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div>
            <h3 class="font-bold text-lg text-slate-800">Daftar Permohonan</h3>
            <p class="text-sm text-slate-500 mt-1">Tinjau permohonan mahasiswa untuk menambah kuota ujian mingguan.</p>
        </div>
    </div>

    @if($testRequests->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider">Mahasiswa</th>
                        <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider">Paket Tes</th>
                        <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 font-bold text-slate-500 text-xs uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($testRequests as $req)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-4 px-6 text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($req->createdAt)->format('d M Y, H:i') }}
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-slate-800">{{ $req->user->name ?? 'User Tidak Diketahui' }}</p>
                            <p class="text-xs text-slate-500">{{ $req->user->email ?? '' }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                {{ $req->package->name ?? 'Paket Tidak Tersedia' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($req->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Menunggu
                                </span>
                            @elseif($req->status === 'approved' || $req->status === 'used')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Disetujui / Terpakai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($req->status === 'pending')
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('admin.requests.update', $req->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors border border-green-200 shadow-sm" title="Setujui">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.requests.update', $req->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-red-200 shadow-sm" title="Tolak">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Telah Diproses</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 flex flex-col items-center justify-center text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-700">Belum Ada Permohonan</h4>
            <p class="text-slate-500 mt-2 max-w-md">Saat ini tidak ada mahasiswa yang mengajukan permohonan kuota ujian.</p>
        </div>
    @endif

</div>
@endsection

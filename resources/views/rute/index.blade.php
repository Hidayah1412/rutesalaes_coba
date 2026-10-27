<x-layout title="Rute Kunjungan Sales">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Agenda Rute Kunjungan</h1>
            <p class="text-sm text-slate-500 mt-1">Pemantauan rencana rute dan pelaporan hasil transaksi check-in toko.</p>
        </div>
        <a href="{{ route('rute.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Jadwalkan Kunjungan Baru
        </a>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs mb-6">
        <form method="GET" action="{{ route('rute.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari toko, pemilik, atau alamat..." 
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div class="sm:col-span-3">
                <select name="user_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Sales</option>
                    @foreach($salesUsers as $sales)
                        <option value="{{ $sales->id }}" {{ request('user_id') == $sales->id ? 'selected' : '' }}>{{ $sales->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Direncanakan" {{ request('status') == 'Direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <input type="date" name="date" value="{{ request('date') }}" 
                       class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div class="sm:col-span-1">
                <button type="submit" class="w-full px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Visits Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5">ID &amp; Tanggal</th>
                        <th class="px-5 py-3.5">Toko / Warung</th>
                        <th class="px-5 py-3.5">Sales Ditugaskan</th>
                        <th class="px-5 py-3.5">Status Rute</th>
                        <th class="px-5 py-3.5">Hasil Kunjungan</th>
                        <th class="px-5 py-3.5">Nilai Transaksi</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($visits as $visit)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="font-mono text-xs font-bold text-slate-400">#{{ $visit->id }}</span>
                                <div class="font-semibold text-slate-800 text-xs mt-0.5">
                                    {{ \Carbon\Carbon::parse($visit->visit_date)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('rute.detail', $visit->id) }}" class="font-bold text-slate-900 hover:text-blue-600 block">
                                    {{ $visit->store->name ?? '-' }}
                                </a>
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">
                                    {{ $visit->store->address ?? '-' }} ({{ $visit->store->area ?? 'Area belum diatur' }})
                                </p>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="font-medium text-slate-700">{{ $visit->user->name ?? '-' }}</span>
                                <div class="text-[11px] text-slate-400">Kode: {{ $visit->user->employee_code ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <x-badge :status="$visit->status" />
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($visit->result_status)
                                    <x-badge :status="$visit->result_status" />
                                @else
                                    <span class="text-xs text-slate-400 italic">Menunggu Check-in</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($visit->result_status === 'Berhasil')
                                    <span class="font-bold text-emerald-600">Rp {{ number_format($visit->order_value, 0, ',', '.') }}</span>
                                @elseif($visit->fail_reason)
                                    <span class="text-xs text-slate-400 italic">Alasan dicatat</span>
                                @else
                                    <span class="text-xs text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap space-x-1.5">
                                <a href="{{ route('rute.detail', $visit->id) }}" class="inline-flex px-3 py-1 text-xs font-semibold {{ $visit->status === 'Direncanakan' ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-blue-50 hover:text-blue-600' }} rounded-lg transition-all">
                                    {{ $visit->status === 'Direncanakan' ? 'Check-in / Detail' : 'Detail Rute' }}
                                </a>
                                <a href="{{ route('rute.edit', $visit->id) }}" class="inline-flex px-2 py-1 text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-amber-50 hover:text-amber-700 rounded-lg transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('rute.destroy', $visit->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rute kunjungan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-2 py-1 text-xs font-semibold bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                Tidak ada jadwal rute kunjungan yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visits->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $visits->links() }}
            </div>
        @endif
    </div>
</x-layout>

<x-layout title="Dashboard Admin">
    <!-- Welcome Header & Quick Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Pemantauan Kunjungan</h1>
            <p class="text-sm text-slate-500 mt-1">
                Ringkasan metrik real-time efektivitas kunjungan sales lapangan dan nilai transaksi pesanan.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('rute.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Jadwalkan Rute
            </a>
            <a href="{{ route('stores.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-sm font-semibold shadow-xs transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
                Tambah Toko
            </a>
        </div>
    </div>

    <!-- Tiga Metrik Utama Persyaratan Proyek -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <!-- Metrik 1: Total Kunjungan Selesai -->
        <x-stat-card 
            title="Total Kunjungan Selesai" 
            value="{{ number_format($totalCompletedVisits) }} Kunjungan" 
            subtitle="Dari {{ $totalCompletedVisits + $totalPlannedVisits }} total agenda jadwal"
            color="indigo" 
            icon="check" 
        />

        <!-- Metrik 2: Persentase Keberhasilan Kunjungan -->
        <x-stat-card 
            title="Tingkat Keberhasilan" 
            value="{{ $successPercentage }}%" 
            subtitle="{{ $totalSuccessVisits }} kunjungan berstatus transaksi berhasil"
            color="emerald" 
            icon="percent" 
        />

        <!-- Metrik 3: Total Nilai Pesanan -->
        <x-stat-card 
            title="Total Nilai Pesanan" 
            value="Rp {{ number_format($totalOrderValue, 0, ',', '.') }}" 
            subtitle="Akumulasi omzet tercatat dari toko closing"
            color="blue" 
            icon="currency" 
        />
    </div>

    <!-- Ringkasan Status Kunjungan & Metrik Pendukung -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Berhasil</p>
                <p class="text-xl font-bold text-emerald-600 mt-0.5">{{ $totalSuccessVisits }}</p>
            </div>
            <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                ✓
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Toko Tutup</p>
                <p class="text-xl font-bold text-amber-600 mt-0.5">{{ $totalClosedVisits }}</p>
            </div>
            <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs">
                !
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Ditolak</p>
                <p class="text-xl font-bold text-rose-600 mt-0.5">{{ $totalRejectedVisits }}</p>
            </div>
            <div class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs">
                ✕
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 font-medium">Direncanakan</p>
                <p class="text-xl font-bold text-blue-600 mt-0.5">{{ $totalPlannedVisits }}</p>
            </div>
            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                ⏱
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Tabel Kunjungan Terkini -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Aktivitas Kunjungan Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pemantauan riwayat dan rute terkini sales lapangan</p>
                </div>
                <a href="{{ route('rute.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3.5">Toko / Warung</th>
                            <th class="px-5 py-3.5">Sales</th>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Status / Hasil</th>
                            <th class="px-5 py-3.5">Nilai Order</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentVisits as $visit)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="font-semibold text-slate-900">{{ $visit->store->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $visit->store->area ?? 'Area belum diatur' }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="text-slate-700 font-medium">{{ $visit->user->name ?? '-' }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-slate-500 text-xs">
                                    {{ \Carbon\Carbon::parse($visit->visit_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($visit->status === 'Selesai')
                                        <x-badge :status="$visit->result_status" />
                                    @else
                                        <x-badge status="Direncanakan" />
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 font-semibold text-slate-800">
                                    @if($visit->result_status === 'Berhasil')
                                        <span class="text-emerald-600">Rp {{ number_format($visit->order_value, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('rute.detail', $visit->id) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 rounded-lg transition-colors">
                                        Detail Rute
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                    Belum ada data kunjungan yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kolom Samping: Performa Sales & Ringkasan Entitas -->
        <div class="space-y-6">
            <!-- Ringkasan Master Data -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-900 text-base mb-4">Informasi Operasional</h3>
                <div class="space-y-3.5">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                🏬
                            </div>
                            <span class="text-sm font-medium text-slate-700">Total Toko Terdaftar</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900">{{ $totalStores }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-xs">
                                👥
                            </div>
                            <span class="text-sm font-medium text-slate-700">Sales Aktif</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900">{{ $activeSalesCount }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs">
                                📅
                            </div>
                            <span class="text-sm font-medium text-slate-700">Jadwal Hari Ini</span>
                        </div>
                        <span class="text-sm font-bold text-slate-900">{{ $todayVisitsCount }}</span>
                    </div>
                </div>
            </div>

            <!-- Performa Sales Ringkas -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-900 text-base">Performa Tim Sales</h3>
                    <a href="{{ route('sales.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">Kelola</a>
                </div>

                <div class="space-y-3">
                    @foreach($salesPerformance as $sales)
                        <div class="p-3 rounded-xl border border-slate-100 hover:border-slate-200 transition-colors">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="font-semibold text-slate-800 text-sm">{{ $sales->name }}</span>
                                <span class="text-xs font-bold text-emerald-600">Rp {{ number_format($sales->total_revenue ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-slate-400">
                                <span>{{ $sales->completed_visits }} Selesai ({{ $sales->success_visits }} Sukses)</span>
                                <span>{{ $sales->total_visits }} Total Rute</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>

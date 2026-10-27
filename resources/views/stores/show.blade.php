<x-layout title="Detail Toko: {{ $store->name }}">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                &larr; Kembali ke Daftar Toko
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">{{ $store->name }}</h1>
                <x-badge :status="$store->status === 'active' ? 'Aktif' : 'Non-Aktif'" />
            </div>
            <p class="text-sm text-slate-500 mt-1">Area Wilayah: {{ $store->area ?? 'Belum ditentukan' }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('rute.create') }}?store_id={{ $store->id }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Jadwalkan Kunjungan
            </a>
            <a href="{{ route('stores.edit', $store->id) }}" class="px-3.5 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-semibold shadow-xs transition-all">
                Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Store Information Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b border-slate-100 pb-3">
                    Profil Toko / Mitra
                </h3>

                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-xs text-slate-400 font-medium">Nama Pemilik</dt>
                        <dd class="text-slate-800 font-semibold mt-0.5">{{ $store->owner_name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-400 font-medium">Kontak / Telepon</dt>
                        <dd class="text-slate-800 font-semibold mt-0.5 flex items-center gap-2">
                            <span>{{ $store->phone ?? 'Tidak ada data kontak' }}</span>
                            @if($store->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->phone) }}" target="_blank" class="text-emerald-600 hover:underline text-xs">
                                    (Hubungi WA)
                                </a>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-400 font-medium">Alamat Lengkap</dt>
                        <dd class="text-slate-700 mt-0.5 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">
                            {{ $store->address }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-400 font-medium">Koordinat GPS (Simulasi Lokasi)</dt>
                        <dd class="text-slate-700 mt-1 flex items-center gap-2">
                            <span class="font-mono text-xs bg-slate-100 px-2.5 py-1 rounded-lg">
                                {{ $store->latitude ?? '-' }}, {{ $store->longitude ?? '-' }}
                            </span>
                            @if($store->latitude && $store->longitude)
                                <a href="https://www.google.com/maps?q={{ $store->latitude }},{{ $store->longitude }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">
                                    Buka Peta &rarr;
                                </a>
                            @endif
                        </dd>
                    </div>

                    @if($store->notes)
                        <div>
                            <dt class="text-xs text-slate-400 font-medium">Catatan Toko</dt>
                            <dd class="text-xs text-slate-600 mt-0.5 italic">"{{ $store->notes }}"</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Visit History for this Store -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Riwayat Kunjungan ke Toko Ini</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Total {{ $store->visits->count() }} catatan kunjungan sales</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3.5">Tanggal</th>
                                <th class="px-5 py-3.5">Sales</th>
                                <th class="px-5 py-3.5">Status / Hasil</th>
                                <th class="px-5 py-3.5">Nilai Order / Alasan</th>
                                <th class="px-5 py-3.5 text-right">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($store->visits as $visit)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-5 py-3.5 font-medium text-slate-800">
                                        {{ \Carbon\Carbon::parse($visit->visit_date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-700">
                                        {{ $visit->user->name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($visit->status === 'Selesai')
                                            <x-badge :status="$visit->result_status" />
                                        @else
                                            <x-badge status="Direncanakan" />
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($visit->result_status === 'Berhasil')
                                            <span class="font-bold text-emerald-600 text-xs">Rp {{ number_format($visit->order_value, 0, ',', '.') }}</span>
                                        @elseif($visit->fail_reason)
                                            <span class="text-xs text-slate-500 line-clamp-1 italic">{{ $visit->fail_reason }}</span>
                                        @else
                                            <span class="text-xs text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('rute.detail', $visit->id) }}" class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                                            Buka Rute &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-400">
                                        Belum ada riwayat kunjungan ke toko ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<x-layout title="Profil Pengguna: {{ $user->name }}">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('sales.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                &larr; Kembali ke Tim Sales
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
                <x-badge :status="$user->role" />
                <x-badge :status="$user->is_active ? 'Aktif' : 'Non-Aktif'" />
            </div>
            <p class="text-sm text-slate-500 mt-1">Kode Pegawai: {{ $user->employee_code ?? '-' }} | Email: {{ $user->email }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('quick.login', $user->id) }}" class="px-3.5 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl text-xs font-semibold shadow-xs transition-all">
                Masuk Sebagai Akun Ini
            </a>
            <a href="{{ route('sales.edit', $user->id) }}" class="px-3.5 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-semibold shadow-xs transition-all">
                Edit Profil
            </a>
        </div>
    </div>

    <!-- Assigned Visits List -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Riwayat &amp; Tugas Rute Kunjungan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar agenda rute yang ditugaskan kepada {{ $user->name }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Toko / Warung</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Hasil / Alasan</th>
                        <th class="px-5 py-3.5">Nilai Order</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($user->visits as $visit)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-3.5 font-medium text-slate-800">
                                {{ \Carbon\Carbon::parse($visit->visit_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-semibold text-slate-900">{{ $visit->store->name ?? '-' }}</span>
                                <div class="text-xs text-slate-400">{{ $visit->store->address ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <x-badge :status="$visit->status" />
                            </td>
                            <td class="px-5 py-3.5">
                                @if($visit->result_status)
                                    <x-badge :status="$visit->result_status" />
                                    @if($visit->fail_reason)
                                        <p class="text-xs text-slate-500 mt-1 italic">{{ $visit->fail_reason }}</p>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 font-semibold">
                                @if($visit->result_status === 'Berhasil')
                                    <span class="text-emerald-600">Rp {{ number_format($visit->order_value, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('rute.detail', $visit->id) }}" class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                                    Detail Rute &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                Belum ada riwayat tugas kunjungan untuk pengguna ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>

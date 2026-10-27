<x-layout title="Data Toko / Warung">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengelolaan Toko &amp; Warung</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar toko/warung mitra yang terdaftar dalam rute distribusi sales.</p>
        </div>
        <a href="{{ route('stores.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Toko Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs mb-6">
        <form method="GET" action="{{ route('stores.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko, pemilik, telepon, atau alamat..." 
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div class="sm:col-span-3">
                <select name="area" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Wilayah / Area</option>
                    @foreach($areas as $area)
                        <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <div class="sm:col-span-1 flex gap-1">
                <button type="submit" class="w-full px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Stores Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5">Nama Toko &amp; Area</th>
                        <th class="px-5 py-3.5">Pemilik</th>
                        <th class="px-5 py-3.5">No. Telepon</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Total Kunjungan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stores as $store)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-4">
                                <a href="{{ route('stores.show', $store->id) }}" class="font-bold text-slate-900 hover:text-blue-600 block">
                                    {{ $store->name }}
                                </a>
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $store->address }} ({{ $store->area ?? 'Area belum diatur' }})</p>
                            </td>
                            <td class="px-5 py-4 text-slate-700 font-medium">
                                {{ $store->owner_name }}
                            </td>
                            <td class="px-5 py-4 text-slate-500 text-xs">
                                {{ $store->phone ?? '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <x-badge :status="$store->status === 'active' ? 'Aktif' : 'Non-Aktif'" />
                            </td>
                            <td class="px-5 py-4 text-slate-600 font-semibold">
                                {{ $store->visits_count }} kali
                            </td>
                            <td class="px-5 py-4 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('stores.show', $store->id) }}" class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                                    Detail
                                </a>
                                <a href="{{ route('stores.edit', $store->id) }}" class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-amber-50 hover:text-amber-700 rounded-lg transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('stores.destroy', $store->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus toko {{ $store->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                Tidak ada data toko yang sesuai dengan pencarian atau filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stores->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $stores->links() }}
            </div>
        @endif
    </div>
</x-layout>

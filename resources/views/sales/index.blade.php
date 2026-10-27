<x-layout title="Tim Sales &amp; Pengguna">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Sales &amp; Admin</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola akun sales lapangan dan staf administrator sistem.</p>
        </div>
        <a href="{{ route('sales.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Tambah Pengguna Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs mb-6">
        <form method="GET" action="{{ route('sales.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, kode pegawai, atau telepon..." 
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div class="sm:col-span-3">
                <select name="role" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Peran (Role)</option>
                    <option value="sales" {{ request('role') == 'sales' ? 'selected' : '' }}>Sales Representative</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>

            <div class="sm:col-span-1">
                <button type="submit" class="w-full px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5">Nama &amp; Kode Pegawai</th>
                        <th class="px-5 py-3.5">Email &amp; No. HP</th>
                        <th class="px-5 py-3.5">Role</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Total Tugas Kunjungan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-4">
                                <a href="{{ route('sales.show', $user->id) }}" class="font-bold text-slate-900 hover:text-blue-600 block">
                                    {{ $user->name }}
                                </a>
                                <p class="text-xs text-slate-400 mt-0.5">Kode: {{ $user->employee_code ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-slate-800 text-xs">{{ $user->email }}</div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <x-badge :status="$user->role" />
                            </td>
                            <td class="px-5 py-4">
                                <x-badge :status="$user->is_active ? 'Aktif' : 'Non-Aktif'" />
                            </td>
                            <td class="px-5 py-4 text-slate-700 font-semibold">
                                {{ $user->visits_count }} rute
                            </td>
                            <td class="px-5 py-4 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('quick.login', $user->id) }}" title="Masuk sebagai akun ini" class="inline-flex px-2 py-1 text-xs font-semibold bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                                    Switch
                                </a>
                                <a href="{{ route('sales.show', $user->id) }}" class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                                    Detail
                                </a>
                                <a href="{{ route('sales.edit', $user->id) }}" class="inline-flex px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-amber-50 hover:text-amber-700 rounded-lg transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('sales.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?');">
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
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-layout>


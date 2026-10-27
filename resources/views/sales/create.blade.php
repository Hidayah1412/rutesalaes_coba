<x-layout title="Tambah Sales / Pengguna">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('sales.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                    &larr; Kembali ke Daftar Sales
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Akun Sales / Admin</h1>
                <p class="text-sm text-slate-500 mt-1">Daftarkan akun baru untuk tim sales lapangan atau admin sistem.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf

                <div class="space-y-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="Contoh: Budi Santoso"
                               class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        @error('name')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   placeholder="Contoh: sales@rutesales.com"
                                   class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @error('email')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" required
                                   placeholder="Minimal 6 karakter"
                                   class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @error('password')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Peran (Role) <span class="text-rose-500">*</span>
                            </label>
                            <select name="role" id="role" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                <option value="sales" {{ old('role') == 'sales' ? 'selected' : '' }}>Sales Representative</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            @error('role')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode Pegawai -->
                        <div>
                            <label for="employee_code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Kode Pegawai
                            </label>
                            <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code') }}"
                                   placeholder="Contoh: SLS-105"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @error('employee_code')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                No. Telepon
                            </label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Status Aktif -->
                    <div class="pt-2">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700">Akun Aktif (Dapat Diberikan Tugas Kunjungan)</span>
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('sales.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                            Simpan Pengguna
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>

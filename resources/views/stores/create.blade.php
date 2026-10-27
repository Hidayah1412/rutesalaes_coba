<x-layout title="Tambah Toko / Warung Baru">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                    &larr; Kembali ke Daftar Toko
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Toko / Warung Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Lengkapi informasi outlet atau toko pelanggan untuk kebutuhan rute sales.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <form action="{{ route('stores.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nama Toko -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Nama Toko / Warung <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   placeholder="Contoh: Toko Berkah Jaya"
                                   class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @error('name')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Pemilik -->
                        <div>
                            <label for="owner_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Nama Pemilik <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" required
                                   placeholder="Contoh: H. Mansur"
                                   class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('owner_name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @error('owner_name')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- No. Telepon -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                No. Telepon / WhatsApp
                            </label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @error('phone')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Wilayah / Area -->
                        <div>
                            <label for="area" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Wilayah / Cluster Area
                            </label>
                            <input type="text" name="area" id="area" value="{{ old('area') }}"
                                   placeholder="Contoh: Jakarta Selatan / Pasar Minggu"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            @error('area')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Alamat Lengkap Toko <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="address" id="address" rows="3" required
                                  placeholder="Nama jalan, nomor ruko/kios, RT/RW, kelurahan, dan patokan..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('address') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Koordinat Lokasi Toko (Simulasi GPS) -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-xs font-bold text-slate-800 mb-3 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Koordinat Toko (Simulasi Lokasi Peta)
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="latitude" class="block text-xs text-slate-500 mb-1">Latitude</label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude', '-6.2088000') }}"
                                       placeholder="-6.2088000"
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="longitude" class="block text-xs text-slate-500 mb-1">Longitude</label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude', '106.8456000') }}"
                                       placeholder="106.8456000"
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Status Toko -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Status Outlet <span class="text-rose-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status')
                                <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan Tambahan -->
                        <div>
                            <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Catatan Khusus
                            </label>
                            <input type="text" name="notes" id="notes" value="{{ old('notes') }}"
                                   placeholder="Contoh: Jam buka pk 08.00 - 21.00"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('stores.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                            Simpan Data Toko
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>


<x-layout title="Jadwalkan Rute Kunjungan">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('rute.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                    &larr; Kembali ke Agenda Rute
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Jadwalkan Kunjungan Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Tetapkan penugasan toko sasaran dan sales yang akan bertugas.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
            <form action="{{ route('rute.store') }}" method="POST">
                @csrf

                <div class="space-y-5">
                    <!-- Pilih Toko -->
                    <div>
                        <label for="store_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Toko / Warung Tujuan <span class="text-rose-500">*</span>
                        </label>
                        <select name="store_id" id="store_id" required
                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('store_id') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option value="">-- Pilih Toko Sasaran --</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ old('store_id', request('store_id')) == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }} - {{ $store->owner_name }} ({{ $store->area ?? 'Area belum diatur' }})
                                </option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Sales -->
                    <div>
                        <label for="user_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Sales Penanggung Jawab <span class="text-rose-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" required
                                class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('user_id') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <option value="">-- Pilih Sales Representative --</option>
                            @foreach($salesUsers as $sales)
                                <option value="{{ $sales->id }}" {{ old('user_id', auth()->id()) == $sales->id ? 'selected' : '' }}>
                                    {{ $sales->name }} ({{ $sales->employee_code ?? 'Kode -' }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Rencana Kunjungan -->
                    <div>
                        <label for="visit_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Tanggal Rencana Kunjungan <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('visit_date') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        @error('visit_date')
                            <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Agenda -->
                    <div>
                        <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Catatan atau Instruksi Kunjungan
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  placeholder="Contoh: Bawa brosur promo minyak goreng, cek persediaan mi instan..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('rute.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-all">
                            Simpan &amp; Jadwalkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>


<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Tampilkan daftar seluruh toko/warung dengan pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = Store::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($area = $request->input('area')) {
            $query->where('area', $area);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $stores = $query->withCount('visits')
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        $areas = Store::whereNotNull('area')->distinct()->pluck('area');

        return view('stores.index', compact('stores', 'areas'));
    }

    /**
     * Tampilkan formulir tambah toko baru.
     */
    public function create()
    {
        return view('stores.create');
    }

    /**
     * Simpan data toko baru ke database.
     */
    public function store(StoreRequest $request)
    {
        $store = Store::create($request->validated());

        return redirect()->route('stores.index')
            ->with('success', "Toko '{$store->name}' berhasil ditambahkan ke dalam sistem.");
    }

    /**
     * Tampilkan detail toko beserta riwayat kunjungan.
     */
    public function show($id)
    {
        $store = Store::with(['visits.user' => function ($q) {
            $q->orderBy('visit_date', 'desc');
        }])->findOrFail($id);

        return view('stores.show', compact('store'));
    }

    /**
     * Tampilkan formulir edit toko.
     */
    public function edit($id)
    {
        $store = Store::findOrFail($id);

        return view('stores.edit', compact('store'));
    }

    /**
     * Perbarui data toko di database.
     */
    public function update(StoreRequest $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($request->validated());

        return redirect()->route('stores.index')
            ->with('success', "Data toko '{$store->name}' berhasil diperbarui.");
    }

    /**
     * Hapus data toko dari database.
     */
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $name = $store->name;
        $store->delete();

        return redirect()->route('stores.index')
            ->with('success', "Toko '{$name}' beserta data relasinya berhasil dihapus.");
    }
}

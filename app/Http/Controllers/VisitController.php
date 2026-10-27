<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInVisitRequest;
use App\Http\Requests\ScheduleVisitRequest;
use App\Models\Store;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Tampilkan daftar rute kunjungan sales dengan berbagai filter.
     */
    public function index(Request $request)
    {
        $query = Visit::with(['user', 'store']);

        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($resultStatus = $request->input('result_status')) {
            $query->where('result_status', $resultStatus);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('visit_date', $date);
        }

        if ($search = $request->input('search')) {
            $query->whereHas('store', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        $visits = $query->orderBy('visit_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $salesUsers = User::where('role', 'sales')->where('is_active', true)->orderBy('name')->get();
        $todayDate = Carbon::today()->format('Y-m-d');

        return view('rute.index', compact('visits', 'salesUsers', 'todayDate'));
    }

    /**
     * Tampilkan formulir penjadwalan rute kunjungan baru.
     */
    public function create()
    {
        $salesUsers = User::where('role', 'sales')->where('is_active', true)->orderBy('name')->get();
        $stores = Store::where('status', 'active')->orderBy('name')->get();

        return view('rute.create', compact('salesUsers', 'stores'));
    }

    /**
     * Simpan jadwal rute baru ke database.
     */
    public function store(ScheduleVisitRequest $request)
    {
        $visit = Visit::create([
            'user_id' => $request->user_id,
            'store_id' => $request->store_id,
            'visit_date' => $request->visit_date,
            'status' => 'Direncanakan',
            'notes' => $request->notes,
            'order_value' => 0.00,
        ]);

        return redirect()->route('rute.detail', $visit->id)
            ->with('success', "Rute kunjungan ke '{$visit->store->name}' berhasil dijadwalkan.");
    }

    /**
     * Halaman Dinamis: /rute/detail/{id}
     * Merender data toko yang harus dikunjungi berdasarkan parameter ID pada URI,
     * informasi jadwal kunjungan, serta formulir check-in transaksi.
     */
    public function detail($id)
    {
        $visit = Visit::with(['user', 'store'])->findOrFail($id);

        // Ambil riwayat kunjungan sebelumnya pada toko ini (selain kunjungan saat ini)
        $previousVisits = Visit::with('user')
            ->where('store_id', $visit->store_id)
            ->where('id', '!=', $visit->id)
            ->orderBy('visit_date', 'desc')
            ->limit(5)
            ->get();

        return view('rute.detail', compact('visit', 'previousVisits'));
    }

    /**
     * Proses transaksi Formulir Check-In Kunjungan.
     * Mengubah status dari 'Direncanakan' menjadi 'Selesai (Berhasil/Tutup/Ditolak)'.
     */
    public function checkin(CheckInVisitRequest $request, $id)
    {
        $visit = Visit::with('store')->findOrFail($id);

        $resultStatus = $request->input('result_status');
        $orderValue = $resultStatus === 'Berhasil' ? (float) $request->input('order_value', 0) : 0.00;
        $failReason = $resultStatus !== 'Berhasil' ? $request->input('fail_reason') : null;

        // Update kunjungan
        $visit->update([
            'status' => 'Selesai',
            'result_status' => $resultStatus,
            'check_in_time' => $request->input('check_in_time'),
            'order_value' => $orderValue,
            'fail_reason' => $failReason,
            'notes' => $request->input('notes'),
            'simulated_latitude' => $request->input('simulated_latitude'),
            'simulated_longitude' => $request->input('simulated_longitude'),
        ]);

        $message = "Check-in kunjungan ke '{$visit->store->name}' berhasil dicatat dengan status {$resultStatus}.";
        if ($resultStatus === 'Berhasil') {
            $message .= ' Nilai pesanan: Rp ' . number_format($orderValue, 0, ',', '.');
        }

        return redirect()->route('rute.detail', $visit->id)->with('success', $message);
    }

    /**
     * Tampilkan formulir edit rute kunjungan.
     */
    public function edit($id)
    {
        $visit = Visit::with(['user', 'store'])->findOrFail($id);
        $salesUsers = User::where('role', 'sales')->where('is_active', true)->orderBy('name')->get();
        $stores = Store::orderBy('name')->get();

        return view('rute.edit', compact('visit', 'salesUsers', 'stores'));
    }

    /**
     * Perbarui jadwal rute kunjungan.
     */
    public function update(ScheduleVisitRequest $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->update([
            'user_id' => $request->user_id,
            'store_id' => $request->store_id,
            'visit_date' => $request->visit_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('rute.detail', $visit->id)
            ->with('success', 'Jadwal rute kunjungan berhasil diperbarui.');
    }

    /**
     * Hapus jadwal rute kunjungan.
     */
    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $storeName = $visit->store->name ?? 'Toko';
        $visit->delete();

        return redirect()->route('rute.index')
            ->with('success', "Rute kunjungan ke '{$storeName}' berhasil dihapus.");
    }
}

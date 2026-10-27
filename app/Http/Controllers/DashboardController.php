<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman Dashboard Admin dengan metrik ringkasan.
     */
    public function index(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');

        // Metrik Wajib 1: Total Kunjungan Selesai
        $totalCompletedVisits = Visit::where('status', 'Selesai')->count();

        // Hitung Kunjungan Berhasil, Tutup, Ditolak
        $totalSuccessVisits = Visit::where('status', 'Selesai')->where('result_status', 'Berhasil')->count();
        $totalClosedVisits = Visit::where('status', 'Selesai')->where('result_status', 'Tutup')->count();
        $totalRejectedVisits = Visit::where('status', 'Selesai')->where('result_status', 'Ditolak')->count();

        // Metrik Wajib 2: Persentase Keberhasilan Kunjungan (%)
        $successPercentage = $totalCompletedVisits > 0
            ? round(($totalSuccessVisits / $totalCompletedVisits) * 100, 1)
            : 0;

        // Metrik Wajib 3: Total Nilai Pesanan (Rp)
        $totalOrderValue = Visit::where('result_status', 'Berhasil')->sum('order_value');

        // Metrik Tambahan Operasional
        $totalStores = Store::count();
        $activeSalesCount = User::where('role', 'sales')->where('is_active', true)->count();
        $totalPlannedVisits = Visit::where('status', 'Direncanakan')->count();
        $todayVisitsCount = Visit::whereDate('visit_date', $today)->count();

        // Daftar Kunjungan Terkini
        $recentVisits = Visit::with(['user', 'store'])
            ->orderBy('updated_at', 'desc')
            ->limit(8)
            ->get();

        // Ringkasan Performa Sales
        $salesPerformance = User::where('role', 'sales')
            ->withCount([
                'visits as total_visits',
                'visits as completed_visits' => function ($query) {
                    $query->where('status', 'Selesai');
                },
                'visits as success_visits' => function ($query) {
                    $query->where('result_status', 'Berhasil');
                },
            ])
            ->withSum(['visits as total_revenue' => function ($query) {
                $query->where('result_status', 'Berhasil');
            }], 'order_value')
            ->get();

        return view('dashboard.index', compact(
            'totalCompletedVisits',
            'successPercentage',
            'totalOrderValue',
            'totalSuccessVisits',
            'totalClosedVisits',
            'totalRejectedVisits',
            'totalStores',
            'activeSalesCount',
            'totalPlannedVisits',
            'todayVisitsCount',
            'recentVisits',
            'salesPerformance'
        ));
    }
}

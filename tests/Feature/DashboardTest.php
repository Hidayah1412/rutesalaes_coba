<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Skenario 1: Admin Dashboard menampilkan 3 metrik wajib secara akurat:
     * (1) Total Kunjungan Selesai
     * (2) Persentase Keberhasilan Kunjungan
     * (3) Total Nilai Pesanan
     */
    public function test_dashboard_displays_three_required_metrics_correctly(): void
    {
        $sales = User::factory()->sales()->create(['name' => 'Sales Budi']);
        $store1 = Store::factory()->create(['name' => 'Toko Berkah']);
        $store2 = Store::factory()->create(['name' => 'Warung Madura']);
        $store3 = Store::factory()->create(['name' => 'Grosir Maju']);
        $store4 = Store::factory()->create(['name' => 'Kios Lestari']);

        // 1 kunjungan Berhasil senilai Rp 2.500.000
        Visit::factory()->completedSuccess()->create([
            'user_id' => $sales->id,
            'store_id' => $store1->id,
            'order_value' => 2500000.00,
        ]);

        // 1 kunjungan Berhasil senilai Rp 1.500.000
        Visit::factory()->completedSuccess()->create([
            'user_id' => $sales->id,
            'store_id' => $store2->id,
            'order_value' => 1500000.00,
        ]);

        // 1 kunjungan Tutup (Rp 0)
        Visit::factory()->completedClosed()->create([
            'user_id' => $sales->id,
            'store_id' => $store3->id,
            'order_value' => 0.00,
        ]);

        // 1 kunjungan Ditolak (Rp 0)
        Visit::factory()->completedRejected()->create([
            'user_id' => $sales->id,
            'store_id' => $store4->id,
            'order_value' => 0.00,
        ]);

        // 1 kunjungan Direncanakan (belum selesai)
        Visit::factory()->create([
            'user_id' => $sales->id,
            'store_id' => $store1->id,
            'status' => 'Direncanakan',
        ]);

        // Total Selesai: 4
        // Total Berhasil: 2
        // Persentase Keberhasilan: (2 / 4) * 100% = 50%
        // Total Nilai Pesanan: 2.500.000 + 1.500.000 = 4.000.000

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Total Kunjungan Selesai');
        $response->assertSee('4 Kunjungan');
        $response->assertSee('Tingkat Keberhasilan');
        $response->assertSee('50%');
        $response->assertSee('Total Nilai Pesanan');
        $response->assertSee('4.000.000');
    }

    /**
     * Skenario 2: Admin Dashboard menampilkan daftar kunjungan terkini dan status operasional.
     */
    public function test_dashboard_displays_recent_visits_and_operational_stats(): void
    {
        $sales = User::factory()->sales()->create(['name' => 'Ahmad Fauzi']);
        $store = Store::factory()->create(['name' => 'Toko Sumber Rejeki']);

        Visit::factory()->completedSuccess()->create([
            'user_id' => $sales->id,
            'store_id' => $store->id,
            'order_value' => 1750000.00,
        ]);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Toko Sumber Rejeki');
        $response->assertSee('Ahmad Fauzi');
        $response->assertSee('Aktivitas Kunjungan Terbaru');
    }
}

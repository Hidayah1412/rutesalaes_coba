<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Skenario 7 (URI Dinamis): Halaman detail rute (/rute/detail/{id}) merender data toko yang harus dikunjungi.
     */
    public function test_dynamic_uri_route_detail_renders_store_data_successfully(): void
    {
        $sales = User::factory()->sales()->create(['name' => 'Budi Santoso']);
        $store = Store::factory()->create([
            'name' => 'Warung Madura Barokah 24 Jam',
            'owner_name' => 'Umar Faruq',
            'phone' => '085211223344',
            'address' => 'Jl. Radio Dalam No. 15, Kebayoran Baru',
            'area' => 'Jakarta Selatan',
            'latitude' => -6.2510000,
            'longitude' => 106.7900000,
        ]);

        $visit = Visit::factory()->create([
            'user_id' => $sales->id,
            'store_id' => $store->id,
            'visit_date' => now()->format('Y-m-d'),
            'status' => 'Direncanakan',
        ]);

        $response = $this->get('/rute/detail/' . $visit->id);

        $response->assertStatus(200);
        $response->assertSee('Warung Madura Barokah 24 Jam');
        $response->assertSee('Umar Faruq');
        $response->assertSee('085211223344');
        $response->assertSee('Jl. Radio Dalam No. 15, Kebayoran Baru');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Formulir Check-in Kunjungan');
    }

    /**
     * Skenario 8 (URI Dinamis Kasus Negatif): Akses /rute/detail/{id} dengan ID yang tidak ada mengembalikan 404 Not Found.
     */
    public function test_dynamic_uri_route_detail_returns_404_for_non_existent_id(): void
    {
        $response = $this->get('/rute/detail/99999');

        $response->assertStatus(404);
    }

    /**
     * Skenario 9: Penjadwalan rute kunjungan baru berhasil dibuat dengan status awal 'Direncanakan'.
     */
    public function test_visit_route_creation_succeeds_with_valid_data(): void
    {
        $sales = User::factory()->sales()->create();
        $store = Store::factory()->create();

        $payload = [
            'user_id' => $sales->id,
            'store_id' => $store->id,
            'visit_date' => now()->addDays(2)->format('Y-m-d'),
            'notes' => 'Kunjungan rutin pengantaran katalog promosi',
        ];

        $response = $this->post(route('rute.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('visits', [
            'user_id' => $sales->id,
            'store_id' => $store->id,
            'status' => 'Direncanakan',
            'order_value' => 0.00,
        ]);
    }

    /**
     * Skenario 10 (Alur Transaksi Sukses): Check-in kunjungan Berhasil mengubah status menjadi 'Selesai' dan mencatat nilai pesanan.
     */
    public function test_checkin_success_transaction_updates_status_to_selesai_and_records_order_value(): void
    {
        $sales = User::factory()->sales()->create();
        $store = Store::factory()->create(['name' => 'Toko Berkah']);

        $visit = Visit::factory()->create([
            'user_id' => $sales->id,
            'store_id' => $store->id,
            'status' => 'Direncanakan',
            'order_value' => 0.00,
        ]);

        $payload = [
            'result_status' => 'Berhasil',
            'check_in_time' => now()->format('Y-m-d H:i:s'),
            'order_value' => 2500000,
            'notes' => 'Pemilik memesan 20 karton minuman dan snack.',
            'simulated_latitude' => -6.2845000,
            'simulated_longitude' => 106.8421000,
        ];

        $response = $this->post(route('rute.checkin', $visit->id), $payload);

        $response->assertRedirect(route('rute.detail', $visit->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'status' => 'Selesai',
            'result_status' => 'Berhasil',
            'order_value' => 2500000.00,
            'notes' => 'Pemilik memesan 20 karton minuman dan snack.',
            'simulated_latitude' => -6.2845000,
        ]);
    }

    /**
     * Skenario 11 (Kasus Form Tidak Valid 1): Check-in Berhasil gagal jika nilai order kosong.
     */
    public function test_checkin_fails_validation_when_result_is_berhasil_but_order_value_is_missing(): void
    {
        $visit = Visit::factory()->create(['status' => 'Direncanakan']);

        $payload = [
            'result_status' => 'Berhasil',
            'check_in_time' => now()->format('Y-m-d H:i:s'),
            'order_value' => '', // kosong, padahal status Berhasil
        ];

        $response = $this->post(route('rute.checkin', $visit->id), $payload);

        $response->assertSessionHasErrors(['order_value']);

        // Status kunjungan tetap Direncanakan (tidak berubah jadi Selesai)
        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'status' => 'Direncanakan',
        ]);
    }

    /**
     * Skenario 12 (Kasus Form Tidak Valid 2): Check-in Berhasil gagal jika nilai pesanan bernilai negatif.
     */
    public function test_checkin_fails_validation_when_result_is_berhasil_but_order_value_is_negative(): void
    {
        $visit = Visit::factory()->create(['status' => 'Direncanakan']);

        $payload = [
            'result_status' => 'Berhasil',
            'check_in_time' => now()->format('Y-m-d H:i:s'),
            'order_value' => -50000, // negatif
        ];

        $response = $this->post(route('rute.checkin', $visit->id), $payload);

        $response->assertSessionHasErrors(['order_value']);
        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'status' => 'Direncanakan',
        ]);
    }

    /**
     * Skenario 13 (Kasus Form Tidak Valid 3): Check-in Tutup atau Ditolak gagal jika alasan (fail_reason) kosong.
     */
    public function test_checkin_fails_validation_when_result_is_tutup_or_ditolak_without_reason(): void
    {
        $visit = Visit::factory()->create(['status' => 'Direncanakan']);

        // Kasus status Tutup tanpa alasan
        $payloadTutup = [
            'result_status' => 'Tutup',
            'check_in_time' => now()->format('Y-m-d H:i:s'),
            'fail_reason' => '', // kosong
        ];

        $response = $this->post(route('rute.checkin', $visit->id), $payloadTutup);
        $response->assertSessionHasErrors(['fail_reason']);

        // Kasus status Ditolak tanpa alasan
        $payloadDitolak = [
            'result_status' => 'Ditolak',
            'check_in_time' => now()->format('Y-m-d H:i:s'),
            'fail_reason' => '', // kosong
        ];

        $response2 = $this->post(route('rute.checkin', $visit->id), $payloadDitolak);
        $response2->assertSessionHasErrors(['fail_reason']);

        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'status' => 'Direncanakan',
        ]);
    }

    /**
     * Skenario 14 (Alur Transaksi Tutup): Check-in toko Tutup berhasil mengubah status menjadi Selesai dengan alasan tersimpan.
     */
    public function test_checkin_closed_updates_status_to_selesai_with_reason(): void
    {
        $visit = Visit::factory()->create(['status' => 'Direncanakan']);

        $payload = [
            'result_status' => 'Tutup',
            'check_in_time' => now()->format('Y-m-d H:i:s'),
            'fail_reason' => 'Toko tutup karena pemilik sedang menghadiri acara keluarga di Solo.',
            'notes' => 'Akan dikunjungi kembali minggu depan.',
        ];

        $response = $this->post(route('rute.checkin', $visit->id), $payload);

        $response->assertRedirect(route('rute.detail', $visit->id));
        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'status' => 'Selesai',
            'result_status' => 'Tutup',
            'order_value' => 0.00,
            'fail_reason' => 'Toko tutup karena pemilik sedang menghadiri acara keluarga di Solo.',
        ]);
    }

    /**
     * Skenario 15 (Alur Transaksi Ditolak): Check-in toko Ditolak berhasil mengubah status menjadi Selesai dengan alasan tersimpan.
     */
    public function test_checkin_rejected_updates_status_to_selesai_with_reason(): void
    {
        $visit = Visit::factory()->create(['status' => 'Direncanakan']);

        $payload = [
            'result_status' => 'Ditolak',
            'check_in_time' => now()->format('Y-m-d H:i:s'),
            'fail_reason' => 'Stok produk di etalase toko masih sangat penuh dari pasokan sebelumnya.',
            'notes' => 'Sales meninggalkan katalog harga baru.',
        ];

        $response = $this->post(route('rute.checkin', $visit->id), $payload);

        $response->assertRedirect(route('rute.detail', $visit->id));
        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'status' => 'Selesai',
            'result_status' => 'Ditolak',
            'order_value' => 0.00,
            'fail_reason' => 'Stok produk di etalase toko masih sangat penuh dari pasokan sebelumnya.',
        ]);
    }
}


<?php

namespace Tests\Feature;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Skenario 3: Daftar toko/warung dapat ditampilkan dan dicari dengan benar.
     */
    public function test_store_index_lists_stores(): void
    {
        $store = Store::factory()->create([
            'name' => 'Toko Barokah Jaya',
            'owner_name' => 'Pak Haji Mansur',
            'area' => 'Jakarta Selatan',
        ]);

        $response = $this->get(route('stores.index'));

        $response->assertStatus(200);
        $response->assertSee('Toko Barokah Jaya');
        $response->assertSee('Pak Haji Mansur');
    }

    /**
     * Skenario 4: Penambahan toko baru berhasil dengan data input yang valid.
     */
    public function test_store_creation_succeeds_with_valid_data(): void
    {
        $payload = [
            'name' => 'Toko Subur Makmur',
            'owner_name' => 'Ibu Halimah',
            'phone' => '081299887766',
            'address' => 'Jl. Pasar Minggu Raya No. 10',
            'area' => 'Jakarta Selatan',
            'latitude' => -6.2845000,
            'longitude' => 106.8421000,
            'status' => 'active',
            'notes' => 'Toko grosir beras dan sembako',
        ];

        $response = $this->post(route('stores.store'), $payload);

        $response->assertRedirect(route('stores.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('stores', [
            'name' => 'Toko Subur Makmur',
            'owner_name' => 'Ibu Halimah',
            'phone' => '081299887766',
        ]);
    }

    /**
     * Skenario 5 (Kasus Input Tidak Valid): Penambahan toko gagal dan menampilkan pesan kesalahan jika field wajib kosong.
     */
    public function test_store_creation_fails_validation_with_missing_required_fields(): void
    {
        $payload = [
            'name' => '', // kosong
            'owner_name' => '', // kosong
            'address' => '', // kosong
            'status' => 'invalid_status', // status tidak valid
        ];

        $response = $this->post(route('stores.store'), $payload);

        $response->assertSessionHasErrors(['name', 'owner_name', 'address', 'status']);
        $this->assertDatabaseCount('stores', 0);
    }

    /**
     * Skenario 6: Data toko dapat diperbarui dan dihapus dari sistem.
     */
    public function test_store_update_and_delete(): void
    {
        $store = Store::factory()->create(['name' => 'Toko Lama']);

        // Update
        $updateResponse = $this->put(route('stores.update', $store->id), [
            'name' => 'Toko Baru Diperbarui',
            'owner_name' => $store->owner_name,
            'address' => $store->address,
            'status' => 'active',
        ]);

        $updateResponse->assertRedirect(route('stores.index'));
        $this->assertDatabaseHas('stores', ['id' => $store->id, 'name' => 'Toko Baru Diperbarui']);

        // Delete
        $deleteResponse = $this->delete(route('stores.destroy', $store->id));
        $deleteResponse->assertRedirect(route('stores.index'));
        $this->assertDatabaseMissing('stores', ['id' => $store->id]);
    }
}

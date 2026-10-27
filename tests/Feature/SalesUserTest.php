<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Skenario 16: Pengelolaan Sales (CRUD) - Pembuatan sales baru berhasil dengan data valid.
     */
    public function test_sales_user_creation_succeeds(): void
    {
        $payload = [
            'name' => 'Doni Darmawan',
            'email' => 'doni@rutesales.com',
            'password' => 'secret123',
            'role' => 'sales',
            'phone' => '081234567890',
            'employee_code' => 'SLS-505',
            'is_active' => '1',
        ];

        $response = $this->post(route('sales.store'), $payload);

        $response->assertRedirect(route('sales.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Doni Darmawan',
            'email' => 'doni@rutesales.com',
            'role' => 'sales',
            'employee_code' => 'SLS-505',
            'is_active' => true,
        ]);
    }

    /**
     * Skenario 17 (Kasus Form Tidak Valid): Pembuatan sales gagal jika format email duplikat atau password terlalu pendek.
     */
    public function test_sales_user_creation_fails_with_duplicate_email_and_short_password(): void
    {
        User::factory()->create(['email' => 'existing@rutesales.com']);

        $payload = [
            'name' => 'Sales Baru',
            'email' => 'existing@rutesales.com', // duplikat
            'password' => '123', // kurang dari 6 karakter
            'role' => 'sales',
        ];

        $response = $this->post(route('sales.store'), $payload);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /**
     * Skenario 18: Pengguna sales dapat diperbarui dan dihapus.
     */
    public function test_sales_user_can_be_updated_and_deleted(): void
    {
        $user = User::factory()->sales()->create([
            'name' => 'Bambang Sudirman',
            'email' => 'bambang@rutesales.com',
        ]);

        // Update
        $updateResponse = $this->put(route('sales.update', $user->id), [
            'name' => 'Bambang Sudirman SH',
            'email' => 'bambang@rutesales.com',
            'role' => 'sales',
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect(route('sales.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Bambang Sudirman SH']);

        // Delete
        $deleteResponse = $this->delete(route('sales.destroy', $user->id));
        $deleteResponse->assertRedirect(route('sales.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}


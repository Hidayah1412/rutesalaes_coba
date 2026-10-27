<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Skenario 19: Halaman login menampilkan antarmuka dan opsi akun demo pengujian.
     */
    public function test_login_page_renders_with_demo_accounts(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Masuk ke Sistem');
        $response->assertSee('admin@rutesales.com');
    }

    /**
     * Skenario 20: Fitur Quick-Login dan Logout memungkinkan pergantian akun sales/admin secara mulus.
     */
    public function test_quick_login_and_logout_flow(): void
    {
        $sales = User::factory()->sales()->create(['name' => 'Sales Budi']);

        // Quick login
        $loginResponse = $this->get(route('quick.login', $sales->id));
        $loginResponse->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($sales);

        // Logout
        $logoutResponse = $this->post(route('logout'));
        $logoutResponse->assertRedirect(route('login'));
        $this->assertGuest();
    }
}

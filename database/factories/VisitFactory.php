<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    protected $model = Visit::class;

    /**
     * Define the model's default state (Direncanakan).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'store_id' => Store::factory(),
            'visit_date' => fake()->dateTimeBetween('-7 days', '+7 days')->format('Y-m-d'),
            'status' => 'Direncanakan',
            'result_status' => null,
            'check_in_time' => null,
            'order_value' => 0.00,
            'fail_reason' => null,
            'notes' => fake()->optional()->sentence(),
            'simulated_latitude' => null,
            'simulated_longitude' => null,
        ];
    }

    /**
     * State untuk kunjungan Berhasil.
     */
    public function completedSuccess(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Selesai',
            'result_status' => 'Berhasil',
            'check_in_time' => now()->subHours(rand(1, 24)),
            'order_value' => fake()->numberBetween(150000, 5000000),
            'fail_reason' => null,
            'notes' => 'Pesanan berhasil dikonfirmasi oleh pemilik toko.',
            'simulated_latitude' => -6.2000000 + (rand(-50, 50) / 1000),
            'simulated_longitude' => 106.816666 + (rand(-50, 50) / 1000),
        ]);
    }

    /**
     * State untuk kunjungan Toko Tutup.
     */
    public function completedClosed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Selesai',
            'result_status' => 'Tutup',
            'check_in_time' => now()->subHours(rand(1, 24)),
            'order_value' => 0.00,
            'fail_reason' => fake()->randomElement([
                'Toko tutup, pemilik sedang berada di luar kota.',
                'Tutup sementara untuk renovasi kios.',
                'Rolling door terkunci rapat, tetangga mengatakan sedang ada acara keluarga.',
            ]),
            'notes' => 'Akan dijadwalkan ulang minggu depan.',
            'simulated_latitude' => -6.2000000 + (rand(-50, 50) / 1000),
            'simulated_longitude' => 106.816666 + (rand(-50, 50) / 1000),
        ]);
    }

    /**
     * State untuk kunjungan Ditolak.
     */
    public function completedRejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Selesai',
            'result_status' => 'Ditolak',
            'check_in_time' => now()->subHours(rand(1, 24)),
            'order_value' => 0.00,
            'fail_reason' => fake()->randomElement([
                'Stok produk di etalase masih penuh dan perputaran barang lambat.',
                'Sedang beralih fokus ke distributor lain dengan tempo pembayaran lebih lama.',
                'Pemilik menolak restock karena arus kas toko sedang ketat.',
            ]),
            'notes' => 'Sales meninggalkan brosur katalog promo baru.',
            'simulated_latitude' => -6.2000000 + (rand(-50, 50) / 1000),
            'simulated_longitude' => 106.816666 + (rand(-50, 50) / 1000),
        ]);
    }
}

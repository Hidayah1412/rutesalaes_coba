<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefixes = ['Toko Kelontong', 'Warung Madura', 'Minimarket', 'Grosir Sembako', 'Kios Berkah'];
        $storeName = fake()->randomElement($prefixes) . ' ' . fake()->firstName();

        return [
            'name' => $storeName,
            'owner_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'area' => fake()->randomElement(['Jakarta Selatan', 'Jakarta Timur', 'Jakarta Barat', 'Jakarta Pusat', 'Depok', 'Bekasi', 'Tangerang']),
            'latitude' => fake()->latitude(-6.35, -6.15),
            'longitude' => fake()->longitude(106.75, 106.95),
            'status' => 'active',
            'notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * State untuk toko non-aktif.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}

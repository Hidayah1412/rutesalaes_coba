<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@rutesales.com'],
            [
                'name' => 'Administrator Pusat',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081198765432',
                'employee_code' => 'ADM-001',
                'is_active' => true,
            ]
        );

        // 2. Akun Sales Representative
        $salesList = [
            [
                'name' => 'Budi Santoso',
                'email' => 'sales1@rutesales.com',
                'password' => Hash::make('password'),
                'role' => 'sales',
                'phone' => '081234567891',
                'employee_code' => 'SLS-101',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'sales2@rutesales.com',
                'password' => Hash::make('password'),
                'role' => 'sales',
                'phone' => '081234567892',
                'employee_code' => 'SLS-102',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'sales3@rutesales.com',
                'password' => Hash::make('password'),
                'role' => 'sales',
                'phone' => '081234567893',
                'employee_code' => 'SLS-103',
                'is_active' => true,
            ],
        ];

        $salesUsers = [];
        foreach ($salesList as $data) {
            $salesUsers[] = User::firstOrCreate(['email' => $data['email']], $data);
        }

        // 3. Data Toko / Warung
        $storeData = [
            [
                'name' => 'Toko Berkah Jaya',
                'owner_name' => 'Haji Mansur',
                'phone' => '081387654321',
                'address' => 'Jl. Raya Pasar Minggu No. 45, RT 02/RW 03, Pasar Minggu',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2841200,
                'longitude' => 106.8423100,
                'status' => 'active',
                'notes' => 'Toko kelontong langganan, biasanya order banyak di awal pekan.',
            ],
            [
                'name' => 'Warung Madura Barokah',
                'owner_name' => 'Umar Faruq',
                'phone' => '085298712345',
                'address' => 'Jl. Radio Dalam Raya No. 12, Gandaria Utara',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2512300,
                'longitude' => 106.7901200,
                'status' => 'active',
                'notes' => 'Buka 24 jam, pemesanan minuman dingin dan rokok tinggi.',
            ],
            [
                'name' => 'Grosir Sembako Maju Bersama',
                'owner_name' => 'Hj. Fatimah',
                'phone' => '081765432109',
                'address' => 'Jl. Tebet Barat Dalam Raya No. 88, Tebet',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2378900,
                'longitude' => 106.8524100,
                'status' => 'active',
                'notes' => 'Grosir besar, melayani pasokan warung-warung kecil sekitar.',
            ],
            [
                'name' => 'Toko Sumber Rejeki',
                'owner_name' => 'Koh Asep',
                'phone' => '081901234567',
                'address' => 'Jl. Fatmawati No. 102, Cilandak Barat',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2934500,
                'longitude' => 106.7987600,
                'status' => 'active',
                'notes' => 'Pembayaran selalu tepat waktu secara tunai atau transfer.',
            ],
            [
                'name' => 'Minimarket Sahabat Warga',
                'owner_name' => 'Dedi Setiadi',
                'phone' => '082112348765',
                'address' => 'Jl. Mampang Prapatan VIII No. 15, Mampang',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2489000,
                'longitude' => 106.8291000,
                'status' => 'active',
                'notes' => 'Memiliki rak showcase khusus minuman botol.',
            ],
            [
                'name' => 'Warung Pojok Bu Dewi',
                'owner_name' => 'Dewi Sartika',
                'phone' => '087812983476',
                'address' => 'Jl. Pancoran Barat III No. 7, Pancoran',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2412000,
                'longitude' => 106.8405000,
                'status' => 'active',
                'notes' => 'Lokasi strategis di dekat gang masuk perumahan padat.',
            ],
            [
                'name' => 'Kios Sembako Lestari',
                'owner_name' => 'Bambang Supriyadi',
                'phone' => '085732145698',
                'address' => 'Jl. Kemang Timur Raya No. 24, Bangka',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2654300,
                'longitude' => 106.8213400,
                'status' => 'active',
                'notes' => 'Rutin memesan minyak goreng, tepung, dan bumbu dapur.',
            ],
            [
                'name' => 'Toko Amanah Mandiri',
                'owner_name' => 'Lukman Hakim',
                'phone' => '081298456123',
                'address' => 'Jl. Moh. Kahfi 1 No. 50, Jagakarsa',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.3245600,
                'longitude' => 106.8123400,
                'status' => 'active',
                'notes' => 'Sering minta pengiriman sore hari setelah jam 15.00.',
            ],
            [
                'name' => 'Warung Makmur Sejati',
                'owner_name' => 'Rudy Hartono',
                'phone' => '081345678901',
                'address' => 'Jl. Kalibata Tengah No. 32, Pancoran',
                'area' => 'Jakarta Selatan',
                'latitude' => -6.2556700,
                'longitude' => 106.8490100,
                'status' => 'active',
                'notes' => 'Warung kelontong depan stasiun kereta.',
            ],
            [
                'name' => 'Toko Rejeki Melimpah',
                'owner_name' => 'Ibu Ratna',
                'phone' => '081876543218',
                'address' => 'Jl. Margonda Raya No. 210, Pondok Cina',
                'area' => 'Depok',
                'latitude' => -6.3689000,
                'longitude' => 106.8321000,
                'status' => 'active',
                'notes' => 'Dekat area kampus, permintaan mi instan & minuman kemasan tinggi.',
            ],
        ];

        $stores = [];
        foreach ($storeData as $store) {
            $stores[] = Store::firstOrCreate(['name' => $store['name']], $store);
        }

        // 4. Data Rute Kunjungan (Visits)
        // Kita buat data kunjungan bervariasi: Selesai Berhasil, Selesai Tutup, Selesai Ditolak, dan Direncanakan
        $today = Carbon::today();

        $visits = [
            // Selesai - Berhasil (Budi Santoso)
            [
                'user_id' => $salesUsers[0]->id,
                'store_id' => $stores[0]->id,
                'visit_date' => $today->copy()->subDays(2)->format('Y-m-d'),
                'status' => 'Selesai',
                'result_status' => 'Berhasil',
                'check_in_time' => $today->copy()->subDays(2)->setTime(9, 30, 0),
                'order_value' => 1850000.00,
                'fail_reason' => null,
                'notes' => 'Pesanan mi instan 15 karton dan minyak goreng 10 karton disetujui.',
                'simulated_latitude' => -6.2841250,
                'simulated_longitude' => 106.8423150,
            ],
            // Selesai - Berhasil (Siti Rahma)
            [
                'user_id' => $salesUsers[1]->id,
                'store_id' => $stores[1]->id,
                'visit_date' => $today->copy()->subDays(2)->format('Y-m-d'),
                'status' => 'Selesai',
                'result_status' => 'Berhasil',
                'check_in_time' => $today->copy()->subDays(2)->setTime(11, 15, 0),
                'order_value' => 950000.00,
                'fail_reason' => null,
                'notes' => 'Order minuman botol dingin 8 karton dan snack.',
                'simulated_latitude' => -6.2512310,
                'simulated_longitude' => 106.7901220,
            ],
            // Selesai - Tutup (Ahmad Fauzi)
            [
                'user_id' => $salesUsers[2]->id,
                'store_id' => $stores[2]->id,
                'visit_date' => $today->copy()->subDays(1)->format('Y-m-d'),
                'status' => 'Selesai',
                'result_status' => 'Tutup',
                'check_in_time' => $today->copy()->subDays(1)->setTime(10, 0, 0),
                'order_value' => 0.00,
                'fail_reason' => 'Toko tutup karena pemilik sedang menghadiri takziah keluarga di luar kota.',
                'notes' => 'Akan dikunjungi kembali lusa saat toko sudah buka kembali.',
                'simulated_latitude' => -6.2378950,
                'simulated_longitude' => 106.8524150,
            ],
            // Selesai - Berhasil (Budi Santoso)
            [
                'user_id' => $salesUsers[0]->id,
                'store_id' => $stores[3]->id,
                'visit_date' => $today->copy()->subDays(1)->format('Y-m-d'),
                'status' => 'Selesai',
                'result_status' => 'Berhasil',
                'check_in_time' => $today->copy()->subDays(1)->setTime(13, 45, 0),
                'order_value' => 2400000.00,
                'fail_reason' => null,
                'notes' => 'Restock sembako bulanan, pembayaran tunai saat barang datang.',
                'simulated_latitude' => -6.2934520,
                'simulated_longitude' => 106.7987630,
            ],
            // Selesai - Ditolak (Siti Rahma)
            [
                'user_id' => $salesUsers[1]->id,
                'store_id' => $stores[4]->id,
                'visit_date' => $today->copy()->subDays(1)->format('Y-m-d'),
                'status' => 'Selesai',
                'result_status' => 'Ditolak',
                'check_in_time' => $today->copy()->subDays(1)->setTime(15, 10, 0),
                'order_value' => 0.00,
                'fail_reason' => 'Gudang toko masih penuh dengan stok dari promo distributor lain minggu lalu.',
                'notes' => 'Toko meminta ditawarkan kembali pada tanggal 10 bulan depan.',
                'simulated_latitude' => -6.2489050,
                'simulated_longitude' => 106.8291040,
            ],
            // Direncanakan untuk Hari Ini (Budi Santoso)
            [
                'user_id' => $salesUsers[0]->id,
                'store_id' => $stores[5]->id,
                'visit_date' => $today->format('Y-m-d'),
                'status' => 'Direncanakan',
                'result_status' => null,
                'check_in_time' => null,
                'order_value' => 0.00,
                'fail_reason' => null,
                'notes' => 'Kunjungan rutin hari Rabu pagi.',
                'simulated_latitude' => null,
                'simulated_longitude' => null,
            ],
            // Direncanakan untuk Hari Ini (Siti Rahma)
            [
                'user_id' => $salesUsers[1]->id,
                'store_id' => $stores[6]->id,
                'visit_date' => $today->format('Y-m-d'),
                'status' => 'Direncanakan',
                'result_status' => null,
                'check_in_time' => null,
                'order_value' => 0.00,
                'fail_reason' => null,
                'notes' => 'Follow up penawaran produk baru biskuit & susu kemasan.',
                'simulated_latitude' => null,
                'simulated_longitude' => null,
            ],
            // Direncanakan untuk Hari Ini (Ahmad Fauzi)
            [
                'user_id' => $salesUsers[2]->id,
                'store_id' => $stores[7]->id,
                'visit_date' => $today->format('Y-m-d'),
                'status' => 'Direncanakan',
                'result_status' => null,
                'check_in_time' => null,
                'order_value' => 0.00,
                'fail_reason' => null,
                'notes' => 'Rute arah Jagakarsa sebelum makan siang.',
                'simulated_latitude' => null,
                'simulated_longitude' => null,
            ],
            // Direncanakan untuk Besok (Budi Santoso)
            [
                'user_id' => $salesUsers[0]->id,
                'store_id' => $stores[8]->id,
                'visit_date' => $today->copy()->addDay()->format('Y-m-d'),
                'status' => 'Direncanakan',
                'result_status' => null,
                'check_in_time' => null,
                'order_value' => 0.00,
                'fail_reason' => null,
                'notes' => 'Jadwal rute Kalibata.',
                'simulated_latitude' => null,
                'simulated_longitude' => null,
            ],
            // Direncanakan untuk Besok (Siti Rahma)
            [
                'user_id' => $salesUsers[1]->id,
                'store_id' => $stores[9]->id,
                'visit_date' => $today->copy()->addDay()->format('Y-m-d'),
                'status' => 'Direncanakan',
                'result_status' => null,
                'check_in_time' => null,
                'order_value' => 0.00,
                'fail_reason' => null,
                'notes' => 'Kunjungan rute Depok.',
                'simulated_latitude' => null,
                'simulated_longitude' => null,
            ],
        ];

        foreach ($visits as $v) {
            Visit::create($v);
        }
    }
}

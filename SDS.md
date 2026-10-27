A. Lingkungan & Arsitektur Teknologi
Dokumen ini mewajibkan penggunaan teknologi berikut agar sesuai dengan standar proyek:
- Framework Utama: Laravel 11 dengan konfigurasi lingkungan via .env.
- Pola Arsitektur: Wajib menggunakan pola MVC (Model-View-Controller) dengan definisi Routes yang jelas.
- Antarmuka (Frontend): Menggunakan template engine Blade, didukung oleh framework CSS Tailwind atau Bootstrap untuk memastikan tampilan konsisten dan responsif di perangkat mobile sales. Komponen UI harus dibuat reusable.
B. Desain Basis Data (Minimal 3 Entitas/Tabel Relasional)
Sistem menggunakan skema relasional dengan Migration, Seeder, dan Factory yang terkonfigurasi di Laravel:
1. users (Tabel Sales/Admin)
2. stores (Tabel Toko/Warung)
3. visits (Tabel Kunjungan/Rute - menghubungkan user dan store beserta status dan hasil transaksi).
C. Struktur Dokumentasi Proyek
Programmer diwajibkan menyertakan fail README.md atau dokumentasi terpisah yang mencakup:
1. Panduan instalasi aplikasi.
2. Daftar fitur utama.
3. Penjelasan struktur database.
4. Laporan hasil dari minimal 10 skenario pengujian. 